<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\UserVoucher;

class CartController extends Controller
{
   public function index()
{
    $cartItems = session()->get('cart', []);
    $stockUpdated = false;
    
    if (empty($cartItems)) {
        return redirect()->route('products.index')->with('error', 'Your cart is empty!');
    }

    $availableVouchers = UserVoucher::with('voucher')
        ->where('user_id', Auth::id())
        ->where('is_used', false)
        ->whereHas('voucher', function($query) {
            $query->where('end_date', '>', now());
        })
        ->get()
        ->map(fn($uv) => $uv->voucher); // ambil objek voucher-nya saja

    // Update current stock for each item
    foreach ($cartItems as $id => $item) {
        $product = Product::find($id);
        $currentStock = $product ? $product->current_stock : 0;
        $cartItems[$id]['current_stock'] = $currentStock;

        // Adjust quantity if it exceeds current stock
        if ($cartItems[$id]['quantity'] > $currentStock) {
            $cartItems[$id]['quantity'] = $currentStock;
            $stockUpdated = true;
        }
    }
    
    session()->put('cart', $cartItems);
    
    $total = 0;
    foreach ($cartItems as $item) {
        $total += $item['price'] * $item['quantity'];
    }

    if ($stockUpdated) {
        session()->flash('warning', 'Some items in your cart were adjusted due to stock availability.');
    }

    return view('cart.index', compact('cartItems', 'total'));
}

    public function add(Product $product, Request $request)
    {
        $cart = session()->get('cart', []);
        
        // Check if product is out of stock
        if ($product->current_stock <= 0) {
            return redirect()->back()->with('error', 'Product is out of stock!');
        }
    
        if (isset($cart[$product->id])) {
            // Check if adding more would exceed current stock
            if (($cart[$product->id]['quantity'] + 1) > $product->current_stock) {
                return redirect()->back()->with('error', 'Cannot add more of this product. Stock limit reached!');
            }
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'name' => $product->name,
                'price' => $product->price,
                'quantity' => 1,
                'image' => $product->image,
                'current_stock' => $product->current_stock
            ];
        }
    
        session()->put('cart', $cart);
        return redirect()->back()->with('success', 'Product added to cart!');
    }
    
                public function update(Request $request, $productId)
        {
            $cart = session()->get('cart', []);
            $product = Product::find($productId);
        
            if (!$product) {
                return redirect()->back()->with('error', 'Product not found!');
            }
        
            $currentStock = $product->current_stock;
        
            if (isset($cart[$productId])) {
                $cart[$productId]['quantity'] = min($request->quantity, $currentStock);
                $cart[$productId]['current_stock'] = $currentStock;
                session()->put('cart', $cart);
            }
        
            return redirect()->back()->with('success', 'Cart updated!');
        }

    public function remove($productId)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$productId])) {
            unset($cart[$productId]);
            session()->put('cart', $cart);
        }

        return redirect()->back()->with('success', 'Product removed from cart!');
    }
    
    public function apply(Request $request)
    {
        $voucherId = $request->input('voucher_id');

        // Cari voucher yang dimiliki user, belum dipakai dan masih valid
        $userVoucher = UserVoucher::where('user_id', Auth::id())
            ->where('voucher_id', $voucherId)
            ->where('is_used', false)
            ->whereHas('voucher', function ($query) {
                $query->where('end_date', '>', now());
            })
            ->first();

        if (!$userVoucher) {
            return back()->with('error', 'Voucher tidak valid atau sudah dipakai.');
        }

        // Hitung subtotal dari keranjang
        $cartItems = session()->get('cart', []);
        $subtotal = collect($cartItems)->sum(function ($item) {
            return $item['price'] * $item['quantity'];
        });

        $voucher = $userVoucher->voucher;
        if ($voucher->discount_type === 'percentage') {
            $discountAmount = round($subtotal * ($voucher->discount_value / 100));
        } else {
            $discountAmount = $voucher->discount_value;
        }

        // Simpan data voucher ke session agar bisa ditampilkan di cart
        session()->put('applied_voucher', [
            'id' => $voucher->id,
            'code' => $voucher->code,
            'discount_amount' => $discountAmount,
        ]);

        return back()->with('success', 'Voucher berhasil diterapkan!');
    }

    // public function remove()
    // {
    //     session()->forget('applied_voucher');
    //     return back()->with('success', 'Voucher dihapus!');
    // }
}