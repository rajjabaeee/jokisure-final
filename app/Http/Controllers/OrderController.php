<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\WorkOrder;
use App\Models\Buyer;
use App\Models\WorkOrderEvent;
use App\Models\OrderStatus;
use App\Models\OrderItem;
use App\Models\Payment;
use App\Models\CartItem;
use App\Models\BoostPriority;

class OrderController extends Controller
{
    /**
     * Display a listing of the authenticated user's orders.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        // Try to find buyer record for this user
        $buyer = $user->buyer()->first();

        if (! $buyer) {
            // no orders for non-buyers
            $orders = collect();
        } else {
            // Fetch work orders that have order items belonging to this buyer
            $orders = WorkOrder::whereHas('orderItems', function ($q) use ($buyer) {
                $q->where('buyer_id', $buyer->buyer_id);
            })
            ->with(['orderItems.service.game', 'orderStatus'])
            ->orderBy('order_date', 'desc')
            ->get();
        }

        return view('orders.my-orders', compact('orders'));
    }

    /**
     * Display the specified order details.
     */
    public function show($orderId)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $buyer = $user->buyer()->first();

        $order = WorkOrder::with(['orderItems.service.game', 'orderStatus', 'payments'])
            ->where('order_id', $orderId)
            ->firstOrFail();

        // Ensure this order belongs to the authenticated buyer
        if (! $buyer || ! $order->orderItems->contains('buyer_id', $buyer->buyer_id)) {
            abort(403, 'Unauthorized access to order');
        }

        // Choose a detail view based on status name
        $statusName = strtolower($order->orderStatus->order_status_name ?? '');
        if (str_contains($statusName, 'pending')) {
            return view('orders.order-pending', compact('order'));
        }
        if (str_contains($statusName, 'wait')) {
            return view('orders.order-waitlist', compact('order'));
        }
        if (str_contains($statusName, 'progress') || str_contains($statusName, 'on progress')) {
            return view('orders.order-progress', compact('order'));
        }
        if (str_contains($statusName, 'complete')) {
            return view('orders.order-completed', compact('order'));
        }

