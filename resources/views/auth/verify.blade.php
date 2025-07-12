@extends('layouts.auth-layout')

@section('content')
    <x-auth.card title="{{ __('Verify Your Email Address') }}">
        @if (session('resent'))
            <div class="alert alert-success mb-4" role="alert">
                {{ __('A fresh verification link has been sent to your email address.') }}
            </div>
        @endif

        <p class="mb-4 text-center">{{ __('Before proceeding, please check your email for a verification link.') }}</p>

        <p class="mb-4 text-center">
            {{ __('If you did not receive the email') }},
        <form class="inline" method="POST" action="{{ route('verification.resend') }}">
            @csrf
            <x-button-primary
                type="submit"
                class="btn-link btn-sm p-0 m-0 h-auto min-h-0 normal-case font-normal"
            >
                {{ __('click here to request another') }}
            </x-button-primary>
            .
        </form>
        </p>
    </x-auth.card>
@endsection
