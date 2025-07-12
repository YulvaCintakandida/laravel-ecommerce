@extends('layouts.auth-layout')

@section('content')
    <x-auth.card
        title="{{ __('Login') }}"
        footerLink="true"
        footerText="Don't have an account?"
        footerLinkText="{{ __('Register') }}"
        footerLinkRoute="register"
    >
        <form method="POST" action="{{ route('login') }}">
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
                                                                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                                                            <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                                                            <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                                                                        </g>
                                                                    </svg>'
                />

                @error('email')
                @if($message !== 'These credentials do not match our records.')
                    <label class="label mt-2">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @endif
                @else
                    <div class="validator-hint text-xs text-gray-500 mt-1 hidden">Enter valid email address</div>
                    @enderror
            </div>

            <div class="form-control w-full mb-4">
                <div class="flex justify-between w-full">
                    <x-label for="password">{{ __('Password') }}</x-label>
                    @if (Route::has('password.request'))
                        <a class="link link-primary text-sm"
                           href="{{ route('password.request') }}">
                            {{ __('Forgot Your Password?') }}
                        </a>
                    @endif
                </div>

                <x-input
                    type="password"
                    name="password"
                    id="password"
                    required
                    autocomplete="current-password"
                    placeholder="Password"
                    icon='<svg class="h-[1em] opacity-50 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none" stroke="currentColor">
                                                                            <path d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path>
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

                @error('password')
                @if($message !== 'These credentials do not match our records.')
                    <label class="label mt-2">
                        <span class="label-text-alt text-error">{{ $message }}</span>
                    </label>
                @endif
                @enderror
            </div>

            <div class="form-control my-5">
                <label class="label cursor-pointer justify-start">
                    <input id="remember" type="checkbox" class="checkbox checkbox-primary"
                           name="remember" {{ old('remember') ? 'checked' : '' }}>
                    <span class="label-text ml-2">{{ __('Remember Me') }}</span>
                </label>
            </div>

            <x-button-primary
                type="submit"
                class="w-full"
            >
                {{ __('Login') }}
            </x-button-primary>
        </form>

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
    </x-auth.card>
@endsection
