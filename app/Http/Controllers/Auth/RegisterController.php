<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class RegisterController extends Controller
{
    /**
     * Step 1: Store signup data in session and redirect to OTP page
     */
    public function storeDataForOTP(Request $request)
    {
        $request->validate([
            'email' => 'required|email|max:255|unique:user,user_email',
            'password' => 'required|string|min:6',
            'password_confirmation' => 'required|string|same:password',
            'phone' => 'required|string|max:20',
        ]);

        // Auto-generate name from email if not provided
        $name = $request->input('name') ?: explode('@', $request->input('email'))[0];

        $request->session()->put('signup.data', [
            'name' => $name,
            'email' => $request->input('email'),
            'password' => $request->input('password'),
            'phone' => $request->input('phone'),
        ]);

        $code = strval(rand(1000, 9999));
        $request->session()->put('signup.otp', $code);
        $request->session()->flash('otp_code', $code);

        return redirect()->route('otp');
    }

    /**
     * Step 2: Verify OTP and redirect back to signup with verified status
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|string|min:4',
        ]);

        $signup = $request->session()->get('signup.data');
        if (!$signup) {
            return redirect()->route('signup')->withErrors(['msg' => 'No signup data found.']);
        }

        // Just mark as verified and redirect back to original signup form
        $request->session()->put('signup.phone_verified', true);
        $request->session()->forget('signup.otp');

        return redirect()->route('signup');
    }

    /**
     * Step 3: Create account after signup button clicked on verified form
     */
    public function register(Request $request)
    {
        if (!$request->session()->get('signup.phone_verified')) {
            return redirect()->route('signup')->withErrors(['msg' => 'Please verify your phone first.']);
        }

        $signup = $request->session()->get('signup.data');
        if (!$signup) {
            return redirect()->route('signup')->withErrors(['msg' => 'No signup data found.']);
        }

        // Generate unique nametag from name
        $baseNametag = strtolower(str_replace(' ', '', $signup['name']));
        $nametag = $baseNametag . rand(100, 999);
        
        User::create([
            'user_name' => $signup['name'],
            'user_nametag' => $nametag,
            'user_email' => $signup['email'],
            'user_password_hash' => Hash::make($signup['password']),
            'user_number' => $signup['phone'],
            'created_at' => now(),
        ]);

        $request->session()->forget('signup.data');
        $request->session()->forget('signup.phone_verified');

        return redirect('/login')->with('success', 'Account created successfully! Please login.');
    }
}
