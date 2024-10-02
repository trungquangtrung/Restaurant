<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class CouponController extends Controller
{
    public function applyCoupon(Request $request)
    {
        // Xác thực yêu cầu
        $request->validate([
            'code' => 'required|string',
        ]);

        // Kiểm tra mã giảm giá
        $coupon = Coupon::where('code', $request->code)->first();

        // Nếu không tìm thấy mã giảm giá
        if (!$coupon) {
            return response()->json([
                'message' => 'Mã giảm giá không hợp lệ!',
            ], 400);
        }

        // Kiểm tra nếu mã giảm giá đã hết hạn hoặc đã được sử dụng
        if ($coupon->end_date < now()) {
            return response()->json([
                'message' => 'Mã giảm giá đã hết hạn!',
            ], 400);
        }

        if ($coupon->usage_limit && $coupon->usage_limit <= 0) {
            return response()->json([
                'message' => 'Mã giảm giá đã được sử dụng hết!',
            ], 400);
        }

        // Lưu thông tin mã giảm giá vào session
        Session::put('coupon', [
            'code' => $coupon->code,
            'discount' => $coupon->discount,
        ]);

        // Giảm số lần sử dụng nếu có
        if ($coupon->usage_limit) {
            $coupon->usage_limit -= 1;
            $coupon->save();
        }

        return response()->json([
            'message' => 'Mã giảm giá đã được áp dụng!',
            'newTotal' => number_format($this->calculateNewTotal(), 2),
        ]);
    }

    private function calculateNewTotal()
    {
        $cart = session()->get('cart', []);
        $grandTotal = 0;

        foreach ($cart as $item) {
            $grandTotal += $item['price'] * $item['qty'];
        }

        // Trừ đi giá trị giảm giá nếu có
        if (session()->has('coupon')) {
            $grandTotal -= session('coupon.discount');
        }

        return $grandTotal;
    }
}
