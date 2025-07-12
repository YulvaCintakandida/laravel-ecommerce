<?php

namespace App\Filament\Resources\ProductionResource\Pages;

use App\Filament\Resources\ProductionResource;
use App\Models\Stock;
use Filament\Resources\Pages\CreateRecord;
use Illuminate\Database\Eloquent\Model;

class CreateProduction extends CreateRecord
{
    protected static string $resource = ProductionResource::class;

    protected function afterCreate(): void
    {
        // Create stock entry for this production
        Stock::create([
            'product_id' => $this->record->product_id,
            'stock_in' => $this->record->qty,
            'stock_out' => 0,
            'current_stock' => $this->getCurrentStock($this->record->product_id) + $this->record->qty,
            'description' => 'Production entry - Batch #' . $this->record->id
        ]);
    }

    private function getCurrentStock($product_id): int
    {
        return Stock::where('product_id', $product_id)
            ->latest()
            ->value('current_stock') ?? 0;
    }
}