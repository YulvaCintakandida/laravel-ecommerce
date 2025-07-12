<?php

namespace App\Observers;

use App\Models\Stock;

class StockObserver
{
    public function creating(Stock $stock)
    {
        // Calculate current stock
        if (empty($stock->current_stock)) {
            $previousStock = Stock::where('product_id', $stock->product_id)
                ->latest()
                ->first();

            $previousAmount = $previousStock ? $previousStock->current_stock : 0;
            $stock->current_stock = $previousAmount + ($stock->stock_in - $stock->stock_out);
        }
    }
}