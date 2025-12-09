<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UiController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\TrackOrderController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\BoosterController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\VoucherController;
use App\Http\Controllers\HomepageController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Middleware\RedirectIfAuthenticated;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\NotificationController;

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

// Public account pages (signup / reset / otp)
Route::get('/signup', [UiController::class, 'signup'])->name('signup');
// Step 1: Verify Phone Number button - stores data in session and redirects to OTP
Route::post('/signup/verify-phone', [RegisterController::class, 'storeDataForOTP'])->name('signup.verify.phone')->withoutMiddleware([RedirectIfAuthenticated::class]);
// Step 2: OTP verification (always true) - redirects back to signup
Route::get('/otp', [UiController::class, 'otp'])->name('otp');
Route::post('/otp', [RegisterController::class, 'verifyOTP'])->name('otp.verify')->withoutMiddleware([RedirectIfAuthenticated::class]);
// Step 3: Final Sign Up button - saves to database and redirects to login
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
	Route::get('/home', [HomepageController::class, 'index'])->name('home');
	Route::get('/games', [GameController::class, 'index'])->name('games.index');
	Route::get('/games/{game}', [GameController::class, 'show'])->name('games.show');
	Route::get('/boosters', [BoosterController::class, 'index'])->name('boosters');
	Route::get('/cart', [CartController::class, 'index'])->name('cart.index');
	Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
	Route::post('/cart/remove/{cartId}/{serviceId}', [CartController::class, 'remove'])->name('cart.remove');
	Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
	Route::view('/game-detail', 'marketplace.game-detail');

	// API Routes for Homepage Data
	Route::get('/api/games', [HomepageController::class, 'getGamesByGenre'])->name('api.games');
	Route::get('/api/featured-boosters', [HomepageController::class, 'getFeaturedBoosters'])->name('api.featured.boosters');

	// SERVICE DETAIL
	Route::get('/service/detail/{service?}', [UiController::class,'serviceDetailConfirm'])->name('service.detail.confirm');

	// VOUCHER / DISCOUNT API
	Route::get('/api/vouchers/available', [VoucherController::class, 'getAvailable'])->name('vouchers.available');
	Route::post('/api/vouchers/validate', [VoucherController::class, 'validateVoucher'])->name('vouchers.validate');

	// CHECKOUT (from cart)
	Route::get('/checkout', [CheckoutController::class, 'index'])->name('checkout.index');
	Route::post('/checkout', [CheckoutController::class, 'store'])->name('checkout.store');

	// ORDERS & TRANSACTIONS (Dynamic via OrderController)
	Route::get('/boost/request', [UiController::class,'boostRequest'])->name('boost.request');
	Route::post('/boost/request', [UiController::class,'storeBoostRequest'])->name('boost.request.store');
	
	// PAYMENT ROUTES (PaymentController)
	Route::get('/payment', [PaymentController::class,'index'])->name('payment');
	Route::post('/payment', [PaymentController::class,'process'])->name('payment.process');
	Route::get('/payment/success', [PaymentController::class,'success'])->name('payment.success');
	
	// ORDER CREATION
	Route::get('/orders/create', [OrderController::class, 'createOrder'])->name('orders.create');
	
	// Order listing and detail (dynamic - no status-specific static routes needed)
	Route::get('/orders', [OrderController::class, 'index'])->name('orders');
	Route::get('/orders/{order}', [OrderController::class, 'show'])->name('orders.show');
	Route::post('/orders', [OrderController::class, 'store'])->name('orders.store');
	Route::post('/orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update.status');
	
	// Order tracking (dynamic - returns appropriate track view based on status)
	Route::get('/track/{order}', [TrackOrderController::class, 'track'])->name('orders.track');
	Route::post('/track/{order}/events', [OrderController::class, 'addEvent'])->name('orders.track.event.store');

	//CHAT ROUTERS
	Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{receiverId}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/send', [ChatController::class, 'sendMessage'])->name('chat.send');

	//Review and Rating
	Route::get('/reviews', [ReviewController::class, 'listCompletedOrders'])->name('reviews');
	Route::get('/orders/{orderId}/review', [ReviewController::class, 'create'])->name('reviews.create');
	Route::post('/orders/{orderId}/review', [ReviewController::class, 'store'])->name('reviews.store');
	Route::get('/service/{serviceId}/reviews', [ReviewController::class, 'index'])->name('reviews.index');

	// NOTIFICATION ROUTES
	Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications');
	Route::post('/notifications/{id}/mark-read', [NotificationController::class, 'markAsRead'])->name('notifications.mark-read');
	Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.mark-all-read');

	// USER ROUTES
	Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
	Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
	Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update.mock');
	Route::get('/booster/profile/{booster:booster_id}', [BoosterController::class, 'show'])->name('booster.profile');
	Route::get('/favorites/boosters', [UiController::class, 'favoriteBoosters'])->name('favorite.boosters');
	Route::get('/favorites/boosts', [UiController::class, 'favoriteBoosts'])->name('favorite.boosts');

});
