@extends('layouts.app')

@section('content')

    <div class="container pb-5">

        @include('layouts.breadcrumbs')

        {{-- Проверка на заголовок --}}
        @if($category->title)
            <h1 class="pirate-h1">{{ $category->title }}</h1>
        @endif

        {{-- Проверка на описание --}}
        @if($category->description)
            <div class="text-scroll-box">
                {{ strip_tags($category->description) }}
            </div>
        @endif

        <section class="entertainment-section py-5">
            <div class="container">

                <div class="row g-4">
                    @forelse($contents as $content)
                        <div class="col-lg-4 col-md-6">
                            <div class="pirate-card h-100">
                                <div class="card-img-container">
                                    <img src="{{ $content->main_thumb }}" class="card-img-top" alt="Охота за сокровищами">
                                    <div class="card-date-badge">
                                        <span class="date-day">{{ $content->created_at->format('d') }}</span>
                                        <span class="date-month">{{ $content->created_at->translatedFormat('M') }}</span>
                                    </div>
                                </div>
                                <div class="card-body pirate-bg-parchment text-center">
                                    <h4 class="pirate-font card-title gold-text">{{ $content->listTitle }}</h4>
                                    <p class="card-text text-dark">{{ $content->listDescription }}</p>
                                    <a href="{{ route('content', ['slug' => $content->slug]) }}" class="btn pirate-btn-sm mt-2">Подробнее</a>
                                </div>
                            </div>
                        </div>
                    @empty
                        {{-- Блок, который покажется, если массив $contents пуст --}}
                        <div class="col-12 text-center py-5">
                            <div class="pirate-card p-5 d-inline-block shadow-lg" style="max-width: 600px; background: rgba(0,0,0,0.2);">
                                <div class="mb-4">
                                    <i class="fas fa-skull-crossbones gold-text" style="font-size: 4rem;"></i>
                                </div>
                                <h3 class="pirate-font text-white mb-3">Сундук пуст!</h3>
                                <p class="gold-text fs-5">В этой категории пока нет новостей или квестов. <br> Скорее всего, пираты ушли на новое дело.</p>
                                <a href="{{ url('/') }}" class="btn pirate-btn-sm mt-3">Вернуться в гавань</a>
                            </div>
                        </div>
                    @endforelse
                </div>
            </div>
        </section>

@endsection
