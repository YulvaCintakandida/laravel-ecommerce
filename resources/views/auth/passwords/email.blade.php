@extends('layouts.auth-layout')

@section('content')
    <x-auth.card title="{{ __('Reset Password') }}">
        @if (session('status'))
            <div class="alert alert-success mb-4" role="alert">
                {{ session('status') }}
            </div>
        @endif

        <form method="POST" action="{{ route('password.email') }}">
            @csrf

            <div class="form-control w-full mb-4">
                <x-label for="email">{{ __('Email Address') }}</x-label>
                <x-input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
                    autofocus
                    autocomplete="email"
                    placeholder="mail@site.com"
                    icon='<svg class="h-[1em] opacity-50 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                       <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                                          stroke="currentColor">
                                                           <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                                           <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                                       </g>
                                                   </svg>'
                />

                @if(!$errors->has('email'))
                    <div class="validator-hint text-xs text-gray-500 mt-1 hidden">Enter valid email address</div>
                @endif
            </div>

            <div class="flex my-5">
                <x-button-primary type="submit" class="w-full">
                    {{ __('Send Password Reset Link') }}
                </x-button-primary>
            </div>
        </form>
    </x-auth.card>
@endsection
