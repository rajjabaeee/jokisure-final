<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UiController extends Controller
{
    // AUTH
    public function splash(Request $request) { 
        // Clear all signup session data when starting fresh from splash
        $request->session()->forget('signup.data');
        $request->session()->forget('signup.otp');
        $request->session()->forget('signup.phone_verified');
        return view('auth.splash'); 
    }
    public function login()             { return view('auth.login'); }
    public function signup(Request $request) { 
        // Only clear signup session data if starting completely fresh (no signup data exists)
        if (!$request->session()->has('signup.data')) {
            $request->session()->forget('signup.otp');
            $request->session()->forget('signup.phone_verified');
        }
        return view('auth.register'); 
    }
    public function reset()             { return view('auth.reset-password'); }
    public function otp()               { return view('auth.otp-verify'); }

    // MARKETPLACE
    public function home()              { return view('marketplace.home'); }

    // ORDERS & TRANSACTIONS
    public function serviceDetailConfirm() { return view('orders.service-detail'); }
    public function boostRequest()      { return view('orders.boost-request'); }
    public function payment(Request $r) { return view('orders.payment'); }
    public function paymentSuccess(Request $r) { return view('orders.payment-success'); }
    public function myOrders()          { return view('orders.my-orders'); }
    public function orderPending()      { return view('orders.order-pending'); }
    public function orderProgress()     { return view('orders.order-progress'); }
    public function orderCompleted()    { return view('orders.order-completed'); }
    public function orderWaitlist()     { return view('orders.order-waitlist'); }
    public function trackOrderPending() { return view('orders.track-order-pending'); }
    public function trackOrderProgress(){ return view('orders.track-order-progress'); }
    public function trackOrderCompleted(){ return view('orders.track-order-completed'); }

    // USER
    public function profile()           { return view('profile.my-profile'); }
    public function editProfile()       { return view('profile.edit-profile'); }
    public function boosterProfile()    { return view('booster.profile'); }
    public function favoriteBoosters()  { return view('user.favorites-boosters'); }
    public function favoriteBoosts()    { return view('user.favorites-boosts'); }
}
