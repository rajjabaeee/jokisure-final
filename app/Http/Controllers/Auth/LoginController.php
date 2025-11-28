<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    /**
     * Show login view ALWAYS (no redirect).
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Handle login.
     *
     * Priority:
     *  1) DEV bypass (if enabled: DEV_LOGIN_BYPASS=true and DEV_BYPASS_PASSWORD matches)
     *  2) Plain-text DB compare (user_password_hash stored as plaintext)
     *  3) password_verify() for hashed passwords
     *
     * Request fields expected:
     *  - identity (email or username)
     *  - password
     */
    public function login(Request $request)
    {
        $request->validate([
            'identity' => 'required|string',
            'password' => 'required|string',
        ]);

        $identity = $request->input('identity');
        $inputPw  = $request->input('password');

        // Find user by email or username (adjust column names if needed)
        $user = User::where('user_email', $identity)
            ->orWhere('user_name', $identity)
            ->first();

        if (! $user) {
            // For demo: create a simple user record when not found so the
            // submitted credentials are saved to the database and the user
            // can proceed immediately. This keeps the demo flow smooth.
            try {
                $isEmail = filter_var($identity, FILTER_VALIDATE_EMAIL) !== false;
                if ($isEmail) {
                    $user = User::create([
                        'name' => explode('@', $identity)[0] ?? $identity,
                        'email' => $identity,
                        'password' => \Illuminate\Support\Facades\Hash::make($inputPw),
                    ]);
                } else {
                    $user = User::create([
                        'name' => $identity,
                        'email' => null,
                        'password' => \Illuminate\Support\Facades\Hash::make($inputPw),
                    ]);
                }
            } catch (\Exception $e) {
                // If create fails, fall back to returning an error to the login form
                return back()
                    ->withErrors(['identity' => 'User not found and could not be created.'])
                    ->withInput($request->only('identity'));
            }
        }

        // 1) DEV bypass (highest priority)
        $bypassEnabled = env('DEV_LOGIN_BYPASS') === true
            || env('DEV_LOGIN_BYPASS') === 'true'
            || env('DEV_LOGIN_BYPASS') === '1';

        $bypassPassword = env('DEV_BYPASS_PASSWORD', '');

        if ($bypassEnabled && ! empty($bypassPassword) && $inputPw === (string) $bypassPassword) {
            // Force login for demo
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        // 2) Compare with DB-stored password (could be plaintext)
        $stored = (string) ($user->user_password_hash ?? '');

        if (!empty($stored) && hash_equals($stored, $inputPw)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        // 3) Try password_verify (for hashed passwords)
        if (!empty($stored) && password_verify($inputPw, $stored)) {
            Auth::login($user);
            $request->session()->regenerate();
            return redirect()->route('home');
        }

        // Authentication failed
        return back()
            ->withErrors(['identity' => 'Invalid credentials.'])
            ->withInput($request->only('identity'));
    }

    /**
     * Logout user.
     */
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login');
    }
}
