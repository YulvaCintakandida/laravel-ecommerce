<?php
// app/Jobs/SendVipVoucherEmails.php

namespace App\Jobs;

use App\Mail\NewVipVoucherNotification;
use App\Models\Voucher;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;
use App\Models\User;

class SendVipVoucherEmails implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $voucher;
    public $tries = 3; // Coba 3x jika gagal

    public function __construct(Voucher $voucher)
    {
        $this->voucher = $voucher;
    }

    public function handle(): void
    {
        try {
            // Get VIP users with active membership
            $vipUsers = User::where('membership_type', 'vip')
                ->whereNotNull('membership_expires_at')
                ->where('membership_expires_at', '>', now())
                ->get();

            Log::info('VIP users found: ' . $vipUsers->count());

            // Jika tidak ada user VIP, selesai
            if ($vipUsers->count() === 0) {
                Log::info('No VIP users found. Skipping email sending.');
                return;
            }

            foreach ($vipUsers as $user) {
                try {
                    Log::info('Sending email to: ' . $user->email);
                    Mail::to($user->email)->send(new NewVipVoucherNotification($this->voucher, $user));
                    Log::info('Email sent successfully to: ' . $user->email);
                } catch (\Exception $e) {
                    Log::error('Failed to send email to ' . $user->email . ': ' . $e->getMessage());
                }
            }
        } catch (\Exception $e) {
            Log::error('VIP voucher email job failed: ' . $e->getMessage() . "\n" . $e->getTraceAsString());
            throw $e; // Rethrow exception to mark job as failed
        }
    }

    /**
     * Handle a job failure.
     */
    public function failed(\Throwable $exception): void
    {
        Log::error('SendVipVoucherEmails failed: ' . $exception->getMessage());
    }
}