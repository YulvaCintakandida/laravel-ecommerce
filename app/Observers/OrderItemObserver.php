<?php

namespace App\Observers;

use App\Models\OrderItem;
use App\Models\Stock;

class OrderItemObserver
{
    public function created(OrderItem $orderItem)
    {
        // Create stock entry for order
        Stock::create([
            'product_id' => $orderItem->product_id,
            'stock_in' => 0,
            'stock_out' => $orderItem->quantity,
            'description' => 'Order #' . $orderItem->order_id . ' - Item sold',
        ]);
    }
}