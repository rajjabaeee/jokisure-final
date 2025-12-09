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
    /**
     * Verify user authentication
     */
    private function verifyAuth()
    {
        $user = Auth::user();
        if (!$user) {
            redirect()->route('login')->send();
            exit;
        }
        return $user;
    }

    /**
     * Verify buyer authorization for order
     */
    private function verifyBuyerAccess($order)
    {
        $user = $this->verifyAuth();
        $buyer = $user->buyer()->first();
        
        if (!$buyer || !$order->orderItems->contains('buyer_id', $buyer->buyer_id)) {
            abort(403, 'Unauthorized access to order');
        }
        
        return $buyer;
    }

    public function listCompletedOrders()
    {
        $user = $this->verifyAuth();
        
        $buyer = $user->buyer()->first();
        if (!$buyer) {
            $completedOrders = collect();
        } else {
            $completedOrders = WorkOrder::whereHas('orderItems', function ($q) use ($buyer) {
                $q->where('buyer_id', $buyer->buyer_id);
            })
            ->with(['orderItems.service.game', 'orderStatus'])
            ->orderBy('order_date', 'desc')
            ->get()
            ->map(function ($order) {
                // Get review for this order if it exists
                $item = $order->orderItems->first();
                if ($item) {
                    $review = Review::where('service_id', $item->service->service_id)
                        ->where('buyer_id', $item->buyer_id)
                        ->first();
                    $order->review = $review;
                }
                return $order;
            });
        }

        return view('reviews.review-list', compact('completedOrders'));
    }

    public function create($orderId)
    {
        $order = WorkOrder::with(['orderItems.service.game', 'orderStatus'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        $this->verifyBuyerAccess($order);

        if ($order->orderStatus->order_status_name !== 'Completed') {
            return redirect()->back()->with('error', 'You can only review completed orders.');
        }

        $item = $order->orderItems->first();
        if (!$item) {
            abort(404, 'Order item not found');
        }

        return view('reviews.create-review', compact('order', 'item'));
    }

    public function store(Request $request, $orderId)
    {
        $request->validate([
            'user_rating' => 'required|integer|min:1|max:5',
            'user_review' => 'required|string|max:500',
        ]);

        $order = WorkOrder::with(['orderItems.service'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        $buyer = $this->verifyBuyerAccess($order);

        $item = $order->orderItems->first();
        if (!$item) {
            abort(404, 'Order item not found');
        }
        
        $service = $item->service;

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
        $order = WorkOrder::where('order_id', $orderId)->firstOrFail();
        $this->verifyBuyerAccess($order);

        $completedStatus = OrderStatus::where('order_status_name', 'Completed')->first();
        if (!$completedStatus) {
            return redirect()->route('reviews')->with('error', 'Completed status not found');
        }

        $order->update(['order_status_id' => $completedStatus->order_status_id]);

        return redirect()->route('reviews')->with('success', 'Order marked as completed (Demo).');
    }
}