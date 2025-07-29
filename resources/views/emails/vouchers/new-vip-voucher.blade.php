<!-- resources/views/emails/vouchers/new-vip-voucher.blade.php -->
@component('mail::message')
# Exclusive VIP Voucher for {{ $user->name }}!

A new exclusive discount is available for our VIP members!

## {{ $voucher->code }}

**Discount:** 
@if($voucher->discount_type === 'percentage')
{{ $voucher->discount_value }}% off
@else
Rp {{ number_format($voucher->discount_value, 0, ',', '.') }} off
@endif

**Details:** {{ $voucher->description }}

**Valid until:** {{ $voucher->end_date->format('d M Y') }}

@if($voucher->product_id)
This voucher is specifically for the product: **{{ $voucher->product->name }}**
@else
This voucher can be used for any product!
@endif

@component('mail::button', ['url' => url('/vouchers')])
Claim Now
@endcomponent

Thank you for being our valued VIP member!

Best regards,<br>
{{ config('app.name') }}

<small>This is an exclusive offer for VIP members only. Your membership expires on {{ $user->membership_expires_at->format('d M Y') }}.</small>
@endcomponent