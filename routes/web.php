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
Route::get('/orders',         [UiController::class,'myOrders'])->name('orders.index');

// USER ROUTES
Route::get('/profile',            [UiController::class, 'profile'])->name('profile');
Route::get('/profile',            [UiController::class, 'profile'])->name('profile.show');
Route::get('/profile/edit',       [UiController::class, 'editProfile'])->name('profile.edit');
Route::post('/profile/update',    [UiController::class, 'editProfile'])->name('profile.update.mock');
Route::get('/booster/profile',    [UiController::class, 'boosterProfile'])->name('booster.profile');
Route::get('/favorites/boosters', [UiController::class, 'favoriteBoosters'])->name('favorite.boosters');
Route::get('/favorites/boosts',   [UiController::class, 'favoriteBoosts'])->name('favorite.boosts');

// ORDER DETAILS
Route::get('/orders/pending',     [UiController::class, 'orderPending'])->name('order.pending');
Route::get('/orders/pending',     [UiController::class, 'orderPending'])->name('orders.detail.pending');
Route::get('/orders/progress',    [UiController::class, 'orderProgress'])->name('order.progress');
Route::get('/orders/progress',    [UiController::class, 'orderProgress'])->name('orders.detail.progress');
Route::get('/orders/completed',   [UiController::class, 'orderCompleted'])->name('order.completed');
Route::get('/orders/completed',   [UiController::class, 'orderCompleted'])->name('orders.detail.completed');
Route::get('/orders/waitlist',    [UiController::class, 'orderWaitlist'])->name('order.waitlist');
Route::get('/orders/waitlist',    [UiController::class, 'orderWaitlist'])->name('orders.detail.waitlist');
Route::get('/track/pending',      [UiController::class, 'trackOrderPending'])->name('track.order.pending');
Route::get('/track/pending',      [UiController::class, 'trackOrderPending'])->name('orders.track.pending');
Route::get('/track/progress',     [UiController::class, 'trackOrderProgress'])->name('track.order.progress');
Route::get('/track/progress',     [UiController::class, 'trackOrderProgress'])->name('orders.track.progress');
Route::get('/track/completed',    [UiController::class, 'trackOrderCompleted'])->name('track.order.completed');
Route::get('/track/completed',    [UiController::class, 'trackOrderCompleted'])->name('orders.track.completed');
