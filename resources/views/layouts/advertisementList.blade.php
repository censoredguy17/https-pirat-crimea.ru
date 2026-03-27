@if($adverts->isNotEmpty())
    <section class="entertainment-section py-5">
        <div class="container">
            <div class="text-center mb-5">
                <h2 class="pirate-font section-main-title">Морские Забавы</h2>
                <div class="divider-gold mx-auto"></div>
            </div>

            <div class="row g-4 justify-content-center">
                @foreach($adverts as $content)
                    <div class="col-lg-4 col-md-6">
                        <div class="pirate-card h-100">
                            <div class="card-img-container">
                                {{-- Используем фото из контента --}}
                                <img src="{{ $content->main_thumb }}" class="card-img-top" alt="{{ $content->listTitle }}">

                                <div class="card-date-badge">
                                    <span class="date-day">{{ $content->created_at->format('d') }}</span>
                                    <span class="date-month">{{ $content->created_at->translatedFormat('M') }}</span>
                                </div>
                            </div>
                            <div class="card-body pirate-bg-parchment text-center">
                                <h4 class="pirate-font card-title gold-text">{{ $content->listTitle }}</h4>
                                <p class="card-text text-dark">{{ $content->listDescription }}</p>

                                {{-- Ссылка на детальную страницу --}}
                                <a href="{{ route('content', ['slug' => $content->slug]) }}" class="btn pirate-btn-sm mt-2">
                                    Подробнее
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="text-center mt-5">
                {{-- Ссылка на общую категорию развлечений --}}
                <a href="/category/advert" class="btn pirate-btn-lg px-5 py-3">
                    <i class="fas fa-skull me-2"></i> Перейти ко всем развлечениям
                </a>
            </div>
        </div>
    </section>
@endif
