<?php

namespace App\Observers;

use App\Models\UserVoucher;

class UserVoucherObserver
{
    public function updated(UserVoucher $userVoucher)
    {
        // Only handle is_used changes
        if ($userVoucher->isDirty('is_used')) {
            $userVoucher->voucher()->update([
                'current_usage' => $userVoucher->voucher->getCurrentUsageAttribute()
            ]);
        }
    }
}