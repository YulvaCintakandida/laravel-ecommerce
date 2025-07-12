@props([
        'type' => 'text',
        'name' => '',
        'id' => null,
        'value' => '',
        'placeholder' => '',
        'required' => false,
        'autofocus' => false,
        'autocomplete' => '',
        'icon' => null,
        'iconName' => null,
        'iconType' => 'outline',
        'errorMessage' => null,
        'checked' => false
    ])

@php
    $id = $id ?? $name;
    $hasError = !empty($errorMessage);

    if (isset($errors) && $errors->has($name)) {
        $hasError = true;
    }

    $isCheckboxOrRadio = in_array($type, ['checkbox', 'radio']);
@endphp

@if($isCheckboxOrRadio)
    <input
        id="{{ $id }}"
        type="{{ $type }}"
        name="{{ $name }}"
        value="{{ $value }}"
        @if($checked) checked @endif
        @if($required) required @endif
        @if($autofocus) autofocus @endif
        class="@if($type === 'checkbox') checkbox-primary checkbox @else radio-primary radio @endif {{ $attributes->get('class') }}"
        {{ $attributes->except('class') }}
    />
@else
    <div x-data="{ focused: false }" class="form-control w-full">
        <label
            class="input input-bordered w-full @if($hasError) input-error @endif validator flex items-center"
            :class="{ 'ring ring-primary/30': focused }"
        >
            @if($iconName)
                <x-icon :name="$iconName" :type="$iconType" class="h-[1em] opacity-50 mr-2"/>
            @elseif($icon)
                {!! $icon !!}
            @endif

            <input
                id="{{ $id }}"
                type="{{ $type }}"
                name="{{ $name }}"
                value="{{ $value }}"
                placeholder="{{ $placeholder }}"
                @if($required) required @endif
                @if($autofocus) autofocus @endif
                @if($autocomplete) autocomplete="{{ $autocomplete }}" @endif
                class="w-full border-0 bg-transparent focus:outline-none"
                @focus="focused = true"
                @blur="focused = false"
                {{ $attributes }}
            />

            @if($type === 'password')
                <button type="button" x-data="{ show: false }"
                        @click="show = !show; $el.previousElementSibling.type = show ? 'text' : 'password'"
                        class="opacity-50 hover:opacity-100 transition cursor-pointer">
                    <i class="fa-solid fa-eye-slash" x-show="!show"></i>
                    <i class="fa-solid fa-eye" x-show="show" style="display: none;"></i>
                </button>
            @endif

            {{ $slot ?? '' }}
        </label>

        @if(!empty($errorMessage))
            <label class="label mt-2">
                <span class="label-text-alt text-error">{{ $errorMessage }}</span>
            </label>
        @elseif(isset($errors) && $errors->has($name))
            <label class="label mt-2">
                <span class="label-text-alt text-error">{{ $errors->first($name) }}</span>
            </label>
        @else
            <div class="validator-hint text-xs text-gray-500 mt-1 hidden">Please enter a valid {{ $name }}</div>
        @endif
    </div>
@endif
