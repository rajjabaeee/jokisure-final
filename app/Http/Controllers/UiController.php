<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UiController extends Controller
{
    // AUTH
    public function splash()            { return view('auth.splash'); }
    public function login()             { return view('auth.login'); }
    public function signup()            { return view('auth.register'); }
    public function reset()             { return view('auth.reset-password'); }
    public function otp()               { return view('auth.otp-verify'); }

    // MARKETPLACE
    public function home()              { return view('marketplace.home'); }

    // ORDERS & TRANSACTIONS
    public function serviceDetailConfirm() { return view('orders.service-detail'); }
    public function boostRequest()      { return view('orders.boost-request'); }
    public function payment(Request $r) { return view('orders.payment'); }
    public function paymentSuccess(Request $r) { return view('orders.payment-success'); }
    public function myOrders()          { return view('orders.list'); }

    // USER
    public function profile()           { return view('user.profile'); }
    public function favoriteBoosters()  { return view('user.favorites-boosters'); }
    public function favoriteBoosts()    { return view('user.favorites-boosts'); }
}
