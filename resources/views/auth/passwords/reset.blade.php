@extends('layouts.auth-layout')

@section('content')
    <x-auth.card title="{{ __('Reset Password') }}">
        <form method="POST" action="{{ route('password.update') }}">
            @csrf

            <input type="hidden" name="token" value="{{ $token }}">

            <div class="form-control w-full mb-4">
                <x-label for="email">{{ __('Email Address') }}</x-label>
                <x-input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ $email ?? old('email') }}"
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

            <div class="form-control w-full mb-4">
                <x-label for="password">{{ __('Password') }}</x-label>
                <label
                    class="input input-bordered w-full @error('password') input-error @enderror validator flex items-center"
                    x-data="{ focused: false }"
                    :class="{ 'ring ring-primary/30': focused }"
                >
                    <svg class="h-[1em] opacity-50 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                           stroke="currentColor">
                            <path
                                d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path>
                            <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                        </g>
                    </svg>
                    <input id="password" type="password" class="w-full border-0 bg-transparent focus:outline-none"
                           name="password" required autocomplete="new-password" placeholder="Password"
                           minlength="8" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}"
                           title="Must be more than 8 characters, including number, lowercase letter, uppercase letter"
                           @focus="focused = true"
                           @blur="focused = false">
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
                </label>

                @error('password')
                <label class="label mt-2">
                    <span class="label-text-alt text-error">{{ $message }}</span>
                </label>
                @else
                    <p class="validator-hint text-xs text-gray-500 mt-1 hidden">
                        Must be more than 8 characters, including
                        <br/>At least one number <br/>At least one lowercase letter <br/>At least one uppercase
                        letter
                    </p>
                    @enderror
            </div>

            <div class="form-control w-full mb-4">
                <x-label for="password-confirm">{{ __('Confirm Password') }}</x-label>
                <label
                    class="input input-bordered w-full validator flex items-center"
                    x-data="{ focused: false }"
                    :class="{ 'ring ring-primary/30': focused }"
                >
                    <svg class="h-[1em] opacity-50 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                        <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                           stroke="currentColor">
                            <path
                                d="M2.586 17.414A2 2 0 0 0 2 18.828V21a1 1 0 0 0 1 1h3a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h1a1 1 0 0 0 1-1v-1a1 1 0 0 1 1-1h.172a2 2 0 0 0 1.414-.586l.814-.814a6.5 6.5 0 1 0-4-4z"></path>
                            <circle cx="16.5" cy="7.5" r=".5" fill="currentColor"></circle>
                        </g>
                    </svg>
                    <input id="password-confirm" type="password"
                           class="w-full border-0 bg-transparent focus:outline-none"
                           name="password_confirmation" required autocomplete="new-password"
                           placeholder="Confirm Password"
                           @focus="focused = true"
                           @blur="focused = false"
                           oninput="validatePasswordMatch()">
                    <button type="button" id="toggleConfirmPassword"
                            class="opacity-50 hover:opacity-100 transition cursor-pointer">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[1.2em] show-confirm-password-off"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path
                                d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"></path>
                            <line x1="1" y1="1" x2="23" y2="23"></line>
                        </svg>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-[1.2em] show-confirm-password-on hidden"
                             viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                             stroke-linecap="round" stroke-linejoin="round">
                            <path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"></path>
                            <circle cx="12" cy="12" r="3"></circle>
                        </svg>
                    </button>
                </label>
                <div id="password-match-error" class="validator-hint text-xs text-error mt-1 hidden">
                    Passwords do not match
                </div>
            </div>

            <div class="flex my-5">
                <x-button-primary type="submit" class="w-full">
                    {{ __('Reset Password') }}
                </x-button-primary>
            </div>
        </form>
    </x-auth.card>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            // Password toggle functionality
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

            // Confirm password toggle functionality
            const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
            const confirmPasswordInput = document.getElementById('password-confirm');
            const confirmEyeOn = document.querySelector('.show-confirm-password-on');
            const confirmEyeOff = document.querySelector('.show-confirm-password-off');

            if (toggleConfirmPassword && confirmPasswordInput) {
                toggleConfirmPassword.addEventListener('click', function () {
                    const type = confirmPasswordInput.getAttribute('type') === 'password' ? 'text' : 'password';
                    confirmPasswordInput.setAttribute('type', type);
                    confirmEyeOn.classList.toggle('hidden');
                    confirmEyeOff.classList.toggle('hidden');
                });
            }

            // Validation hint handling
            const validators = document.querySelectorAll('.validator input');
            validators.forEach(input => {
                input.addEventListener('invalid', function () {
                    const hint = this.closest('.form-control').querySelector('.validator-hint');
                    if (hint) hint.classList.remove('hidden');
                });

                input.addEventListener('input', function () {
                    const hint = this.closest('.form-control').querySelector('.validator-hint');
                    if (hint && hint.id !== 'password-match-error') hint.classList.add('hidden');
                });
            });
        });

        // Password match validation
        function validatePasswordMatch() {
            const password = document.getElementById('password').value;
            const confirmPassword = document.getElementById('password-confirm').value;
            const errorElement = document.getElementById('password-match-error');

            if (confirmPassword === '') {
                errorElement.classList.add('hidden');
                return;
            }

            if (password !== confirmPassword) {
                errorElement.classList.remove('hidden');
                document.getElementById('password-confirm').setCustomValidity("Passwords do not match");
            } else {
                errorElement.classList.add('hidden');
                document.getElementById('password-confirm').setCustomValidity("");
            }
        }
    </script>
@endsection
