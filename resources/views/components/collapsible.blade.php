@props([
    'title' => '',
    'open' => false,
    'card' => true,
])

<div
    x-data="{ open: {{ $open ? 'true' : 'false' }} }"
    {{ $attributes->merge(['class' => $card ? 'card bg-base-100 shadow border border-base-300' : '']) }}
>
    <div
        @click="open = !open"
        class="cursor-pointer flex justify-between items-center {{ $card ? 'card-title p-4' : 'p-2 font-medium' }}"
    >
        <span>{{ $title }}</span>
        <button type="button" class="btn btn-sm btn-ghost">
            <svg
                :class="{'rotate-180': open}"
                class="w-4 h-4 transition-transform"
                fill="none"
                stroke="currentColor"
                viewBox="0 0 24 24"
            >
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
            </svg>
        </button>
    </div>
    <div
        x-show="open"
        x-transition
        class="{{ $card ? 'card-body pt-0 px-4 pb-4' : 'p-2' }}"
    >
        {{ $slot }}
    </div>
</div>
