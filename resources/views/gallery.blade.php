@extends('layouts.app')

@section('content')

    <div class="container pb-5">

        @include('layouts.breadcrumbs')

        <div class="gallery-header text-center mb-5">
            <h1 class="display-4 fw-bold text-white mb-3">Галерея <span class="text-warning">Экспедиций</span></h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px;">
                Взгляните на наши архивные снимки и запечатленные моменты великих открытий. Каждый альбом — это
                отдельная история, полная приключений.
            </p>
            <div class="header-divider mt-4"></div>
        </div>

        <div class="row row-cols-1 row-cols-md-2 row-cols-lg-3 g-4">
            {{-- 1. Проверяем, существует ли переменная вообще --}}
            @isset($albums)
                {{-- 2. Если существует, используем forelse для обхода или вывода @empty --}}
                @forelse($albums as $album)
                    <div class="col">
                        <div class="album-card-wrapper">
                            <a href="{{ route('content', ['slug' => $album->slug]) }}" class="album-card">
                                <div class="album-image-wrapper">
                                    <img src="{{ $album->main_thumb }}" alt="{{ $album->listTitle }}" class="album-img">
                                    <div class="album-hover-overlay">
                                        <span class="btn-view-album">
                                            <i class="fas fa-search-plus"></i>
                                        </span>
                                    </div>
                                    <div class="album-date-badge">
                                        <span class="day">{{ $album->created_at->format('d-m-Y') }}</span>
                                    </div>
                                </div>

                                <div class="album-content">
                                    <div class="album-info">
                                        <h3 class="album-title">{{ $album->listTitle }}</h3>
                                        <p class="album-description">
                                            {{ Str::limit($album->listDescription, 85) }}
                                        </p>
                                    </div>

                                    <div class="album-footer d-flex justify-content-between align-items-center mt-auto">
                                        <span class="photo-stats">
                                            <i class="fas fa-camera me-1"></i> {{ count($album->images) }} кадров
                                        </span>
                                        <span class="btn-album-link">
                                            Смотреть <i class="fas fa-arrow-right ms-1"></i>
                                        </span>
                                    </div>
                                </div>
                            </a>
                        </div>
                    </div>
                @empty
                    {{-- Блок, если переменная есть, но в базе 0 записей --}}
                    @include('gallery.partials.empty-state')
                @endforelse
            @else
                {{-- 3. Блок на случай, если переменную забыли передать из контроллера --}}
                <div class="col-12 w-100">
                    <div class="empty-gallery-box text-center py-5">
                        <div class="empty-icon-wrapper mb-4">
                            <i class="fas fa-exclamation-triangle text-warning"></i>
                        </div>
                        <h3 class="text-white mb-2">Сокровища еще в пути</h3>
                        <p class="text-muted mb-4">Альбомы временно недоступны. <br> Мы уже выслали почтовых голубей за
                            контентом!</p>
                        <a href="{{ url('/') }}" class="btn-back-link text-warning text-decoration-none">
                            <i class="fas fa-arrow-left me-2"></i> Вернуться на главную
                        </a>
                    </div>
                </div>
            @endisset
        </div>
    </div>

@endsection
