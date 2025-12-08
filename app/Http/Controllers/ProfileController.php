<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class ProfileController extends Controller
{
    /**
     * Show the authenticated user's profile.
     */
    public function show(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('profile.my-profile', compact('user'));
    }

    /**
     * Show the edit profile form.
     */
    public function edit(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('profile.edit-profile', compact('user'));
    }

    /**
     * Update the user profile.
     */
    public function update(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Validate input data
        $request->validate([
            'name' => 'required|string|max:255',
            'nametag' => 'nullable|string|max:50|unique:user,user_nametag,' . $user->user_id . ',user_id',
            'phone' => 'nullable|string|max:20',
            'email' => 'required|email|unique:user,user_email,' . $user->user_id . ',user_id',
            'profile_pic' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048'
        ]);

        // Clean nametag (remove @ if present)
        $nametag = $request->nametag;
        if ($nametag && str_starts_with($nametag, '@')) {
            $nametag = substr($nametag, 1);
        }

        // Update user data
        $user->user_name = $request->name;
        $user->user_nametag = $nametag;
        $user->user_number = $request->phone ? '+62' . ltrim($request->phone, '0') : null;
        $user->user_email = $request->email;

        // Handle profile picture upload if provided
        if ($request->hasFile('profile_pic')) {
            $file = $request->file('profile_pic');
            $filename = time() . '_' . $file->getClientOriginalName();
            $path = $file->storeAs('profile_pics', $filename, 'public');
            $user->user_profile_pic = $path;
        }

        $user->save();

        return redirect()->route('profile.show')->with('success', 'Profile updated successfully');
    }

    /**
     * Show the account details page.
     */
    public function account(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('profile.account', compact('user'));
    }

    /**
     * Show the settings page.
     */
    public function settings(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        return view('profile.settings', compact('user'));
    }
}
