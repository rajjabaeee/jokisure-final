<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UiController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Middleware\RedirectIfAuthenticated;

// Show splash at root (public)
Route::get('/', [UiController::class, 'splash'])->name('welcome');
Route::get('/splash', [UiController::class, 'splash'])->name('splash');

// LOGIN (always accessible; remove RedirectIfAuthenticated as failsafe)
// Use a closure for GET /login to guarantee no controller-side redirect executes.
Route::get('/login', function () {
		return view('auth.login');
})->name('login')
	->withoutMiddleware([RedirectIfAuthenticated::class]);

Route::post('/login', [LoginController::class, 'login'])
	->name('login.perform')
	->withoutMiddleware([RedirectIfAuthenticated::class]);

// Public account pages (signup / otp / reset)
Route::get('/signup', [UiController::class, 'signup'])->name('signup');
// Step 1: Store data and redirect to OTP
Route::post('/signup/verify-phone', [RegisterController::class, 'storeDataForOTP'])->name('signup.verify.phone')->withoutMiddleware([RedirectIfAuthenticated::class]);
// Step 2: OTP verification and redirect back to signup
Route::get('/otp', [UiController::class, 'otp'])->name('otp');
Route::post('/otp', [RegisterController::class, 'verifyOTP'])->name('otp.verify')->withoutMiddleware([RedirectIfAuthenticated::class]);
// Step 3: Create account after signup button clicked
Route::post('/signup', [RegisterController::class, 'register'])->name('signup.perform')->withoutMiddleware([RedirectIfAuthenticated::class]);
// Demo helper: mark OTP verified via GET (dev only)
Route::get('/otp/verify-demo', function (\Illuminate\Http\Request $request) {
    $request->session()->put('signup.otp_verified', true);
    return redirect()->route('signup')->with('status', 'Phone verified (demo). Please complete sign up.');
})->name('otp.demo.verify')->withoutMiddleware([RedirectIfAuthenticated::class]);

// Password Reset Routes
Route::get('/reset-password', [ResetPasswordController::class, 'showResetForm'])->name('reset');
Route::post('/reset-password', [ResetPasswordController::class, 'reset'])->name('password.reset.perform');

// Protected routes (requires auth)
Route::middleware('auth')->group(function () {

	Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

	// MARKETPLACE ROUTES
	Route::get('/home', [UiController::class, 'home'])->name('home');
	Route::view('/games', 'marketplace.games');
	Route::view('/boosters', 'marketplace.boosters');
	Route::view('/cart', 'marketplace.cart');
	Route::view('/chat', 'marketplace.chat');
	Route::view('/game-detail', 'marketplace.game-detail');

	// SERVICE DETAIL
	Route::get('/service/detail', [UiController::class,'serviceDetailConfirm'])->name('service.detail.confirm');

	// ORDERS & TRANSACTIONS
	Route::get('/boost/request', [UiController::class,'boostRequest'])->name('boost.request');
	Route::match(['get','post'],'/payment', [UiController::class,'payment'])->name('payment');
	Route::match(['get','post'],'/payment/success', [UiController::class,'paymentSuccess'])->name('payment.success');
	Route::get('/orders', [UiController::class,'myOrders'])->name('my.orders');

	// USER ROUTES
	Route::get('/profile', [UiController::class, 'profile'])->name('profile');
	Route::get('/profile/edit', [UiController::class, 'editProfile'])->name('profile.edit');
	Route::post('/profile/update', [UiController::class, 'editProfile'])->name('profile.update.mock');
	Route::get('/booster/profile', [UiController::class, 'boosterProfile'])->name('booster.profile');
	Route::get('/favorites/boosters', [UiController::class, 'favoriteBoosters'])->name('favorite.boosters');
	Route::get('/favorites/boosts', [UiController::class, 'favoriteBoosts'])->name('favorite.boosts');

	// ORDER DETAILS
	Route::get('/orders/pending', [UiController::class, 'orderPending'])->name('order.pending');
	Route::get('/orders/progress', [UiController::class, 'orderProgress'])->name('order.progress');
	Route::get('/orders/completed', [UiController::class, 'orderCompleted'])->name('order.completed');
	Route::get('/orders/waitlist', [UiController::class, 'orderWaitlist'])->name('order.waitlist');
	Route::get('/track/pending', [UiController::class, 'trackOrderPending'])->name('track.order.pending');
	Route::get('/track/progress', [UiController::class, 'trackOrderProgress'])->name('track.order.progress');
	Route::get('/track/completed', [UiController::class, 'trackOrderCompleted'])->name('track.order.completed');
});