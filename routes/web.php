<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UiController;

// AUTH ROUTES
Route::get('/',               [UiController::class, 'splash'])->name('welcome');
Route::get('/login',          [UiController::class, 'login'])->name('login');
Route::get('/signup',         [UiController::class, 'signup'])->name('signup');
Route::get('/reset-password', [UiController::class, 'reset'])->name('reset');
Route::get('/otp',            [UiController::class, 'otp'])->name('otp');

// MARKETPLACE ROUTES
Route::get('/home',           [UiController::class, 'home'])->name('home');
Route::view('/games', 'marketplace.games');
Route::view('/boosters', 'marketplace.boosters');
Route::view('/cart', 'marketplace.cart');
Route::view('/chat', 'marketplace.chat');
Route::view('/game-detail', 'marketplace.game-detail');

// SERVICE DETAIL
Route::get('/service/detail', [UiController::class,'serviceDetailConfirm'])->name('service.detail.confirm');

// ORDERS & TRANSACTIONS
Route::get('/boost/request',  [UiController::class,'boostRequest'])->name('boost.request');
Route::match(['get','post'],'/payment', [UiController::class,'payment'])->name('payment');
Route::match(['get','post'],'/payment/success', [UiController::class,'paymentSuccess'])->name('payment.success');
Route::get('/orders',         [UiController::class,'myOrders'])->name('my.orders');

// USER ROUTES
Route::get('/profile',            [UiController::class, 'profile'])->name('profile');
Route::get('/favorites/boosters', [UiController::class, 'favoriteBoosters'])->name('favorite.boosters');
Route::get('/favorites/boosts',   [UiController::class, 'favoriteBoosts'])->name('favorite.boosts');
