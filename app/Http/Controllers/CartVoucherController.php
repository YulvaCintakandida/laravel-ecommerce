<?php

namespace App\Http\Controllers;

use App\Models\UserVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartVoucherController extends Controller
{
    public function apply(Request $request)
    {
        $userVoucher = UserVoucher::with('voucher')
            ->where('user_id', Auth::id())
            ->where('voucher_id', $request->voucher_id)
            ->where('is_used', false)
            ->firstOrFail();

        $cart = session()->get('cart', []);
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
        
        // Calculate discount
        $voucher = $userVoucher->voucher;
        if ($voucher->discount_type === 'percentage') {
            $discount = $subtotal * ($voucher->discount_value / 100);
        } else {
            $discount = $voucher->discount_value;
        }

        session()->put('applied_voucher', [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'discount_amount' => $discount
        ]);

        return back()->with('success', 'Voucher applied successfully!');
    }

    public function remove()
    {
        session()->forget('applied_voucher');
        return back()->with('success', 'Voucher removed successfully!');
    }
}