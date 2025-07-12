@props(['items' => []])

<div class="breadcrumbs text-sm">
    <ul>
        @foreach($items as $index => $item)
            <li>
                @if(isset($item['current']) && $item['current'])
                    <span class="inline-flex items-center gap-2 !cursor-default !no-underline">
        @if(isset($item['icon']))
                            <x-icon :name="$item['icon']" class="h-4 w-4 stroke-current"/>
                        @endif
                        {{ $item['title'] }}
    </span>
                @else
                    <a href="{{ $item['url'] }}">
                        @if(isset($item['icon']))
                            <x-icon :name="$item['icon']" class="h-4 w-4 stroke-current"/>
                        @endif
                        {{ $item['title'] }}
                    </a>
                @endif
            </li>
        @endforeach
    </ul>
</div>
