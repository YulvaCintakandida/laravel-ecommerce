@props([
    'title' => '',
    'footerLink' => null,
    'footerText' => '',
    'footerLinkText' => '',
    'footerLinkRoute' => '',
])

<div class="card bg-base-100 shadow-lg border border-base-300">
    <div class="card-body">
        <h2 class="card-title text-2xl font-bold mb-4 flex justify-center text-primary">{{ $title }}</h2>

        {{ $slot }}

        @if($footerLink)
            <span class="text-center label mt-2 flex justify-center">
                {{ $footerText }}
                <a class="link link-primary" href="{{ route($footerLinkRoute) }}">
                    {{ $footerLinkText }}
                </a>
            </span>
        @endif
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        const validators = document.querySelectorAll('.validator input');
        validators.forEach(input => {
            input.addEventListener('invalid', function () {
                const hint = this.closest('.form-control').querySelector('.validator-hint');
                if (hint) hint.classList.remove('hidden');
            });

            input.addEventListener('input', function () {
                const hint = this.closest('.form-control').querySelector('.validator-hint');
                if (hint) hint.classList.add('hidden');
            });
        });
    });
</script>
