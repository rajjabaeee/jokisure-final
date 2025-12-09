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

        // Get cart items based on order source
        $user = auth()->user();
        $buyer = Buyer::where('user_id', $user->user_id)->first();
        
        $cartItems = collect();
        $subtotal = 0;
        
        $orderSource = session('order_source', 'cart');
        
        if ($orderSource === 'cart') {
            // From cart - fetch only selected items
            $selectedServices = session('selected_services', []);
            
            if ($buyer && !empty($selectedServices)) {
                $cartItems = CartItem::where('cart_id', $buyer->cart_id)
                    ->whereIn('service_id', $selectedServices)
                    ->with('service.game')
                    ->get();
                $subtotal = $cartItems->sum(fn($item) => $item->service->service_price);
            }
            
            // Fallback if no items found
            if ($cartItems->isEmpty()) {
                $subtotal = 60000;
            }
        } else {
            // Direct purchase - fetch single service
            $serviceId = session('service_id');
            
            if ($serviceId) {
                $service = \App\Models\Service::with('game')->find($serviceId);
                
                if ($service) {
                    // Wrap service as cart item for view compatibility
                    $cartItems = collect([
                        (object)[
                            'service' => $service,
                            'service_id' => $service->service_id
                        ]
                    ]);
                    $subtotal = $service->service_price;
                }
            }
            
            // Fallback if service not found
            if ($cartItems->isEmpty()) {
                $subtotal = 60000;
            }
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

        // Get cart items for calculation based on order source
        $user = auth()->user();
        $buyer = Buyer::where('user_id', $user->user_id)->first();
        
        $subtotal = 0;
        $orderSource = session('order_source', 'cart');
        
        if ($orderSource === 'cart') {
            // From cart - calculate from selected items
            $selectedServices = session('selected_services', []);
            
            if ($buyer && !empty($selectedServices)) {
                $cartItems = CartItem::where('cart_id', $buyer->cart_id)
                    ->whereIn('service_id', $selectedServices)
                    ->with('service')
                    ->get();
                $subtotal = $cartItems->sum(fn($item) => $item->service->service_price);
            }
        } else {
            // Direct purchase - get single service price
            $serviceId = session('service_id');
            
            if ($serviceId) {
                $service = \App\Models\Service::find($serviceId);
                if ($service) {
                    $subtotal = $service->service_price;
                }
            }
        }
        
        // Fallback if no items found
        if ($subtotal == 0) {
            return back()->with('error', 'Unable to calculate order total. Please try again.');
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
