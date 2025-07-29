<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use App\Observers\UserVoucherObserver;
use App\Models\UserVoucher;

class Voucher extends Model
{
    protected $keyType = 'string';
    public $incrementing = false;

    protected $fillable = [
        'code',
        'description',
        'discount_type',
        'discount_value',
        'max_usage',
        'current_usage',
        'is_vip_only', // Tambahkan ini
        'product_id', // Tambahkan ini
        'start_date',
        'end_date'
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'discount_value' => 'decimal:2',
        'is_vip_only' => 'boolean', // Tambahkan ini
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($model) {
            $model->id = Str::uuid();
        });
        UserVoucher::observe(UserVoucherObserver::class);
    }
    
    public function userVouchers()
    {
        return $this->hasMany(UserVoucher::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class, 'user_vouchers')
            ->withPivot('is_used', 'used_at')
            ->withTimestamps();
    }
    
    public function getCurrentUsageAttribute()
    {
        return $this->userVouchers()
            ->where('is_used', true)
            ->count();
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function isValidForProduct($productId)
{
    // Jika voucher tidak terikat ke produk spesifik (null), voucher berlaku untuk semua produk
    if ($this->product_id === null) {
        return true;
    }
    
    // Jika voucher terikat ke produk spesifik, cek apakah produk_id cocok
    return $this->product_id === $productId;
}
}