<?php

namespace App\Observers;

use App\Models\Order;
use App\Models\Stock;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class OrderObserver
{
    public function retrieved(Order $order)
    {
        if (
            $order->status === Order::STATUS_PENDING &&
            $order->created_at->lt(Carbon::now()->subDay())
        ) {
            DB::beginTransaction();
            try {
                foreach ($order->items as $item) {
                    Stock::create([
                        'product_id' => $item->product_id,
                        'stock_in' => $item->quantity,
                        'stock_out' => 0,
                        'description' => 'Order #' . $order->id . ' - Auto-cancelled (expired 1 day)'
                    ]);
                }
                $order->update(['status' => Order::STATUS_CANCELLED]);
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                // Optional: log error
            }
        }
    }
}