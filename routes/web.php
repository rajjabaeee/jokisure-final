<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});
use App\Http\Controllers\BoosterController;

Route::get('/booster/{username?}', [BoosterController::class, 'show'])
    ->name('booster.show');

// versi demo statis (opsional):
Route::get('/booster', fn() => redirect()->route('booster.show', 'BangBoost'));


use App\Http\Controllers\ProfileController;

Route::get('/my-profile', [ProfileController::class, 'show'])->name('profile.show');
Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update.mock');

use App\Http\Controllers\OrdersController;

Route::get('/my-orders', function () {return view('orders.my-orders');})->name('orders.index');
Route::get('/orders/waitlist', [OrdersController::class, 'detailWaitlist'])->name('orders.detail.waitlist');
Route::get('/orders/pending',  [OrdersController::class, 'detailPending'])->name('orders.detail.pending');
Route::get('/orders/progress', [OrdersController::class, 'detailProgress'])->name('orders.detail.progress');
Route::get('/orders/completed',[OrdersController::class, 'detailCompleted'])->name('orders.detail.completed');
Route::get('/track-order/pending',   [OrdersController::class, 'trackPending'])->name('orders.track.pending');
Route::get('/track-order/progress',  [OrdersController::class, 'trackProgress'])->name('orders.track.progress');
Route::get('/track-order/completed', [OrdersController::class, 'trackCompleted'])->name('orders.track.completed');
