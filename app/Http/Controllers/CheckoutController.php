<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $cartItems = session()->get('cart', []);
        $appliedVoucher = session()->get('applied_voucher');

        if (empty($cartItems)) {
            return redirect()->route('products.index')
                ->with('error', 'Your cart is empty!');
        }

        // Validasi stok
        $validCartItems = array_filter($cartItems, function ($item) {
            return $item['current_stock'] > 0 && $item['quantity'] <= $item['current_stock'];
        });

        if (empty($validCartItems)) {
            return redirect()->route('cart.index')
                ->with('error', 'No valid items in cart for checkout!');
        }

        $subtotal = collect($validCartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
        $discountAmount = $appliedVoucher['discount_amount'] ?? 0;
        $total = $subtotal - $discountAmount;

        return view('checkout.index', compact('validCartItems', 'subtotal', 'total', 'discountAmount', 'appliedVoucher'));
    }
}
