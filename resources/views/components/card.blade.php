@props([
    'title' => null,
    'class' => '',
])

<div {{ $attributes->merge(['class' => 'card bg-base-100 shadow-lg border border-base-300 ' . $class]) }}>
    <div class="card-body">
        @if($title)
            <h2 class="card-title text-2xl font-bold mb-4 flex justify-center text-primary">{{ $title }}</h2>
        @endif

        {{ $slot }}
    </div>
</div>
