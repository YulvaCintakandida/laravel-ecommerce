<!-- resources/views/membership/checkout.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Checkout: {{ $plan->name }}</h1>
    
    <div class="grid md:grid-cols-2 gap-8">
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title">Membership Details</h2>
                <div class="divider"></div>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span>Plan:</span>
                        <span class="font-semibold">{{ $plan->name }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Duration:</span>
                        <span class="font-semibold">{{ $plan->duration_months }} Month(s)</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Price:</span>
                        <span class="text-xl font-bold text-primary">Rp{{ number_format($plan->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span>Valid Until:</span>
                        <span class="font-semibold">{{ now()->addMonths($plan->duration_months)->format('d M Y') }}</span>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="card bg-base-100 shadow-lg">
            <div class="card-body">
                <h2 class="card-title">Payment Summary</h2>
                <div class="divider"></div>
                <div class="space-y-4">
                    <div class="flex justify-between">
                        <span>Subtotal:</span>
                        <span class="font-semibold">Rp{{ number_format($plan->price, 0, ',', '.') }}</span>
                    </div>
                    <div class="flex justify-between">
                        <span class="text-lg font-bold">Total:</span>
                        <span class="text-lg font-bold text-primary">Rp{{ number_format($plan->price, 0, ',', '.') }}</span>
                    </div>
                </div>
                
                <form action="{{ route('membership.process', $plan->id) }}" method="POST" class="mt-6">
                    @csrf
                    <button type="submit" class="btn btn-primary w-full">Pay Now with Midtrans</button>
                </form>
                
                <div class="mt-4">
                    <a href="{{ route('membership.index') }}" class="btn btn-outline w-full">Cancel</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection