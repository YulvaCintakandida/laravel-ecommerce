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

    $voucher = $userVoucher->voucher;
    $cart = session()->get('cart', []);
    
    // Validasi produk spesifik
    if ($voucher->product_id !== null) {
        $voucherProductId = (string) $voucher->product_id;
        
        $productFound = false;
        $productSubtotal = 0;
        
        // PERBAIKAN: Akses key dan item dengan benar
        foreach ($cart as $id => $item) {
            // Gunakan ID produk dari key array cart
            $itemId = (string) $id;
            
            if ($itemId === $voucherProductId) {
                $productFound = true;
                $productSubtotal += $item['price'] * $item['quantity'];
            }
        }
            
        if (!$productFound) {
            return back()->with('error', 'Voucher ini hanya berlaku untuk produk ' . $voucher->product->name);
        }
        
        // Hitung subtotal hanya untuk produk spesifik
        $subtotal = $productSubtotal;
    } else {
        // Jika voucher untuk semua produk, hitung total keseluruhan
        $subtotal = collect($cart)->sum(fn($item) => $item['price'] * $item['quantity']);
    }
        
        // Calculate discount
        if ($voucher->discount_type === 'percentage') {
            $discount = $subtotal * ($voucher->discount_value / 100);
        } else {
            $discount = min($voucher->discount_value, $subtotal); // Pastikan diskon tidak melebihi subtotal
        }
    
        session()->put('applied_voucher', [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'product_id' => $voucher->product_id,
            'discount_amount' => $discount
        ]);
    
        return back()->with('success', 'Voucher berhasil diaplikasikan!');
    }

    public function remove()
    {
        session()->forget('applied_voucher');
        return back()->with('success', 'Voucher removed successfully!');
    }
}