<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Http\Controllers\PaymentController;
use Illuminate\Support\Facades\DB;
use Midtrans\Snap;
use Midtrans\Config;
use Midtrans\Transaction;
use App\Models\UserVoucher;
use App\Models\Voucher;
use App\Models\OrderItem;
use App\Models\Stock;

class OrderController extends Controller
{
    public function index()
    {
        $orders = Auth::user()->orders()->latest()->paginate(10);
        return view('orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }

        return view('orders.show', compact('order'));
    }

        public function store(Request $request)
    {
        $order = Order::create([
            'user_id' => Auth::id(),
            'total' => $request->total,
            'status' => 'pending'
        ]);
    
        foreach($request->items as $item) {
            // Check stock availability
            $product = Product::find($item['product_id']);
            if ($product->current_stock < $item['quantity']) {
                $order->delete();
                return back()->with('error', 'Insufficient stock for ' . $product->name);
            }
    
            // Create order item
            $order->items()->create([
                'product_id' => $item['product_id'],
                'quantity' => $item['quantity'],
                'price' => $item['price']
            ]);
        }
    
        return redirect()->route('orders.show', $order)
            ->with('success', 'Order created successfully');
    }

    // For "Payment Continue" in OrderController
    public function continuePay(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
    
        if ($order->status !== 'pending') {
            return redirect()->route('orders.show', $order)
                ->with('error', 'This order cannot be paid anymore.');
        }
    
        if (!$order->payment_url) {
            // If no payment URL exists, create a new one
            try {
                $paymentUrl = app(PaymentController::class)->createMidtransTransaction($order);
                $order->update(['payment_url' => $paymentUrl]);
                
                return redirect($paymentUrl);
            } catch (\Exception $e) {
                return redirect()->route('orders.show', $order)
                    ->with('error', 'Failed to create payment: ' . $e->getMessage());
            }
        }
    
        return redirect($order->payment_url);
    }

public function cancel(Order $order)
{
    if ($order->user_id !== Auth::id()) {
        abort(403);
    }

    if ($order->status !== 'pending') {
        return redirect()->route('orders.show', $order)
            ->with('error', 'Only pending orders can be cancelled.');
    }

    DB::beginTransaction();
    try {
        // Return products to inventory by creating stock records
        foreach ($order->items as $item) {
            // Create stock entry to return items to inventory
            Stock::create([
                'product_id' => $item->product_id,
                'stock_in' => $item->quantity,
                'stock_out' => 0,
                'description' => 'Order #' . $order->id . ' - Cancelled, items returned to inventory'
            ]);
        }

        $order->update(['status' => Order::STATUS_CANCELLED]);
        
        DB::commit();
        return redirect()->route('orders.show', $order)
            ->with('success', 'Order has been cancelled successfully.');
    } catch (\Exception $e) {
        DB::rollback();
        return redirect()->route('orders.show', $order)
            ->with('error', 'Failed to cancel order: ' . $e->getMessage());
    }
}
}