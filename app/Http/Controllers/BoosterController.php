<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class BoosterController extends Controller
{
    /**
     * Show a booster's profile by ID.
     */
    public function show($boosterId)
    {
        // Fetch booster by ID (assuming booster is a User with role 'booster')
        $booster = User::findOrFail($boosterId);

        return view('booster.profile', compact('booster'));
    }
}
