<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'stock_in',
        'stock_out',
        'current_stock',
        'description'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        static::creating(function ($stock) {
            $previousStock = static::where('product_id', $stock->product_id)
                ->latest()
                ->first();
    
            $previousAmount = $previousStock ? $previousStock->current_stock : 0;
            $stock->current_stock = $previousAmount + ($stock->stock_in - $stock->stock_out);
            
            if ($stock->current_stock < 0) {
                throw new \Exception('Insufficient stock');
            }
        });
    }
}