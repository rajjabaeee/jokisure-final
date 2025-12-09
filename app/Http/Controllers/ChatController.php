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
     * List all users that have been contacted (have messages)
     */
    public function index()
    {
        $myId = Auth::user()->user_id;

        // Get users that have messages with the current user
        $users = User::where('user_id', '!=', $myId)
            ->whereIn('user_id', function($query) use ($myId) {
                $query->select('sender_user_id')
                    ->from('chat')
                    ->where('receiver_user_id', $myId)
                    ->union(
                        \DB::table('chat')
                            ->select('receiver_user_id')
                            ->where('sender_user_id', $myId)
                    );
            })
            ->get()
            ->map(function($user) use ($myId) {
                // Get latest message with this user
                $latestChat = Chat::where(function($q) use ($myId, $user) {
                        $q->where('sender_user_id', $myId)
                          ->where('receiver_user_id', $user->user_id);
                    })
                    ->orWhere(function($q) use ($myId, $user) {
                        $q->where('sender_user_id', $user->user_id)
                          ->where('receiver_user_id', $myId);
                    })
                    ->orderBy('send_date', 'desc')
                    ->first();

                // Add latest message to user object
                $user->latest_message = $latestChat ? $latestChat->chat_msg : null;
                $user->latest_message_date = $latestChat ? $latestChat->created_at : null;

                return $user;
            });

        return view('marketplace.chat-list', compact('users'));
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
                    ->orderBy('send_date', 'asc')   // pakai send_date karena database kamu pakai itu
                    ->get();

        return view('marketplace.chat-room', compact('receiver', 'chats'));
    }

    /**
     * Send chat message
     */
    public function sendMessage(Request $request)
    {
        $request->validate([
            'message' => 'required|string',
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