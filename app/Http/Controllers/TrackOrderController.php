<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkOrder;

class TrackOrderController extends Controller
{
    /**
     * Display track order page with timeline
     */
    public function track($orderId)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $buyer = $user->buyer()->first();
        $order = WorkOrder::with(['orderItems.service.game', 'orderItems.service.booster.user', 'orderStatus', 'payments.paymentMethod'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        if (! $buyer || ! $order->orderItems->contains('buyer_id', $buyer->buyer_id)) {
            abort(403, 'Unauthorized access to order');
        }

        // Data Log Dummy buat Timeline
        $logs = collect([
            (object)['status' => 'Account logged out', 'date' => now()->subHours(2)],
            (object)['status' => 'Abyss level 12 cleared', 'date' => now()->subHours(5)],
            (object)['status' => 'Account logged in by booster', 'date' => now()->subDay()],
            (object)['status' => 'Order queued', 'date' => now()->subDays(2)]
        ]);

        return view('orders.track', compact('order', 'logs'));
    }
}
