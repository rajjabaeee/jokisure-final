<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;

class ChatController extends Controller
{
    /**
     * Show all chats for the authenticated user.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $chats = Chat::where('sender_id', $user->user_id)
                     ->orWhere('receiver_id', $user->user_id)
                     ->latest()
                     ->get();

        return view('marketplace.chat', compact('chats'));
    }
}
