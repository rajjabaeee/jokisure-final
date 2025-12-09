<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkOrder;
use App\Models\Review;
use App\Models\OrderStatus;
use App\Models\Service;

class ReviewController extends Controller
{
    public function listCompletedOrders()
    {
        // Get all orders for the authenticated user (including incomplete ones for demo)
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $buyer = $user->buyer()->first();
        if (!$buyer) {
            $completedOrders = collect();
        } else {
            $completedOrders = WorkOrder::whereHas('orderItems', function ($q) use ($buyer) {
                $q->where('buyer_id', $buyer->buyer_id);
            })
            ->with(['orderItems.service.game', 'orderItems.service.booster.user', 'orderStatus'])
            ->orderBy('order_date', 'desc')
            ->get();
        }

        return view('reviews.review-list', compact('completedOrders'));
    }

    public function create($orderId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $buyer = $user->buyer()->first();
        $order = WorkOrder::with(['orderItems.service.game', 'orderItems.service.booster.user', 'orderStatus'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        // Ensure this order belongs to the authenticated buyer and is completed
        if (!$buyer || !$order->orderItems->contains('buyer_id', $buyer->buyer_id)) {
            abort(403, 'Unauthorized access to order');
        }

        if ($order->orderStatus->order_status_name !== 'Completed') {
            return redirect()->back()->with('error', 'You can only review completed orders.');
        }

        $item = $order->orderItems->first();

        return view('reviews.create-review', compact('order', 'item'));
    }

    public function store(Request $request, $orderId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $request->validate([
            'user_rating' => 'required|integer|min:1|max:5',
            'user_review' => 'required|string|max:500',
        ]);

        $buyer = $user->buyer()->first();
        $order = WorkOrder::with(['orderItems.service'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        if (!$buyer || !$order->orderItems->contains('buyer_id', $buyer->buyer_id)) {
            abort(403, 'Unauthorized access to order');
        }

        $item = $order->orderItems->first();
        $service = $item->service;

        // Create review in database
        Review::create([
            'service_id' => $service->service_id,
            'buyer_id' => $buyer->buyer_id,
            'user_rating' => $request->user_rating,
            'user_review' => $request->user_review,
        ]);

        return redirect()->route('reviews')
                         ->with('success', 'Review successfully added!');
    }

    public function index($serviceId)
    {
        // Get reviews from database with buyer information
        $reviews = Review::where('service_id', $serviceId)
            ->with('buyer.user')
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($review) {
                return [
                    'buyer_name' => $review->buyer?->user?->user_name ?? 'Anonymous',
                    'rating' => $review->user_rating,
                    'review_text' => $review->user_review,
                    'created_at' => $review->created_at,
                ];
            });

        // Get service information with game
        $service = Service::with('game')->find($serviceId);
        if (!$service) {
            abort(404, 'Service not found');
        }

        return view('reviews.review-index', compact('reviews', 'service'));
    }

    /**
     * Mark an order as completed (Demo purposes only)
     */
    public function markAsComplete($orderId)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $buyer = $user->buyer()->first();
        $order = WorkOrder::where('order_id', $orderId)->firstOrFail();

        if (!$buyer || !$order->orderItems->contains('buyer_id', $buyer->buyer_id)) {
            abort(403, 'Unauthorized access to order');
        }

        // Get the "Completed" status
        $completedStatus = OrderStatus::where('order_status_name', 'Completed')->first();
        if ($completedStatus) {
            $order->update(['order_status_id' => $completedStatus->order_status_id]);
        }

        return redirect()->route('reviews')->with('success', 'Order marked as completed (Demo).');
    }
}