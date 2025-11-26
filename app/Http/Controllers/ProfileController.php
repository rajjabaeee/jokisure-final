<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ProfileController extends Controller
{
    // buat tampilan profil
    public function show()
    {
        return view('profile.my-profile');
    }

    // buat tampilan edit profile
    public function edit()
    {
        return view('profile.edit-profile');
    }

    // mock update tanpa DB (belum nyentuh PostgreSQL)
    public function update(Request $request)
    {
        // nanti logic update DB ditaruh sini
        return back()->with('status', 'Profile updated successfully (mock).');
    }
}
