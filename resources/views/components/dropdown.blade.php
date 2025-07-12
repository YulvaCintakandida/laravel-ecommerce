@props(['align' => 'right', 'width' => '52', 'id' => 'dropdown-' . uniqid()])

@php
    // Explicitly extract the align variable from $attributes
    $align = $align ?? 'right';

    $alignmentClasses = match($align) {
        'left' => 'left-0',
        'center' => 'left-1/2 transform -translate-x-1/2',
        default => 'right-0',
    };
@endphp

<div class="relative" x-data="{ open: false }" @click.away="open = false" @keydown.escape.window="open = false">
    <!-- Trigger -->
    <div @click="open = !open">
        {{ $trigger ?? '' }}
    </div>

    <!-- Dropdown Content -->
    <div x-show="open"
         x-transition:enter="transition ease-out duration-200"
         x-transition:enter-start="transform opacity-0 scale-95"
         x-transition:enter-end="transform opacity-100 scale-100"
         x-transition:leave="transition ease-in duration-75"
         x-transition:leave-start="transform opacity-100 scale-100"
         x-transition:leave-end="transform opacity-0 scale-95"
         class="absolute {{ $alignmentClasses }} mt-2 bg-white rounded-md shadow-lg py-1 z-50"
         style="display: none; width: {{ $width }}rem;">
        {{ $slot }}
    </div>
</div>
