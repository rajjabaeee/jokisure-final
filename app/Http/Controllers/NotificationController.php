<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    /**
     * Display notification page with hardcoded notifications
     */
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        // Hardcoded notifications data - will be replaced with database later
        $notifications = [
            [
                'id' => 1,
                'type' => 'promo',
                'icon' => 'notification.png',
                'title' => 'Joki Promo',
                'message' => 'Get 20% off your Mythic Boost order today! Valid until 11:59 PM.',
                'time' => '2 hours ago',
                'is_read' => false
            ],
            [
                'id' => 2,
                'type' => 'order_progress',
                'icon' => 'notification.png',
                'title' => 'Order Progress',
                'message' => 'Order #JK12345 is in progress',
                'time' => '5 hours ago',
                'is_read' => false
            ],
            [
                'id' => 3,
                'type' => 'message',
                'icon' => 'notification.png',
                'title' => 'New Message from Booster',
                'message' => 'All good! Just 2 more matches left.',
                'time' => '1 day ago',
                'is_read' => true
            ]
        ];

        // Order status notifications - separate section
        $orderStatus = [
            'id' => 'JK12291',
            'status' => 'completed',
            'title' => 'Order Completed!',
            'message' => 'Order #JK12291 is completed!',
            'image' => 'childe.jpg',
            'action_text' => 'Leave a review and earn 20 loyalty coins!',
            'action_button' => 'Review'
        ];

        return view('notifications.notification', compact('notifications', 'orderStatus', 'user'));
    }

    /**
     * Mark notification as read
     */
    public function markAsRead($id)
    {
        // This will be implemented when we have database integration
        return response()->json(['success' => true]);
    }

    /**
     * Mark all notifications as read
     */
    public function markAllAsRead()
    {
        // This will be implemented when we have database integration
        return response()->json(['success' => true]);
    }
}