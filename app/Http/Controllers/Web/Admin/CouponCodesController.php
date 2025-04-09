<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Web\Admin\Panel\PanelController;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
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
            'valid_period' => 'required|date',
        ]);

        $coupon = new Coupon();
        $coupon->name = $request->name;
        $coupon->code = $request->code;
        $coupon->value = $request->value;
        $coupon->value_type = $request->value_type;
        $coupon->valid_period = $request->valid_period;
        $coupon->status = 'active';
        $coupon->utilized = 'no';
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
        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->all());

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully.');
    }

    // Change status separately
    public function changeStatus(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->status = $request->status;
        $coupon->save();

        return redirect()->route('coupons.index')->with('success', 'Status updated.');
    }

    // Toggle is_active separately
    public function toggleActive(Request $request, $id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->is_active = $request->is_active;
        $coupon->save();

        return redirect()->route('coupons.index')->with('success', 'Active status updated.');
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
        $coupon->utilized = Auth::user()->id;
        $coupon->utilized_date = now(); // Set date only if 'utilized' is 'yes'

        // Save the updated coupon
        $coupon->save();

        return redirect()->route('coupons.index')->with('success', 'Coupon utilization status updated successfully.');
    }

    public function destroyCoupon($id)
    {
        $coupon = Coupon::findOrFail($id); // Find the coupon by ID

        // Delete the coupon
        $coupon->delete();

        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
    }

    public function getCouponByCode(Request $request)
    {
        // Validate the coupon code input
        $request->validate([
            'code' => 'required|string|exists:coupons,code', // Ensure the code exists in the database
        ]);

        // Retrieve the coupon by code
        $coupon = Coupon::where('code', $request->code)->first();

        // If the coupon doesn't exist, return a 404 response
        if (!$coupon) {
            return response()->json(['message' => 'Coupon not found.'], 404);
        }

        // Return the coupon details as a JSON response
        return response()->json($coupon, 200);
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
