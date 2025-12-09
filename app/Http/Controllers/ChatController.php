<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Chat;
use App\Models\User;
use Carbon\Carbon;

class ChatController extends Controller
{
    /**
     * List all users except current logged-in user
     */
    public function index()
    {
        $myId = Auth::user()->user_id;

        // Ambil semua user kecuali diri sendiri
        $users = User::where('user_id', '!=', $myId)->get();

        // Tambah properti last_chat ke setiap user (dipakai di Blade)
        $users->each(function ($user) use ($myId) {
            $user->last_chat = Chat::lastBetween($myId, $user->user_id);
        });

        return view('marketplace.chat_list', compact('users'));
    }

    /**
     * Show chat room with selected receiver
     */
    public function show($receiverId)
    {
        $myId = Auth::user()->user_id;

        $receiver = User::where('user_id', $receiverId)->firstOrFail();

        // Get both sides of conversation
        $chats = Chat::where(function ($q) use ($myId, $receiverId) {
                        $q->where('sender_user_id', $myId)
                          ->where('receiver_user_id', $receiverId);
                    })
                    ->orWhere(function ($q) use ($myId, $receiverId) {
                        $q->where('sender_user_id', $receiverId)
                          ->where('receiver_user_id', $myId);
                    })
                    ->orderBy('send_date', 'asc')
                    ->get();

        return view('marketplace.chat_room', compact('receiver', 'chats'));
    }

    /**
     * Send chat message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message'          => 'required|string',
            'receiver_user_id' => 'required|exists:user,user_id',
        ]);

        $chat = Chat::create([
            'sender_user_id'   => Auth::user()->user_id,
            'receiver_user_id' => $request->receiver_user_id,
            'chat_msg'         => $request->message,
            'send_date'        => Carbon::now(),
        ]);

        // Return JSON if AJAX request
        if ($request->wantsJson()) {
            return response()->json([
                'success' => true,
                'chat_id' => $chat->chat_id,
                'message' => $chat->chat_msg,
                'sent_at' => $chat->created_at->format('H:i a'),
            ]);
        }

        return redirect()->route('chat.show', $request->receiver_user_id);
    }
}