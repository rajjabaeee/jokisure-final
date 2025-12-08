<?php

namespace App\Http\Controllers;

use App\Models\Service;
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
    public function serviceDetailConfirm(Service $service = null) 
    { 
        if ($service) {
            $service->load('game'); // Load the game relationship
        }
        return view('orders.service-detail', compact('service')); 
    }
    
    public function boostRequest(Request $request) { 
        $user = auth()->user();
        
        // Detect order source from query parameters
        if ($request->has('services')) {
            // From cart - multiple items
            session([
                'order_source' => 'cart',
                'selected_services' => $request->input('services', [])
            ]);
        } elseif ($request->has('service_id')) {
            // Direct purchase - single item
            session([
                'order_source' => 'direct',
                'service_id' => $request->input('service_id')
            ]);
        }
        
        return view('orders.boost-request', [
            'userName' => $user->user_name ?? '',
            'userEmail' => $user->user_email ?? '',
            'userPhone' => $user->user_number ?? ''
        ]);
    }
    
    public function storeBoostRequest(Request $request) {
        // Validate incoming data
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'username' => 'required|string|max:255',
            'password' => 'required|string',
            'priority' => 'required|string'
        ]);

        // Store boost request data in session
        session([
            'boost_request' => $validated
        ]);

        // Redirect to payment page
        return redirect()->route('payment');
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
