@props([
    'name' => '',
    'id' => null,
    'value' => '',
    'placeholder' => '',
    'required' => false,
    'autocomplete' => '',
    'errorMessage' => null,
    'class' => 'h-24 w-full',
    'legend' => null
])

@php
    $id = $id ?? $name;
    $hasError = !empty($errorMessage);

    if (isset($errors) && $errors->has($name)) {
        $hasError = true;
        $errorMessage = $errors->first($name);
    }

    $classes = $class;
    if ($hasError) {
        $classes .= ' textarea-error';
    }
@endphp

<fieldset class="fieldset form-control w-full mb-4">
    @if($legend)
        <legend class="fieldset-legend">{{ $legend }}</legend>
    @endif

    <textarea
        id="{{ $id }}"
        name="{{ $name }}"
        class="textarea {{ $classes }}"
        @if($required) required @endif
        @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
        placeholder="{{ $placeholder }}"
        {{ $attributes }}
    >{{ $value }}</textarea>

    @if($hasError)
        <div class="label mt-2">
            <span class="label-text-alt text-error">{{ $errorMessage }}</span>
        </div>
    @endif
</fieldset>
