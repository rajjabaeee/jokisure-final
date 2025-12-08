<?php

namespace App\Http\Controllers;

use App\Models\PaymentMethod;
use App\Models\CartItem;
use App\Models\Buyer;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    /**
     * Display payment page with payment methods
     */
    public function index(Request $request)
    {
        // Get boost request data from session
        $boostData = session('boost_request');
        
        if (!$boostData) {
            return redirect()->route('boost.request')->with('error', 'Please fill the boost request form first');
        }

        // Fetch payment methods from database
        $paymentMethods = PaymentMethod::where('is_active', true)->get();

        // Get cart items for authenticated user
        $user = auth()->user();
        $buyer = Buyer::where('user_id', $user->user_id)->first();
        
        $cartItems = collect();
        $subtotal = 0;
        
        if ($buyer) {
            $cartItems = CartItem::where('cart_id', $buyer->cart_id)
                ->with('service.game')
                ->get();
            $subtotal = $cartItems->sum(fn($item) => $item->service->service_price);
        }

        // If cart is empty, use hardcoded value for testing
        if ($cartItems->isEmpty()) {
            $subtotal = 60000;
        }

        return view('orders.payment', compact('paymentMethods', 'cartItems', 'subtotal'));
    }

    /**
     * Process payment and create order
     */
    public function process(Request $request)
    {
        // Validate payment data
        $validated = $request->validate([
            'method_id' => 'required|uuid|exists:payment_method,method_id',
            'voucher_id' => 'nullable|uuid|exists:discount,discount_id',
            'discount_amount' => 'nullable|numeric'
        ]);

        // Get boost request data from session
        $boostData = session('boost_request');
        
        if (!$boostData) {
            return redirect()->route('boost.request')->with('error', 'Please fill the boost request form first');
        }

        // Get payment method and admin fee
        $paymentMethod = PaymentMethod::find($validated['method_id']);
        $adminFee = $paymentMethod->admin_fee ?? 0;

        // Get cart items for calculation
        $user = auth()->user();
        $buyer = Buyer::where('user_id', $user->user_id)->first();
        
        $subtotal = 60000; // Default
        if ($buyer) {
            $cartItems = CartItem::where('cart_id', $buyer->cart_id)
                ->with('service')
                ->get();
            if ($cartItems->isNotEmpty()) {
                $subtotal = $cartItems->sum(fn($item) => $item->service->service_price);
            }
        }

        // Calculate total
        $discount = $validated['discount_amount'] ?? 0;
        $total = $subtotal - $discount + $adminFee;

        // Store payment data in session for order creation
        session([
            'payment_data' => [
                'method_id' => $validated['method_id'],
                'method_name' => $paymentMethod->method_name,
                'subtotal' => $subtotal,
                'discount' => $discount,
                'admin_fee' => $adminFee,
                'total' => $total,
                'voucher_id' => $validated['voucher_id'] ?? null
            ]
        ]);

        // Redirect to order creation
        return redirect()->route('orders.create');
    }

    /**
     * Display payment success page
     */
    public function success(Request $request)
    {
        $orderData = session('order_created');
        
        if (!$orderData) {
            return redirect()->route('home')->with('error', 'No order data found');
        }
        
        return view('orders.payment-success', compact('orderData'));
    }
}
