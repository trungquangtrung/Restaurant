<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    // Hiển thị danh sách coupons
    public function index()
    {
        $coupons = Coupon::all();
        return view('admin.pages.coupons.index', compact('coupons'));
    }

    // Hiển thị form tạo coupon
    public function create()
    {
        return view('admin.pages.coupons.create');
    }

    // Lưu mã giảm giá mới
    public function store(Request $request)
    {
        $request->validate([
            'code' => 'required|string|unique:coupons|max:255',
            'discount' => 'required|numeric|min:0',
            'type' => 'required|in:percentage,fixed',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
            'usage_limit' => 'nullable|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        // Tạo mã giảm giá mới
        $coupon = Coupon::create($request->all());

        return redirect()->route('admin.coupons.index')->with('success', 'Coupon created successfully!');
    }
    public function destroy(Coupon $coupon)
    {
        $coupon->delete();
        return redirect()->route('admin.coupons.index')->with('success', 'Coupon deleted successfully!');
    }
}
