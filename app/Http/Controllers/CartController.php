<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Models\Service;
use App\Models\Buyer;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display cart items for the authenticated user
     */
    public function index()
    {
        $user = auth()->user();
        $buyer = Buyer::where('user_id', $user->user_id)->first();
        
        $cartItems = collect();
        if ($buyer) {
            $cartItems = CartItem::where('cart_id', $buyer->cart_id)
                ->with('service.booster', 'service.game')
                ->get();
        }

        return view('marketplace.cart', compact('cartItems'));
    }

    /**
     * Add a service to the cart
     */
    public function add(Request $request)
    {
        $request->validate([
            'service_id' => 'required|exists:service,service_id',
        ]);

        $user = auth()->user();
        $buyer = Buyer::where('user_id', $user->user_id)->first();

        if (!$buyer) {
            return back()->with('error', 'Buyer profile not found');
        }

        $existingItem = CartItem::where('cart_id', $buyer->cart_id)
            ->where('service_id', $request->service_id)
            ->first();

        if ($existingItem) {
            return back()->with('info', 'Service already in cart');
        }

        CartItem::create([
            'cart_id' => $buyer->cart_id,
            'service_id' => $request->service_id,
        ]);

        return redirect()->route('cart.index')->with('success', 'Service added to cart');
    }

    /**
     * Remove a service from the cart
     */
    public function remove($cartId, $serviceId)
    {
        $user = auth()->user();
        $buyer = Buyer::where('user_id', $user->user_id)->first();

        if ($buyer && $cartId === $buyer->cart_id) {
            CartItem::where('cart_id', $cartId)
                ->where('service_id', $serviceId)
                ->delete();
            return back()->with('success', 'Service removed from cart');
        }

        return back()->with('error', 'Unauthorized');
    }
}
