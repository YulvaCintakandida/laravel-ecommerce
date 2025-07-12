@props([
    'for' => null,
    'text' => null,
    'class' => 'mb-4',
])

<label for="{{ $for }}" {{ $attributes->merge(['class' => "label {$class}"]) }}>
    <span class="label-text">{{ $text ?? $slot }}</span>
</label>
