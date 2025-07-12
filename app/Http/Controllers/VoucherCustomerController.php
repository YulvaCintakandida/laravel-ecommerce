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
        $availableVouchers = Voucher::where('end_date', '>', now())
            ->whereDoesntHave('userVouchers', function ($query) {
                $query->where('user_id', Auth::id());
            })
            ->get();
    
        $myVouchers = UserVoucher::with('voucher')
            ->where('user_id', Auth::id())
            ->whereHas('voucher', function ($query) {
                $query->where('end_date', '>', now());
            })
            ->get();
    
        return view('vouchers-customer.index', compact('availableVouchers', 'myVouchers'));
    }

   public function claim(Voucher $voucher)
    {
        if ($voucher->end_date < now()) {
            return back()->with('error', 'Voucher has expired.');
        }

        $existingClaim = UserVoucher::where('user_id', Auth::id())
            ->where('voucher_id', $voucher->id)
            ->exists();

        if ($existingClaim) {
            return back()->with('error', 'You have already claimed this voucher.');
        }

        UserVoucher::create([
            'user_id' => Auth::id(),
            'voucher_id' => $voucher->id,
            'is_used' => false
        ]);

        return back()->with('success', 'Voucher claimed successfully!');
    }

        public function isFullyUsed()
    {
        return $this->userVouchers()
            ->where('is_used', true)
            ->count() >= $this->max_usage;
    }
}