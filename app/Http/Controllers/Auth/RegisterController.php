<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Buyer;
use Illuminate\Support\Str;

class RegisterController extends Controller
{
    /**
     * Step 1: Store signup data in session (click "Verify Phone Number")
     */
    public function storeDataForOTP(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'password' => 'required|string|min:1',
            'password_confirmation' => 'required|string|same:password',
            'phone' => 'nullable|string|max:20',
        ]);

        $request->session()->put('signup.data', [
            'name' => $request->input('name'),
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
     * Step 2: Verify OTP (always true)
     */
    public function verifyOTP(Request $request)
    {
        $request->validate([
            'otp' => 'required|string',
        ]);

        $signup = $request->session()->get('signup.data');
        if (!$signup) {
            return redirect()->route('signup')->withErrors(['msg' => 'No signup data found.']);
        }

        $request->session()->put('signup.otp_verified', true);
        $request->session()->forget('signup.otp');

        return redirect()->route('signup')->with('status', 'Phone verified! Click Sign Up to complete.');
    }

    /**
     * Step 3: Final sign up - save to database
     */
    public function register(Request $request)
    {
        if (!$request->session()->get('signup.otp_verified')) {
            return redirect()->route('signup')->withErrors(['msg' => 'Please verify your phone first.']);
        }

        $signupData = $request->session()->get('signup.data');
        if (!$signupData) {
            return redirect()->route('signup')->withErrors(['msg' => 'Signup data not found.']);
        }

        // Use correct column names for the 'user' table
        // Generate unique nametag from name
        $baseNametag = strtolower(str_replace(' ', '', $signupData['name']));
        $nametag = $baseNametag . rand(100, 999);
        
        $user = User::create([
            'user_name' => $signupData['name'],
            'user_nametag' => $nametag,
            'user_email' => $signupData['email'],
            'user_password_hash' => Hash::make($signupData['password']),
            'user_number' => $signupData['phone'],
            'created_at' => now(),
        ]);

        // Automatically create buyer profile with cart_id for new user
        Buyer::create([
            'user_id' => $user->user_id,
            'cart_id' => (string) Str::uuid(),
        ]);

        $request->session()->forget('signup.data');
        $request->session()->forget('signup.otp_verified');

        return redirect()->route('login')->with('success', 'Registration successful! Please login.');
    }
}
