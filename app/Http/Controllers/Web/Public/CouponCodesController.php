<?php

namespace App\Http\Controllers\Web\Public;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class CouponCodesController extends FrontController
{
    public function getCouponByCode(Request $request): \Illuminate\Http\JsonResponse
    {

        $request->validate([
            'code' => 'required|string|exists:coupons,code', // Ensure the code exists in the database
        ]);

        $couponCode = $request->input('code');
        $coupon = Coupon::where('code', $couponCode)
                        ->where('is_active', true)
                        ->where('valid_period', '>=', now())
                        ->where('utilized', 'no')
                        ->first();

        if ($coupon) {
            $discount = $coupon->value_type === 'percentage' ? $coupon->value / 100 : $coupon->value;
            //$discount = $coupon->value;
            return response()->json([
                'success' => true,
                'discount' => $discount,
                'value_type' => $coupon->value_type
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Invalid or expired coupon code.'
        ]);
    }
}
