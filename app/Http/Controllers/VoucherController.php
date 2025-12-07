<?php

namespace App\Http\Controllers;

use App\Models\Discount;
use Illuminate\Http\Request;
use Carbon\Carbon;

class VoucherController extends Controller
{
    /**
     * Get available vouchers for the current cart total
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function getAvailable(Request $request)
    {
        // Get cart total from request or use default hardcoded value (60000)
        $cartTotal = $request->input('cart_total', 60000);

        // Query active vouchers that:
        // 1. is_active = true
        // 2. Not expired (discount_end >= today)
        // 3. Meets minimum transaction (min_transaction <= cart_total)
        $vouchers = Discount::where('is_active', true)
            ->where('discount_end', '>=', Carbon::today())
            ->where('min_transaction', '<=', $cartTotal)
            ->get(['discount_id', 'discount_name', 'discount_desc', 'discount_value', 'min_transaction']);

        return response()->json([
            'success' => true,
            'data' => $vouchers
        ]);
    }

    /**
     * Validate a specific voucher
     * 
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function validateVoucher(Request $request)
    {
        $voucherId = $request->input('voucher_id');
        $cartTotal = $request->input('cart_total', 60000);

        if (!$voucherId) {
            return response()->json([
                'valid' => false,
                'message' => 'Voucher ID is required'
            ], 400);
        }

        $voucher = Discount::find($voucherId);

        if (!$voucher) {
            return response()->json([
                'valid' => false,
                'message' => 'Voucher not found'
            ], 404);
        }

        // Validate voucher conditions
        if (!$voucher->is_active) {
            return response()->json([
                'valid' => false,
                'message' => 'Voucher is not active'
            ]);
        }

        if ($voucher->discount_end < Carbon::today()) {
            return response()->json([
                'valid' => false,
                'message' => 'Voucher has expired'
            ]);
        }

        if ($voucher->min_transaction > $cartTotal) {
            return response()->json([
                'valid' => false,
                'message' => "Minimum transaction is Rp " . number_format($voucher->min_transaction, 0, ',', '.')
            ]);
        }

        return response()->json([
            'valid' => true,
            'message' => 'Voucher is valid',
            'voucher' => $voucher
        ]);
    }
}
