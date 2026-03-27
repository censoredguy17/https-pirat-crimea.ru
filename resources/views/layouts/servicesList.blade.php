@if($services->isNotEmpty())
    <section class="services-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="pirate-font section-main-title text-white">Корабельные Услуги</h2>
                <p class="gold-text">Всё, что нужно для настоящего морского похода</p>
            </div>

            {{-- Центрируем колонки, если их меньше трех --}}
            <div class="row g-5 justify-content-center">
                @foreach($services as $content)
                    <div class="col-lg-4 col-md-6 text-center">
                        <div class="service-item">
                            <div class="porthole-frame mx-auto mb-4">
                                <div class="porthole-content">
                                    {{-- Фото услуги --}}
                                    <img src="{{ $content->main_thumb }}" alt="{{ $content->listTitle }}">
                                </div>
                            </div>

                            {{-- Название услуги --}}
                            <h3 class="pirate-font gold-text h2">{{ $content->listTitle }}</h3>

                            {{-- Описание услуги --}}
                            <p class="text-light px-3">{{ $content->listDescription }}</p>

                            {{-- Ссылка на детальную страницу --}}
                            <a href="{{ route('content', ['slug' => $content->slug]) }}" class="btn btn-outline-gold mt-3">
                                Подробнее
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- Кнопка "Весь прейскурант" (показываем всегда или по условию count) --}}
            <div class="text-center mt-5">
                <a href="/category/services" class="btn pirate-btn-bronze px-5 py-3">
                    <i class="fas fa-anchor me-2"></i> Посмотреть все услуги
                </a>
            </div>
        </div>
    </section>
@endif
