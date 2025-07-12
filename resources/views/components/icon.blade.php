@props([
            'name' => '',
            'type' => 'outline', // options: 'outline', 'solid', 'mini'
            'class' => 'h-5 w-5',
        ])

@php
    // Make sure variables are defined before using them
    $name = $name ?? '';

    // Check if name already includes a heroicon prefix
    if (str_starts_with($name, 'heroicon-')) {
        $iconName = $name;
    } else {
        $type = $type ?? 'outline';
        $prefix = match ($type) {
            'solid' => 'heroicon-s-',
            'mini' => 'heroicon-m-',
            default => 'heroicon-o-',
        };
        $iconName = $prefix . $name;
    }
@endphp

@if ($name)
    @svg($iconName, $class)
@else
    <svg class="{{ $class }}" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
    </svg>
@endif
