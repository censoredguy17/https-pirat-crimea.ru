@extends('admin.layouts.app')
@section('title', 'Title')
@section('metaDescription', 'Description')
@section('metaKeywords', 'Keywords')

@section('content')

    <div class="container">
        <div class="admin-action-bar d-flex align-items-center justify-content-between mt-4 mb-4 p-3">
            <div class="action-info d-flex align-items-center">
                <div class="action-icon-wrapper me-3">
                    <i class="fas fa-scroll text-warning fs-4"></i>
                </div>
                <div class="action-text">
                    <h4 class="m-0 text-white fs-6 text-uppercase letter-spacing-1">Управление парадом</h4>
                    <p class="m-0 small text-muted">Добавление нового холста в главный слайдер</p>
                </div>
            </div>

            <div class="action-buttons">
                <a href="{{ route('admin.sliders.create') }}" class="btn-pirate-add">
            <span class="icon-box">
                <i class="fa-solid fa-plus"></i>
            </span>
                    <span class="btn-text">Добавить слайдер</span>
                </a>
            </div>
        </div>

        @if($sliders && $sliders->count() > 0)
            <div class="row g-4 mb-5">
                @foreach($sliders as $slider)
                    <div class="col-xl-4 col-lg-6">
                        <div class="admin-slider-card">
                            <div class="slider-preview-wrapper">
                                <img src="{{ $slider->main_thumb }}" class="slider-img" alt="Slide">
                                <div class="slider-id-badge">ID: {{ $slider->id }}</div>

                                <div class="slider-overlay-action">
                                    <a href="{{ route('admin.sliders.edit', ['sliderId' => $slider->id]) }}" class="btn-glass">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                </div>
                            </div>

                            <div class="card-body p-3">
                                <div class="d-flex justify-content-between align-items-start mb-2">
                                    <h5 class="slider-admin-title text-truncate" title="{{ $slider->admin_name }}">
                                        {{ $slider->admin_name }}
                                    </h5>
                                </div>

                                @if($slider->admin_comment)
                                    <div class="admin-note">
                                        <i class="fas fa-quote-left me-2 text-warning" style="font-size: 0.7rem;"></i>
                                        {{ Str::limit($slider->admin_comment, 100) }}
                                    </div>
                                @endif
                            </div>

                            <div class="slider-footer">
                                <a href="{{ route('admin.sliders.edit', ['sliderId' => $slider->id]) }}" class="btn-manage-slide">
                                    <span class="me-2 text-dark"><i class="fas fa-cog"></i></span> Настроить слайд
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="admin-empty-state text-center py-5">
                <div class="empty-icon-circle">
                    <i class="fas fa-images"></i>
                </div>
                <p class="mt-3">Слайды не найдены. Время наполнить паруса!</p>
            </div>
        @endif
    </div>

@endsection
