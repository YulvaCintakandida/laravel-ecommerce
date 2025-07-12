<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Midtrans\Config;
use Midtrans\Snap;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Midtrans\Transaction;
use App\Models\UserVoucher;


class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey = config('midtrans.server_key');
        Config::$isProduction = config('midtrans.is_production');
        Config::$isSanitized = config('midtrans.is_sanitized');
        Config::$is3ds = config('midtrans.is_3ds');
    }

        public function process(Request $request)
        {
            DB::beginTransaction();
            try {
                $cartItems = session()->get('cart', []);
                $appliedVoucher = session()->get('applied_voucher');
                
                $subtotal = collect($cartItems)->sum(fn($item) => $item['price'] * $item['quantity']);
                $discountAmount = $appliedVoucher['discount_amount'] ?? 0;
                
                // Create order with initial pending status
                $order = Order::create([
                    'user_id' => Auth::id(),
                    'total' => $subtotal - $discountAmount,
                    'status' => Order::STATUS_PENDING,
                    'voucher_id' => $appliedVoucher['id'] ?? null,
                    'discount_amount' => $discountAmount,
                    'delivery_method' => $request->delivery_method
                ]);
    
                // Create order items
                foreach ($cartItems as $item) {
                    $order->items()->create([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price']
                    ]);
                }
    
                $paymentUrl = $this->createMidtransTransaction($order);
                
                DB::commit();
                return redirect($paymentUrl);
    
            } catch (\Exception $e) {
                DB::rollback();
                return redirect()->route('checkout.index')
                    ->with('error', 'Payment failed: ' . $e->getMessage());
            }
        }

        private function createMidtransTransaction(Order $order)
        {
            $items = [];

            foreach ($order->items as $item) {
                $items[] = [
                    'id' => $item->product_id,
                    'price' => $item->price,
                    'quantity' => $item->quantity,
                    'name' => $item->product->name,
                ];
            }

            if ($order->discount_amount > 0) {
                $items[] = [
                    'id' => 'DISCOUNT',
                    'price' => -$order->discount_amount,
                    'quantity' => 1,
                    'name' => 'Discount',
                ];
            }

            $params = [
                'transaction_details' => [
                    'order_id' => $order->id,
                    'gross_amount' => $order->total,
                ],
                'customer_details' => [
                    'first_name' => Auth::user()->name,
                    'email' => Auth::user()->email,
                    'phone' => Auth::user()->phone,
                ],
                'item_details' => $items,
                'callbacks' => [
                    'finish' => route('payment.finish', ['order' => $order->id]),
                    'error' => route('payment.error', ['order' => $order->id]),
                ],
                'notification_url' => route('payment.notification'),
            ];        

            // Get the redirect URL from Midtrans
            $response = Snap::createTransaction($params);
            $redirectUrl = $response->redirect_url;
            
            // Save the payment URL to the order
            $order->update(['payment_url' => $redirectUrl]);
            
            return $redirectUrl;
        }
    
        public function notification(Request $request)
        {
            try {
                $notification = new \Midtrans\Notification();
                
                $orderId = $notification->order_id;
                $transactionStatus = $notification->transaction_status;
                
                $order = Order::findOrFail($orderId);
                
                // Check real status via Midtrans API
                $status = Transaction::status($orderId);
                
                switch ($status->transaction_status) {
                    case 'settlement':
                        $order->status = Order::STATUS_SETTLEMENT;
                        session()->forget(['cart', 'applied_voucher']);
                        if ($order->voucher_id) {
                            UserVoucher::where('user_id', $order->user_id)
                                ->where('voucher_id', $order->voucher_id)
                                ->update(['is_used' => true, 'used_at' => now()]);
                        }
                        break;
                        
                    case 'expire':
                        $order->status = Order::STATUS_EXPIRED;
                        break;
                        
                    case 'pending':
                        $order->status = Order::STATUS_PENDING;
                        break;
                }
                
                $order->save();
                
                return response()->json(['success' => true]);
                
            } catch (\Exception $e) {
                \Log::error('Midtrans notification error: ' . $e->getMessage());
                return response()->json(['success' => false], 500);
            }
        }
    
public function finish(Order $order)
{
    try {
        // Check real status from Midtrans
        $status = Transaction::status($order->id);
        
        switch ($status->transaction_status) {
            case 'settlement':
                $order->status = Order::STATUS_SETTLEMENT;
                session()->forget(['cart', 'applied_voucher']);
                // Mark voucher as used if exists
                if ($order->voucher_id) {
                    UserVoucher::where('user_id', $order->user_id)
                        ->where('voucher_id', $order->voucher_id)
                        ->update(['is_used' => true, 'used_at' => now()]);
                }
                $message = 'Payment completed successfully!';
                break;
            
            case 'pending':
                $order->status = Order::STATUS_PENDING;
                $message = 'Payment is pending. Please complete your payment.';
                break;
                
            case 'expire':
                $order->status = Order::STATUS_EXPIRED;
                $message = 'Payment has expired.';
                break;
                
            default:
                $order->status = Order::STATUS_PENDING;
                $message = 'Payment status is being checked.';
                break;
        }
        
        $order->save();
        
        return redirect()->route('orders.show', $order)
            ->with($status->transaction_status === 'settlement' ? 'success' : 'warning', $message);
            
    } catch (\Exception $e) {
        \Log::error('Payment finish error: ' . $e->getMessage());
        return redirect()->route('orders.show', $order)
            ->with('error', 'Unable to check payment status.');
    }
}

public function checkStatus(Order $order)
{
    try {
        // Add server key to config
        Config::$serverKey = config('midtrans.server_key');
        
        $status = Transaction::status($order->id);
        $order->update(['status' => $status->transaction_status]);
        
        if ($status->transaction_status === 'settlement') {
            session()->forget(['cart', 'applied_voucher']);
            if ($order->voucher_id) {
                UserVoucher::where('user_id', $order->user_id)
                    ->where('voucher_id', $order->voucher_id)
                    ->update(['is_used' => true, 'used_at' => now()]);
            }
        }
        
        return response()->json([
            'success' => true,
            'status' => $status->transaction_status
        ]);
    } catch (\Exception $e) {
        \Log::error('Check status error: ' . $e->getMessage());
        return response()->json([
            'success' => false,
            'message' => $e->getMessage()
        ], 500);
    }
}

    public function error(Order $order)
    {
        return redirect()->route('orders.show', $order)
            ->with('error', 'Payment was not completed. You can try again.');
    }

}