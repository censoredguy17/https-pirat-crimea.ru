<nav aria-label="breadcrumb" class="pirate-breadcrumb-nav">
    <ol class="breadcrumb mb-0">
        <li class="breadcrumb-item">
            <a href="{{ url('/') }}"><i class="fas fa-home me-1"></i>Главная</a>
        </li>

        @if(isset($breadcrumbs) && count($breadcrumbs) > 0)
            @foreach($breadcrumbs as $breadcrumb)
                @if(!$loop->last && isset($breadcrumb['url']))
                    {{-- Промежуточные ссылки --}}
                    <li class="breadcrumb-item">
                        <a href="{{ $breadcrumb['url'] }}">{{ $breadcrumb['title'] }}</a>
                    </li>
                @else
                    {{-- Последний элемент (текущая страница) --}}
                    <li class="breadcrumb-item active" aria-current="page">
                        {{ $breadcrumb['title'] }}
                    </li>
                @endif
            @endforeach
        @endif
    </ol>
</nav>
