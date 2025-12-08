<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class ResetPasswordController extends Controller
{
    /**
     * Show reset password form
     */
    public function showResetForm()
    {
        return view('auth.reset-password');
    }

    /**
     * Handle password reset
     */
    public function reset(Request $request)
    {
        $request->validate([
            'identity' => 'required|string',
            'password' => 'required|string|min:6|confirmed',
        ]);

        $identity = $request->input('identity');
        $newPassword = $request->input('password');

        // Find user by email or username
        $user = User::where('user_email', $identity)
            ->orWhere('user_name', $identity)
            ->orWhere('user_nametag', $identity)
            ->first();

        if (!$user) {
            return back()
                ->withErrors(['identity' => 'User not found with this email or username.'])
                ->withInput($request->only('identity'));
        }

        // Update password in database
        $user->update([
            'user_password_hash' => Hash::make($newPassword)
        ]);

        // Redirect back to login with identity filled
        return redirect()->route('login')
            ->with('reset_identity', $identity); // Pass identity back to login form
    }
}