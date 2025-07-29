@extends('layouts.app')

@section('content')
    <div class="py-8 !pt-0">
        <section class="mb-6 flex flex-col md:flex-row justify-between items-center gap-4">
            <x-breadcrumb :items="[
                                        [
                                            'title' => 'Profile',
                                            'url' => route('profile.edit'),
                                            'icon' => 'heroicon-o-user'
                                        ],
                                        [
                                            'title' => 'Edit Profile',
                                            'current' => true,
                                            'icon' => 'heroicon-o-pencil'
                                        ]
                                    ]"/>
            <div class="text-right">
                <p>Welcome! <span class="font-bold">{{ $user->name }}</span></p>
            </div>
        </section>

        <form action="{{ route('profile.update') }}" method="POST">
            @csrf
            @method('PUT')

            <div class="flex flex-col md:flex-row gap-6">
                <div class="w-full md:w-1/6">
                    <div
                        class="tabs tabs-bordered tabs-vertical flex flex-col [--tab-border-color:theme(colors.primary)]">
                        <input type="radio" name="profile_tabs"
                               class="tab text-sm py-2 hover:text-primary [--tab-border-color:theme(colors.primary)] [&:checked]:text-primary bg-base-100 shadow"
                               aria-label="Profile" checked="checked"/>
                        <input type="radio" name="profile_tabs"
                               class="tab text-sm py-2 hover:text-primary [--tab-border-color:theme(colors.primary)] [&:checked]:text-primary bg-base-100 shadow"
                               aria-label="Address"/>
                        <input type="radio" name="profile_tabs"
                               class="tab text-sm py-2 hover:text-primary [--tab-border-color:theme(colors.primary)] [&:checked]:text-primary bg-base-100 shadow"
                               aria-label="Password"/>
                    </div>
                </div>

                <div class="w-full md:w-5/6">
                    <!-- Profile Tab Content -->
                    <div class="tab-content card shadow-lg border border-base-300 bg-base-100">
                        <div class="card-body">
                            <h3 class="text-lg font-medium mb-6">Profile Information</h3>

                            <div class="form-control w-full mb-4">
                                <x-label>{{ __('Membership Status') }}</x-label>
                                <div class="flex items-center gap-2 mt-2">
                                    @if($user->membership_type === 'vip' && $user->membership_expires_at && $user->membership_expires_at->isFuture())
                                        <div class="badge badge-lg badge-success gap-2">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z" />
                                            </svg>
                                            VIP Member
                                        </div>
                                        <span class="text-sm text-success">
                                            Active until: {{ $user->membership_expires_at->format('d M Y') }}
                                        </span>
                                    @else
                                        <div class="badge badge-lg badge-neutral">
                                            Regular Member
                                        </div>
                                        <a href="{{ route('membership.index') }}" class="text-sm text-primary underline hover:text-primary-focus">
                                            Upgrade to VIP
                                        </a>
                                    @endif
                                </div>
                            </div>

                            <div class="form-control w-full mb-4">
                                <x-label for="name">{{ __('Name') }}</x-label>
                                <x-input
                                    type="text"
                                    name="name"
                                    id="name"
                                    value="{{ old('name', $user->name) }}"
                                    required
                                    autocomplete="name"
                                    placeholder="Full Name"
                                    iconName="heroicon-o-document"
                                />
                            </div>

                            <div class="form-control w-full mb-4">
                                <x-label for="email">{{ __('Email Address') }}</x-label>
                                <x-input
                                    type="email"
                                    name="email"
                                    id="email"
                                    value="{{ old('email', $user->email) }}"
                                    required
                                    autocomplete="email"
                                    placeholder="mail@site.com"
                                    iconName="heroicon-o-envelope"
                                />
                            </div>

                            <div class="form-control w-full mb-4">
                                <x-label for="phone">{{ __('Phone Number') }}</x-label>
                                <x-input
                                    type="tel"
                                    name="phone"
                                    id="phone"
                                    value="{{ old('phone', $user->phone) }}"
                                    required
                                    autocomplete="phone"
                                    placeholder="Phone Number"
                                    iconName="heroicon-o-device-phone-mobile"
                                    pattern="[0-9]*"
                                    title="Phone number should contain only digits"
                                />
                            </div>

                            <div class="flex justify-end gap-3 mt-6">
                                <a href="{{ route('profile.edit') }}"
                                   class="btn btn-outline !border-primary !text-primary hover:!bg-primary/10">Cancel</a>
                                <x-button-primary type="submit">Update Profile</x-button-primary>
                            </div>
                        </div>
                    </div>

                    <!-- Address Tab Content -->
                    <div class="tab-content card shadow-lg border border-base-300 bg-base-100">
                        <div class="card-body">
                            <h3 class="text-lg font-medium mb-6">Address Information</h3>

                            <div class="form-control w-full mb-4">
                                <x-textarea
                                    name="address"
                                    id="address"
                                    legend="{{ __('Address') }}"
                                    value="{{ old('address', $user->address) }}"
                                    placeholder="Your address"
                                    required
                                    autocomplete="address"
                                    errorMessage="{{ $errors->first('address') }}"
                                />
                            </div>

                            <div class="flex justify-end gap-3 mt-6">
                                <a href="{{ route('profile.edit') }}"
                                   class="btn btn-outline !border-primary !text-primary hover:!bg-primary/10">Cancel</a>
                                <x-button-primary type="submit">Update Address</x-button-primary>
                            </div>
                        </div>
                    </div>

                    <!-- Password Tab Content -->
                    <div class="tab-content card shadow-lg border border-base-300 bg-base-100">
                        <div class="card-body">
                            <h3 class="text-lg font-medium mb-6">Change Password</h3>

                            <div class="form-control w-full mb-4">
                                <x-label for="current_password">{{ __('Current Password') }}</x-label>
                                <x-input
                                    type="password"
                                    name="current_password"
                                    id="current_password"
                                    placeholder="Current Password"
                                    iconName="heroicon-o-key"
                                />
                            </div>

                            <div class="form-control w-full mb-4">
                                <x-label for="password">{{ __('New Password') }}</x-label>
                                <x-input
                                    type="password"
                                    name="password"
                                    id="password"
                                    placeholder="New Password"
                                    iconName="heroicon-o-key"
                                />
                            </div>

                            <div class="form-control w-full mb-6">
                                <x-label for="password_confirmation">{{ __('Confirm New Password') }}</x-label>
                                <x-input
                                    type="password"
                                    name="password_confirmation"
                                    id="password_confirmation"
                                    placeholder="Confirm New Password"
                                    iconName="heroicon-o-key"
                                />
                            </div>

                            <div class="flex justify-end gap-3 mt-6">
                                <a href="{{ route('profile.edit') }}"
                                   class="btn btn-outline !border-primary !text-primary hover:!bg-primary/10">Cancel</a>
                                <x-button-primary type="submit">Update Password</x-button-primary>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const tabInputs = document.querySelectorAll('.tabs input[name="profile_tabs"]');
            const tabContents = document.querySelectorAll('.tab-content');

            tabInputs.forEach((input, index) => {
                input.addEventListener('change', function () {
                    tabContents.forEach(content => {
                        content.style.display = 'none';
                    });
                    tabContents[index].style.display = 'block';
                });

                // Initialize display
                if (input.checked) {
                    tabContents.forEach(content => {
                        content.style.display = 'none';
                    });
                    tabContents[index].style.display = 'block';
                }
            });

            // Ensure first tab is selected by default
            if (!Array.from(tabInputs).some(input => input.checked)) {
                tabInputs[0].checked = true;
                tabContents.forEach((content, idx) => {
                    content.style.display = idx === 0 ? 'block' : 'none';
                });
            }
        });
    </script>
@endsection
