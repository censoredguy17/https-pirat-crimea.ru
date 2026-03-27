@extends('layouts.app')

@section('content')

    <div class="container pb-5">

        @include('layouts.breadcrumbs')

        <h1 class="pirate-h1">{{ $content->title }}</h1>

        <div class="text-scroll-box js-collapse-section">
            @php
                // Используем наш хелпер (лимит 600 символов)
                $textData = smart_preview($content->textTop, 600);
            @endphp

            <div class="collapse-content-box">
                @if(!$textData['is_long'])
                    {{-- Короткий текст --}}
                    {!! $textData['full'] !!}
                @else
                    {{-- Длинный текст --}}
                    <div class="js-preview-text">
                        {!! $textData['preview'] !!}
                    </div>

                    <div class="js-full-text" style="display: none;">
                        {!! $textData['full'] !!}
                    </div>

                    <div class="text-center mt-3 js-btn-wrapper">
                        <hr style="opacity: 0.1;">
                        <button type="button" class="btn btn-sm btn-outline-dark js-expand-btn">
                            <span>Развернуть записи</span>
                            <i class="fas fa-chevron-down ms-1"></i>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        <div class="row g-4 mb-5">

            <div class="row g-4" id="pirate-gallery">
                @forelse($images as $image)
                    <div class="col-lg-3 col-md-3">
                        {{-- Ссылка на полное изображение для Lightbox --}}
                        <a href="{{ $image->original }}"
                           data-pswp-width="1600"
                           data-pswp-height="1067"
                           target="_blank">

                            <div class="gallery-item">
                                {{-- Превью изображения --}}
                                <img src="{{ $image->thumb }}"
                                     alt="{{ $image->alt ?? $content->listTitle }}"
                                     loading="lazy" />

                                {{-- Слой при наведении (сохраняем твой стиль) --}}
                                <div class="gallery-overlay">
                                    <i class="fas fa-expand"></i>
                                </div>
                            </div>
                        </a>

                        {{-- Если нужно выводить описание под фото --}}
                        @if($image->description)
                            <p class="text-muted small mt-2 italic px-2">{{ $image->description }}</p>
                        @endif
                    </div>
                @empty
                    {{-- Сообщение, если фотографий в альбоме нет --}}
                    <div class="col-12 text-center py-5">
                        <div class="empty-state-box p-5" style="background: rgba(255,255,255,0.03); border-radius: 20px; border: 1px dashed rgba(255,207,64,0.2);">
                            <i class="fas fa-camera-retro fa-3x text-muted mb-3 opacity-50"></i>
                            <h4 class="text-white">Пленка еще не проявлена</h4>
                            <p class="text-muted">В этом альбоме пока нет доступных снимков. Возвращайтесь позже!</p>
                            <a href="{{ route('gallery.index') }}" class="btn btn-outline-warning btn-sm mt-3">
                                <i class="fas fa-arrow-left me-1"></i> Назад в галерею
                            </a>
                        </div>
                    </div>
                @endforelse
            </div>


{{--            Видео--}}

            @if($videos->isNotEmpty())
                <section class="content-video-section py-5">
                    <div class="container">
                        <div class="text-center mb-5">
                            <h2 class="pirate-font gold-text h1">Видеохроники приключений</h2>
                            <div class="divider-gold mx-auto"></div>
                        </div>

                        <div class="row g-4 justify-content-center">
                            @foreach($videos as $video)
                                <div class="col-lg-6">
                                    <div class="video-container shadow-lg">

                                        {{-- Шапка видео с названием --}}
                                        <div class="video-title-bar">
                                            <i class="fas fa-scroll me-2 text-warning"></i>
                                            <span class="pirate-font text-white">
                                {{ $video->title ?? 'Тайна морских глубин' }}
                            </span>
                                        </div>

                                        {{-- Сам плеер --}}
                                        <div class="ratio ratio-16x9 pirate-video-frame">
                                            <iframe
                                                src="{{ $video->iframe }}"
                                                title="{{ $video->title }}"
                                                frameborder="0"
                                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                                allowfullscreen>
                                            </iframe>
                                        </div>

                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </section>
            @endif



            <div class="text-scroll-box js-collapse-section">
                @php
                    $contentData = smart_preview($content->textBottom, 600);
                @endphp

                <div class="collapse-content-box">
                    @if(!$contentData['is_long'])
                        {{-- Если текст короткий --}}
                        <div class="full-text">{!! $contentData['full'] !!}</div>
                    @else
                        {{-- Если текст длинный --}}
                        <div class="js-preview-text">
                            {!! $contentData['preview'] !!}
                        </div>

                        <div class="js-full-text" style="display: none;">
                            {!! $contentData['full'] !!}
                        </div>

                        <div class="text-center mt-3 js-btn-wrapper">
                            <hr style="opacity: 0.1;">
                            <button type="button" class="btn btn-sm btn-outline-dark js-expand-btn">
                                <span>Развернуть записи</span>
                                <i class="fas fa-chevron-down ms-1"></i>
                            </button>
                        </div>
                    @endif
                </div>

                <div class="publish-date mt-3" style="color: black">
                    <i class="fas fa-feather-alt me-2"></i>Бортовой журнал от: {{ $content->created_at->format('d.m.Y') }}
                </div>
            </div>

        </div>

@endsection
