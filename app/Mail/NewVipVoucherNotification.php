<?php
// app/Mail/NewVipVoucherNotification.php

namespace App\Mail;

use App\Models\Voucher;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class NewVipVoucherNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $voucher;
    public $user;

    public function __construct(Voucher $voucher, User $user)
    {
        $this->voucher = $voucher;
        $this->user = $user;
    }

    public function build()
    {
        return $this->subject('New Exclusive VIP Voucher Available!')
            ->markdown('emails.vouchers.new-vip-voucher');
    }
}