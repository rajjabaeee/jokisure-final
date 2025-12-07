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
        $request->session()->forget('signup.otp_verified');
        return view('auth.splash'); 
    }
    public function login()             { return view('auth.login'); }
    public function signup(Request $request) { 
        // Clear any old signup session data when entering signup page fresh
        if (!$request->session()->has('signup.otp_verified')) {
            $request->session()->forget('signup.data');
            $request->session()->forget('signup.otp');
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
    
    public function storeBoostRequest(Request $request) {
        // Validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'username' => 'required|string|max:255',
            'password' => 'required|string',
            'priority' => 'required|in:vip_plus,vip,same_day,regular'
        ]);

        // Store boost request data in session
        session([
            'boost_request' => $validated
        ]);

        // Redirect to payment page
        return redirect()->route('payment');
    }
    
    public function payment(Request $r) { return view('orders.payment'); }
    
    public function processPayment(Request $request) {
        // Validate payment method
        $validated = $request->validate([
            'method' => 'required|string',
            'voucher_id' => 'nullable|string',
            'discount_amount' => 'nullable|numeric'
        ]);

        // Get boost request data from session
        $boostData = session('boost_request');
        
        if (!$boostData) {
            return redirect()->route('boost.request')->with('error', 'Please fill the boost request form first');
        }

        // Calculate pricing (hardcoded for now)
        $subtotal = 60000;
        $tax = 5000;
        $discount = $validated['discount_amount'] ?? 0;
        $total = $subtotal - $discount + $tax;

        // Store payment result in session
        session([
            'payment_result' => [
                'total' => $total,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'tax' => $tax,
                'voucher_id' => $validated['voucher_id'] ?? null,
                'payment_method' => $validated['method'],
                'order_id' => 'ORD-' . strtoupper(uniqid()) // Temporary mock order ID
            ]
        ]);

        // Redirect to success page
        return redirect()->route('payment.success');
    }
    
    public function paymentSuccess(Request $r) { 
        $paymentResult = session('payment_result');
        
        if (!$paymentResult) {
            return redirect()->route('home')->with('error', 'No payment data found');
        }
        
        return view('orders.payment-success', compact('paymentResult')); 
    }
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
