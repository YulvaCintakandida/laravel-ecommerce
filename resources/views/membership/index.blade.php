<!-- resources/views/membership/index.blade.php -->
@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-8">Membership Plans</h1>
    
    @if(session('success'))
        <div class="alert alert-success mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if(session('warning'))
        <div class="alert alert-warning mb-4">
            {{ session('warning') }}
        </div>
    @endif
    
    @if(session('error'))
        <div class="alert alert-error mb-4">
            {{ session('error') }}
        </div>
    @endif
    
    @if(session('info'))
        <div class="alert alert-info mb-4">
            {{ session('info') }}
        </div>
    @endif
    
    <div class="mb-6 p-4 border rounded-lg bg-base-200">
        <h2 class="text-xl font-semibold mb-2">Your Membership Status</h2>
        <p class="mb-4">Current Status: <span class="font-medium">{{ $user->membership_status }}</span></p>
        
        @if($user->hasActiveMembership())
            <div class="bg-success text-white p-3 rounded-md">
                <p>Your VIP membership is active until {{ $user->membership_expires_at->format('d M Y') }}</p>
            </div>
        @endif
    </div>
    
    <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($plans as $plan)
            <div class="card bg-base-100 shadow-lg">
                <div class="card-body">
                    <h2 class="card-title">{{ $plan->name }}</h2>
                    <p class="text-2xl font-bold text-primary mb-2">Rp{{ number_format($plan->price, 0, ',', '.') }}</p>
                    <p class="mb-4">{{ $plan->description }}</p>
                    <ul class="mb-4 space-y-2">
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Duration: {{ $plan->duration_months }} Month(s)
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Special Discounts on Products
                        </li>
                        <li class="flex items-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-success mr-2" viewBox="0 0 20 20" fill="currentColor">
                                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd" />
                            </svg>
                            Exclusive Promotions
                        </li>
                    </ul>
                    <div class="card-actions justify-center">
                        @if($user->hasActiveMembership())
                            <button class="btn btn-disabled w-full" disabled>
                                Sudah Berlangganan 
                                <span class="badge badge-sm ml-2">
                                    Aktif s/d {{ $user->membership_expires_at->format('d M Y') }}
                                </span>
                            </button>
                        @else
                            <a href="{{ route('membership.checkout', $plan->id) }}" class="btn btn-primary w-full">
                                Subscribe Now
                            </a>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>
    
    <div class="mt-8">
        <a href="{{ route('membership.history') }}" class="btn btn-outline">View Membership History</a>
    </div>
</div>
@endsection