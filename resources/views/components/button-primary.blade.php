@props([
    'type' => 'button',
    'icon' => null,
    'disabled' => false
])

<button
    type="{{ $type }}"
    {{ $attributes->merge([
        'class' => 'btn btn-primary',
        'disabled' => $disabled
    ]) }}
>
    @if($icon)
        <span class="mr-2">{!! $icon !!}</span>
    @endif
    {{ $slot }}
</button>
