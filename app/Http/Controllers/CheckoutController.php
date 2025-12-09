<?php
/**
 * Author: Razza Ibrahmwibowo Muktiadi/5026231224
 * Feature: Checkout Order
 */

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\WorkOrder;
use App\Models\OrderItem;
use App\Models\Buyer;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Show checkout page with cart items summary
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $buyer = Buyer::where('user_id', $user->user_id)->first();

        $cartItems = collect();
        if ($buyer) {
            $cartItems = CartItem::where('cart_id', $buyer->cart_id)
                ->with('service.booster', 'service.game')
                ->get();
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Your cart is empty');
        }

        // Filter by selected services if provided
        $selectedServices = $request->query('services', []);
        if (!is_array($selectedServices)) {
            $selectedServices = [$selectedServices];
        }

        if (!empty($selectedServices)) {
            $cartItems = $cartItems->whereIn('service_id', $selectedServices);
        }

        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Selected items not found');
        }

        $subtotal = $cartItems->sum(fn($item) => $item->service->service_price);
        $selectedServicesJson = json_encode($selectedServices);

        return view('orders.checkout', compact('cartItems', 'subtotal', 'buyer', 'selectedServicesJson'));
    }

    /**
     * Process checkout and create order
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'game_username' => 'required|string|max:100',
            'game_password' => 'required|string',
            'boost_priority_id' => 'required|exists:boost_priority,boost_priority_id',
            'selected_services' => 'required|json',
        ]);

        $user = auth()->user();
        $buyer = Buyer::where('user_id', $user->user_id)->first();

        if (!$buyer) {
            return back()->with('error', 'Buyer profile not found');
        }

        // Get selected service IDs
        $selectedServiceIds = json_decode($validated['selected_services'], true);
        if (empty($selectedServiceIds)) {
            return back()->with('error', 'Please select at least one item');
        }

        // Get only the selected cart items
        $cartItems = CartItem::where('cart_id', $buyer->cart_id)
            ->whereIn('service_id', $selectedServiceIds)
            ->with('service')
            ->get();

        if ($cartItems->isEmpty()) {
            return back()->with('error', 'Selected items not found in cart');
        }

        // Calculate subtotal from selected items only
        $subtotal = $cartItems->sum(fn($item) => $item->service->service_price);

        // Get pending order status
        $orderStatus = OrderStatus::where('order_status_name', 'Pending')->first();
        if (!$orderStatus) {
            return back()->with('error', 'Order status not found. Please contact support.');
        }

        // Create work order
        $workOrder = WorkOrder::create([
            'boost_priority_id' => $validated['boost_priority_id'],
            'order_status_id' => $orderStatus->order_status_id,
            'subtotal_amount' => $subtotal,
            'discount_id' => null,
            'discount_amount' => 0,
            'total_amount' => $subtotal,
        ]);

        // Create order items from selected cart items
        foreach ($cartItems as $cartItem) {
            OrderItem::create([
                'order_id' => $workOrder->order_id,
                'buyer_id' => $buyer->buyer_id,
                'service_id' => $cartItem->service_id,
                'quantity' => 1,
                'item_subtotal' => $cartItem->service->service_price,
                'game_username' => $validated['game_username'],
                'game_password_encrypt' => encrypt($validated['game_password']),
            ]);
        }

        // Delete only the selected cart items
        CartItem::where('cart_id', $buyer->cart_id)
            ->whereIn('service_id', $selectedServiceIds)
            ->delete();

        // Store order ID in session and redirect to payment
        session(['order_id' => $workOrder->order_id]);

        return redirect()->route('payment')->with('success', 'Order created successfully');
    }
}
