<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Admin\Panel\PanelController;
use App\Models\Coupon;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Illuminate\View\View;

class CouponCodesController extends PanelController
{

    public function __construct()
    {
        $this->middleware('admin');

        parent::__construct();

    }

    //
    public function index()
    {
        return view('admin.coupon_codes.index');
    }

    public function redirect()
    {
        // The '/admin' route is not to be used as a page, because it breaks the menu's active state.
        return redirect(admin_uri('coupon_codes'));
    }

    // Show single coupon details
    public function showCoupon($id)
    {
        $coupon = Coupon::findOrFail($id);
        return response()->json($coupon);
    }

    public function getAllCoupons()
    {
        $coupons = Coupon::with('user')->latest()->get();

        foreach ($coupons as $data) {
            // Parse the valid_period and compare to today's date
            if (Carbon::parse($data->valid_period)->lt(Carbon::today())) {
                $data['status'] = 'Expired';
                $data['is_active'] = 0;
                $data->save();
            }
        }

        $coupons = Coupon::with('user')->latest()->get();
        return response()->json([
            'data' => $coupons
        ]);
    }

    // Store new coupon
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|unique:coupons,code',
            'value' => 'required|numeric',
            'value_type' => 'required',
            'name' => 'required',
            'valid_period' => 'required|date|after:today',
        ]);

        $coupon = new Coupon();
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->value = $request->value;
        $coupon->value_type = $request->value_type;
        $coupon->valid_period = $request->valid_period;
        $coupon->status = 'Active';
        $coupon->utilized = 'No';
        $coupon->utilized_date = null;
        $coupon->is_active = true;
        $coupon->user_id = null;

        $coupon->save();

        return response()->json([
            'success' => true,
            'message' => 'Coupon created successfully.',
            'data' => $coupon
        ]);

    }

    // Update coupon
    public function update(Request $request, $id)
    {
        try {
            $coupon = Coupon::findOrFail($id);
            $request->validate([
                'code' => [
                    'required',
                    Rule::unique('coupons', 'code')->ignore($id),
                ],
                'value' => 'required|numeric',
                'value_type' => 'required',
                'name' => 'required',
                'valid_period' => 'required|date|after:today',
            ]);
            $coupon->update($request->all());

            return response()->json([
                'success' => true,
                'message' => 'Coupon updated successfully.',
                'data' => $coupon
            ]);
        } catch (Exception $e) {
            $allErrors = collect($e->errors())->flatten()->implode(' ');

            Log::error('Validation failed: ' . $allErrors);
            return response()->json([
                'success' => false,
                'message' => $allErrors,
            ]);
        }
    }

    // public function update(Request $request, $id)
    // {
    //     try {
    //         $coupon = Coupon::findOrFail($id);

    //         // Validation
    //         $validated = $request->validate([
    //             'code' => [
    //                 'required',
    //                 Rule::unique('coupons', 'code')->ignore($id),
    //             ],
    //             'value' => 'required|numeric',
    //             'value_type' => 'required',
    //             'name' => 'required',
    //             'valid_period' => 'required|date|after:today',
    //         ]);

    //         // Update
    //         $coupon->update($validated);

    //         return response()->json([
    //             'success' => true,
    //             'message' => 'Coupon updated successfully.',
    //             'data' => $coupon
    //         ]);
    //     } catch (ValidationException $e) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Validation failed.',
    //             'errors' => $e->errors()
    //         ], 422);
    //     } catch (Exception $e) {
    //         Log::error('Coupon update failed: ' . $e->getMessage());

    //         return response()->json([
    //             'success' => false,
    //             'message' => 'An unexpected error occurred.',
    //             'error' => $e->getMessage()
    //         ], 500);
    //     }
    // }

    // Change status separately
    public function changeStatus(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = $request->status;
        $coupon->save();

        return response()->json([
            'success' => true,
            'message' => 'Coupon status updated successfully.',
            'data' => $coupon
        ]);
    }

    // Toggle is_active separately
    public function toggleActive(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = $request->is_active;
        $coupon->save();

        return response()->json([
            'success' => true,
            'message' => 'Coupon active updated successfully.',
            'data' => $coupon
        ]);
    }

    public function updateUtilizedStatus(Request $request, $id)
    {
        // Validate the input status
        $request->validate([
            'utilized' => 'required',
        ]);

        // Find the coupon by ID
        $coupon = Coupon::findOrFail($id);

        // Update the utilized status and utilized date
        $coupon->utilized = $request->utilized;
        $coupon->user_id = Auth::user()->id;
        $coupon->utilized_date = now(); // Set date only if 'utilized' is 'yes'
        $coupon->is_active = 0;

        // Save the updated coupon
        $coupon->save();

        return response()->json([
            'success' => true,
            'message' => 'Coupon utilization status updated successfully.',
            'data' => $coupon
        ]);
    }

    public function destroyCoupon($id)
    {
        $coupon = Coupon::findOrFail($id); // Find the coupon by ID

        // Delete the coupon
        $coupon->delete();

        return response()->json([
            'success' => true,
            'message' => 'Coupon deleted successfully.',
            'data' => $coupon
        ]);
    }

    public function getCouponByCode(Request $request)
    {
        // Validate the coupon code input
        $request->validate([
            'code' => 'required|string|exists:coupons,code', // Ensure the code exists in the database
        ]);

        $couponCode = $request->input('code');
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', true)
            ->where('utilized', 'no')
            ->first();
        //->where('valid_period', '>=', now())

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

    public function validateCoupon(Request $request)
    {
        $couponCode = $request->input('coupon_code');
        $coupon = Coupon::where('code', $couponCode)
            ->where('is_active', true)
            ->where('utilized', 'no')
            ->first();
        //->where('valid_period', '>=', now())

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
