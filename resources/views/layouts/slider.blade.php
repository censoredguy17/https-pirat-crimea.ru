@if(count($slider->images) > 0)
    <div id="pirateSlider" class="carousel slide carousel-fade" data-bs-ride="carousel">

        {{-- Индикаторы (монетки) --}}
        <div class="carousel-indicators">
            @foreach($slider->images as $index => $image)
                <button type="button"
                        data-bs-target="#pirateSlider"
                        data-bs-slide-to="{{ $index }}"
                        class="coin-indicator {{ $loop->first ? 'active' : '' }}">
                </button>
            @endforeach
        </div>

        <div class="carousel-inner">
            @foreach($slider->images as $image)
                <div class="carousel-item {{ $loop->first ? 'active' : '' }}" data-bs-interval="7000">
                    <img src="{{ $image->original }}" class="d-block w-100 slide-img" alt="{{ $image->alt }}">

                    {{-- Выводим блок с текстом только если есть заголовок ИЛИ описание --}}
                    @if($image->alt || $image->description)
                        <div class="carousel-caption d-none d-md-block">
                            <div class="parchment-text">
                                @if($image->alt)
                                    <h2 class="pirate-font gold-text">{{ $image->alt }}</h2>
                                @endif

                                @if($image->description)
                                    <p>{{ $image->description }}</p>
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
            @endforeach
        </div>

        {{-- Кнопки навигации (компасы) --}}
        <button class="carousel-control-prev" type="button" data-bs-target="#pirateSlider" data-bs-slide="prev">
            <i class="fas fa-compass fa-3x pirate-arrow" aria-hidden="true"></i>
            <span class="visually-hidden">Назад</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#pirateSlider" data-bs-slide="next">
            <i class="fas fa-compass fa-3x pirate-arrow fa-flip-horizontal" aria-hidden="true"></i>
            <span class="visually-hidden">Вперед</span>
        </button>
    </div>
@endif
