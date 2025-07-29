<?php
// app/Filament/Resources/VoucherResource/Pages/CreateVoucher.php

namespace App\Filament\Resources\VoucherResource\Pages;

use App\Filament\Resources\VoucherResource;
use Filament\Actions;
use Filament\Resources\Pages\CreateRecord;
use App\Jobs\SendVipVoucherEmails;

class CreateVoucher extends CreateRecord
{
    protected static string $resource = VoucherResource::class;

    protected function afterCreate(): void
    {
        // Only send notification for VIP vouchers
        $voucher = $this->record;
        dispatch(new SendVipVoucherEmails($voucher));
    }
}