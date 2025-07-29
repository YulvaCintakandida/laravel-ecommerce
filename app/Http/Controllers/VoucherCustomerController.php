<?php

namespace App\Http\Controllers;

use App\Models\Voucher;
use App\Models\UserVoucher;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VoucherCustomerController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $isVip = $user->hasActiveMembership(); // Gunakan method yang sudah dibuat di model User
        
        // Query untuk voucher yang tersedia
        $vouchersQuery = Voucher::where('end_date', '>', now())
            ->whereDoesntHave('userVouchers', function ($query) {
                $query->where('user_id', Auth::id());
            });
        
        // Filter voucher sesuai status membership user
        if (!$isVip) {
            $vouchersQuery->where('is_vip_only', false);
        }
        
        $availableVouchers = $vouchersQuery->get();
    
        // Voucher yang sudah di-claim user
        $myVouchers = UserVoucher::with('voucher')
            ->where('user_id', Auth::id())
            ->whereHas('voucher', function ($query) {
                $query->where('end_date', '>', now());
            })
            ->get();
    
        return view('vouchers-customer.index', compact('availableVouchers', 'myVouchers', 'isVip'));
    } 

    public function claim(Voucher $voucher)
    {
        // Cek apakah voucher khusus VIP dan user bukan member VIP
        if ($voucher->is_vip_only && !Auth::user()->hasActiveMembership()) {
            return back()->with('error', 'Voucher ini hanya tersedia untuk member VIP.');
        }
        
        if ($voucher->end_date < now()) {
            return back()->with('error', 'Voucher telah kedaluwarsa.');
        }
    
        $existingClaim = UserVoucher::where('user_id', Auth::id())
            ->where('voucher_id', $voucher->id)
            ->exists();
    
        if ($existingClaim) {
            return back()->with('error', 'Anda sudah mengklaim voucher ini.');
        }
    
        UserVoucher::create([
            'user_id' => Auth::id(),
            'voucher_id' => $voucher->id,
            'is_used' => false
        ]);
    
        return back()->with('success', 'Voucher berhasil diklaim!');
    }

        public function isFullyUsed()
    {
        return $this->userVouchers()
            ->where('is_used', true)
            ->count() >= $this->max_usage;
    }
}