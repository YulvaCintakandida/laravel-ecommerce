<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'price',
        'image',
        'category_id',
        'flavour_id',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function flavour()
    {
        return $this->belongsTo(Flavour::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getCurrentStockAttribute()
    {
        $latestStock = $this->stocks()
            ->latest()
            ->first();
        
        return $latestStock ? $latestStock->current_stock : 0;
    }
}