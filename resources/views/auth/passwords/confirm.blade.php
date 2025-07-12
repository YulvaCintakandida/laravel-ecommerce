@extends('layouts.auth-layout')

@section('content')
    <x-auth.card title="{{ __('Confirm Password') }}">
        <p class="mb-6 text-center">{{ __('Please confirm your password before continuing.') }}</p>

        <form method="POST" action="{{ route('password.confirm') }}">
            @csrf

            <div class="form-control w-full mb-4">
                <x-label for="password">{{ __('Password') }}</x-label>
                <x-input
                    type="password"
                    name="password"
                    id="password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                    icon='<svg class="h-[1em] opacity-50 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                    <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                                       stroke="currentColor">
                                                        <path
                                                            d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path>
                                                        <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                                                    </g>
                                                </svg>'
                >
                    <button type="button" id="togglePassword"
                            class="opacity-50 hover:opacity-100 transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[1.2em] show-password-off"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[1.2em] show-password-on hidden"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </x-input>
            </div>

            <div class="flex justify-between items-center my-5">
                <x-button-primary type="submit">
                    {{ __('Confirm Password') }}
                </x-button-primary>

                @if (Route::has('password.request'))
                    <a class="link link-primary text-sm"
                       href="{{ route('password.request') }}">
                        {{ __('Forgot Your Password?') }}
                    </a>
                @endif
            </div>
        </form>
    </x-auth.card>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const togglePassword = document.getElementById('togglePassword');
            const passwordInput = document.getElementById('password');
            const eyeOn = document.querySelector('.show-password-on');
            const eyeOff = document.querySelector('.show-password-off');

            if (togglePassword && passwordInput) {
                togglePassword.addEventListener('click', function () {
                    const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    passwordInput.setAttribute('type', type);
                    eyeOn.classList.toggle('hidden');
                    eyeOff.classList.toggle('hidden');
                });
            }
        });
    </script>
@endsection
