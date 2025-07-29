<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Filament\Models\Contracts\FilamentUser;
use Filament\Panel;

class User extends Authenticatable implements FilamentUser
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'phone',
        'address',
        'membership_type',
        'membership_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'membership_expires_at' => 'datetime',
        ];
    }

    public function membershipTransactions()
    {
        return $this->hasMany(MembershipTransaction::class);
    }

    public function isVip()
    {
        return $this->membership_type === 'vip' && 
            ($this->membership_expires_at === null || 
                $this->membership_expires_at->isFuture());
    }

    public function hasActiveMembership()
    {
        return $this->membership_type === 'vip' && 
            $this->membership_expires_at && 
            $this->membership_expires_at->isFuture();
    }

    public function getMembershipStatusAttribute()
    {
        if ($this->membership_type === 'regular') {
            return 'Regular';
        }
        
        if (!$this->membership_expires_at) {
            return 'Regular';
        }
        
        return $this->membership_expires_at->isFuture() 
            ? 'VIP (expires: ' . $this->membership_expires_at->format('d M Y') . ')'
            : 'Expired VIP';
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function canAccessPanel(Panel $panel): bool
    {
        return $this->role === 'seller';
    }

    public function vouchers()
    {
        return $this->belongsToMany(Voucher::class, 'user_vouchers')
            ->withPivot('is_used', 'used_at')
            ->withTimestamps();
    }
}