        // default fallback
        return view('orders.order-pending', compact('order'));
    }

    /**
     * Update order status (simple endpoint used by admin/booster UI or webhook).
     */
    public function updateStatus(Request $request, $orderId)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $order = WorkOrder::where('order_id', $orderId)->firstOrFail();

        $this->validate($request, [
            'status_id' => 'nullable|integer|exists:order_status,order_status_id',
            'status' => 'nullable|string'
        ]);

        if ($request->filled('status_id')) {
            $order->order_status_id = $request->input('status_id');
        } elseif ($request->filled('status')) {
            $status = OrderStatus::where('order_status_name', $request->input('status'))->first();
            if (! $status) {
                $status = OrderStatus::create(['order_status_name' => $request->input('status')]);
            }
            $order->order_status_id = $status->order_status_id;
        }

        $order->save();

        return redirect()->back()->with('success', 'Order status updated');
    }

    /**
     * Track view for an order — returns a tracking page depending on status.
     */
    public function track($orderId)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $buyer = $user->buyer()->first();
        $order = WorkOrder::with(['orderItems.service.game', 'orderStatus', 'payments.paymentMethod'])->where('order_id', $orderId)->firstOrFail();

        if (! $buyer || ! $order->orderItems->contains('buyer_id', $buyer->buyer_id)) {
            abort(403, 'Unauthorized access to order');
        }

        $statusName = strtolower($order->orderStatus->order_status_name ?? '');
        if (str_contains($statusName, 'complete')) {
            return view('orders.track-order-completed', compact('order'));
        }
        if (str_contains($statusName, 'progress')) {
            return view('orders.track-order-progress', compact('order'));
        }
        // default to pending track view
        return view('orders.track-order-pending', compact('order'));
    }

    /**
     * Store a timeline event for an order.
     */
    public function addEvent(Request $request, $orderId)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $order = WorkOrder::where('order_id', $orderId)->firstOrFail();
        $buyer = $user->buyer()->first();
        if (! $buyer || ! $order->orderItems->contains('buyer_id', $buyer->buyer_id)) {
            abort(403, 'Unauthorized');
        }

        $data = $request->validate([
            'event_type' => 'nullable|string|max:100',
            'description' => 'required|string|max:2000'
        ]);

        WorkOrderEvent::create([
            'order_id' => $order->order_id,
            'event_type' => $data['event_type'] ?? null,
            'description' => $data['description'],
            'created_at' => now()
        ]);

        return redirect()->back()->with('success', 'Event added');
    }

    /**
     * Create new order from boost request and payment data
     */
    public function createOrder(Request $request)
    {
        $user = Auth::user();
        if (!$user) {
            return redirect()->route('login');
        }

        $buyer = $user->buyer()->first();
        if (!$buyer) {
            return back()->with('error', 'Buyer profile not found.');
        }

        // Get data from session
        $boostData = session('boost_request');
        $paymentData = session('payment_data');
        $orderSource = session('order_source', 'cart');

        if (!$boostData || !$paymentData) {
            return redirect()->route('boost.request')->with('error', 'Missing order data. Please start again.');
        }

        // Get boost priority by name
        $boostPriority = BoostPriority::where('boost_priority_name', $boostData['priority'])->first();
        if (!$boostPriority) {
            return back()->with('error', 'Invalid boost priority selected.');
        }

        // Get order status "Pending"
        $orderStatus = OrderStatus::where('order_status_name', 'Pending')->first();
        if (!$orderStatus) {
            return back()->with('error', 'Order status not configured. Please contact support.');
        }

        // Get items based on order source
        $items = collect();
        
        if ($orderSource === 'cart') {
            // From cart - get selected items only
            $selectedServices = session('selected_services', []);
            
            if (empty($selectedServices)) {
                return back()->with('error', 'No items selected.');
            }
            
            $items = CartItem::where('cart_id', $buyer->cart_id)
                ->whereIn('service_id', $selectedServices)
                ->with('service')
                ->get();
                
            if ($items->isEmpty()) {
                return back()->with('error', 'Selected items not found in cart.');
            }
        } else {
            // Direct purchase - get single service
            $serviceId = session('service_id');
            
            if (!$serviceId) {
                return back()->with('error', 'Service not found.');
            }
            
            $service = \App\Models\Service::find($serviceId);
            
            if (!$service) {
                return back()->with('error', 'Service not found.');
            }
            
            // Wrap service as cart item for unified processing
            $items = collect([
                (object)[
                    'service_id' => $service->service_id,
                    'service' => $service
                ]
            ]);
        }

        // Create work order
        $workOrder = WorkOrder::create([
            'boost_priority_id' => $boostPriority->boost_priority_id,
            'order_date' => now(),
            'order_status_id' => $orderStatus->order_status_id,
            'subtotal_amount' => $paymentData['subtotal'],
            'discount_id' => $paymentData['voucher_id'],
            'discount_amount' => $paymentData['discount'],
            'total_amount' => $paymentData['total']
        ]);

        // Create order items
        foreach ($items as $item) {
            OrderItem::create([
                'order_id' => $workOrder->order_id,
                'buyer_id' => $buyer->buyer_id,
                'service_id' => $item->service_id,
                'quantity' => 1,
                'item_subtotal' => $item->service->service_price,
                'game_username' => $boostData['username'],
                'game_password_encrypt' => encrypt($boostData['password']),
                'contact_name' => $boostData['name'],
                'contact_email' => $boostData['email'],
                'contact_phone' => $boostData['phone']
            ]);
        }

        // Create payment record
        Payment::create([
            'order_id' => $workOrder->order_id,
            'buyer_id' => $buyer->buyer_id,
            'method_id' => $paymentData['method_id'],
            'payment_status_id' => $orderStatus->order_status_id,
            'gateway_reference' => null,
            'latest_update' => now()
        ]);

        // Delete cart items only if order source is cart
        if ($orderSource === 'cart') {
            $selectedServices = session('selected_services', []);
            CartItem::where('cart_id', $buyer->cart_id)
                ->whereIn('service_id', $selectedServices)
                ->delete();
        }

        // Store order info for success page
        session([
            'order_created' => [
                'order_id' => $workOrder->order_id,
                'total' => $paymentData['total'],
                'payment_method' => $paymentData['method_name']
            ]
        ]);

        // Clear session data
        session()->forget(['boost_request', 'payment_data', 'order_source', 'selected_services', 'service_id']);

        // Redirect to payment success
        return redirect()->route('payment.success');
    }

    /**
     * Basic store method to create a new work order.
     * Note: This is a minimal implementation — adapt to your real checkout flow.
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        if (! $user) {
            return redirect()->route('login');
        }

        $buyer = $user->buyer()->first();
        if (! $buyer) {
            return back()->with('error', 'Buyer profile not found.');
        }

        $data = $request->validate([
            'subtotal' => 'required|numeric',
            'total' => 'required|numeric',
            'items' => 'required|array',
            'items.*.service_id' => 'required',
            'items.*.quantity' => 'required|integer|min:1'
        ]);

        $order = WorkOrder::create([
            'boost_priority_id' => $request->get('boost_priority_id', null),
            'order_date' => now(),
            'order_status_id' => $request->get('order_status_id', 1),
            'subtotal_amount' => $data['subtotal'],
            'discount_id' => null,
            'discount_amount' => 0,
            'total_amount' => $data['total']
        ]);

        // create order items
        foreach ($data['items'] as $it) {
            $order->orderItems()->create([
                'buyer_id' => $buyer->buyer_id,
                'service_id' => $it['service_id'],
                'quantity' => $it['quantity'],
                'item_subtotal' => $it['subtotal'] ?? 0
            ]);
        }

        return redirect()->route('orders.index')->with('success', 'Order created');
    }
}
