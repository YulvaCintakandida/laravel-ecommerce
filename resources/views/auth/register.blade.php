@extends('layouts.auth-layout')

@section('content')
    <x-auth.card
        title="{{ __('Register') }}"
        footerLink="true"
        footerText="Already have an account?"
        footerLinkText="{{ __('Login') }}"
        footerLinkRoute="login"
    >
        <form method="POST" action="{{ route('register') }}">
            @csrf

            <div class="form-control w-full mb-4">
                <x-label for="name">{{ __('Name') }}</x-label>
                <x-input
                    type="text"
                    name="name"
                    id="name"
                    value="{{ old('name') }}"
                    required
                    autofocus
                    autocomplete="name"
                    placeholder="Full Name"
                    icon='<svg class="h-[1em] opacity-50 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                           <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                                              stroke="currentColor">
                                                               <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"></path>
                                                               <path d="M14 2v4a2 2 0 0 0 2 2h4"></path>
                                                           </g>
                                                       </svg>'
                />
            </div>

            <div class="form-control w-full mb-4">
                <x-label for="email">{{ __('Email Address') }}</x-label>
                <x-input
                    type="email"
                    name="email"
                    id="email"
                    value="{{ old('email') }}"
                    required
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

            <div class="form-control w-full mb-4">
                <x-label for="phone">{{ __('Phone Number') }}</x-label>
                <x-input
                    type="tel"
                    name="phone"
                    id="phone"
                    value="{{ old('phone') }}"
                    required
                    autocomplete="phone"
                    placeholder="Phone Number"
                    pattern="[0-9]*"
                    title="Phone number should contain only digits"
                    class="tabular-nums"
                    icon='<svg class="h-[1em] opacity-50 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 16 16">
                                                           <g fill="none">
                                                               <path
                                                                   d="M7.25 11.5C6.83579 11.5 6.5 11.8358 6.5 12.25C6.5 12.6642 6.83579 13 7.25 13H8.75C9.16421 13 9.5 12.6642 9.5 12.25C9.5 11.8358 9.16421 11.5 8.75 11.5H7.25Z"
                                                                   fill="currentColor"></path>
                                                               <path fill-rule="evenodd" clip-rule="evenodd"
                                                                     d="M6 1C4.61929 1 3.5 2.11929 3.5 3.5V12.5C3.5 13.8807 4.61929 15 6 15H10C11.3807 15 12.5 13.8807 12.5 12.5V3.5C12.5 2.11929 11.3807 1 10 1H6ZM10 2.5H9.5V3C9.5 3.27614 9.27614 3.5 9 3.5H7C6.72386 3.5 6.5 3.27614 6.5 3V2.5H6C5.44771 2.5 5 2.94772 5 3.5V12.5C5 13.0523 5.44772 13.5 6 13.5H10C10.5523 13.5 11 13.0523 11 12.5V3.5C11 2.94772 10.5523 2.5 10 2.5Z"
                                                                     fill="currentColor"></path>
                                                           </g>
                                                       </svg>'
                />

                @if(!$errors->has('phone'))
                    <div class="validator-hint text-xs text-gray-500 mt-1 hidden">Phone number should contain only
                        digits
                    </div>
                @endif
            </div>

            <div class="form-control w-full mb-4">
                <x-label for="address">{{ __('Address') }}</x-label>
                <x-input
                    type="text"
                    name="address"
                    id="address"
                    value="{{ old('address') }}"
                    required
                    autocomplete="address"
                    placeholder="Your address"
                    icon='<svg class="h-[1em] opacity-50 mr-2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24">
                                                           <g stroke-linejoin="round" stroke-linecap="round" stroke-width="2.5" fill="none"
                                                              stroke="currentColor">
                                                               <path
                                                                   d="M12 13C13.6569 13 15 11.6569 15 10C15 8.34315 13.6569 7 12 7C10.3431 7 9 8.34315 9 10C9 11.6569 10.3431 13 12 13Z"></path>
                                                               <path
                                                                   d="M19.5 10C19.5 16.7 12 22 12 22C12 22 4.5 16.7 4.5 10C4.5 6.13401 7.86 3 12 3C16.14 3 19.5 6.13401 19.5 10Z"></path>
                                                           </g>
                                                       </svg>'
                />
            </div>

            <div class="flex mt-6">
                <x-button-primary type="submit" class="w-full">
                    {{ __('Register') }}
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
