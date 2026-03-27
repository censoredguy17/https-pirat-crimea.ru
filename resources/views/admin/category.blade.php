@extends('admin.layouts.app')
@section('title', 'Title')
@section('metaDescription', 'Description')
@section('metaKeywords', 'Keywords')

@section('content')
    <div class="container">


        <div class="admin-action-bar d-flex align-items-center justify-content-between mt-4 mb-4 p-3">
            <div class="action-info">
                <h4 class="m-0 text-white-50 fs-6 text-uppercase letter-spacing-1">Управление разделом</h4>
                <p class="m-0 small text-muted">Добавление новых сокровищ в категорию: <span class="text-warning">{{ $category->name }}</span></p>
            </div>

            <div class="action-buttons">
                <a href="{{ route('admin.content.create', ['categoryId' => $category->id]) }}" class="btn-pirate-add">
                    <span class="icon-box"><i class="fas fa-plus"></i></span>
                    <span class="btn-text">Добавить контент</span>
                </a>
            </div>
        </div>

        @if($contents && $contents->count() > 0)
            <div class="row g-4 mb-5">
                @foreach($contents as $content)
                    <div class="col-xl-4 col-lg-6 col-md-6">
                        <div class="admin-content-card">
                            <div class="card-image-wrapper">
                                <img src="{{ $content->main_thumb }}" class="card-img-top" alt="Thumb">
                                <div class="card-date-badge">
                                    <i class="far fa-calendar-alt me-1"></i>
                                    {{ $content->published_at->format('d.m.Y') }}
                                </div>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title text-truncate" title="{{ $content->listTitle }}">
                                    {{ $content->listTitle }}
                                </h5>
                                <p class="card-text text-muted">
                                    {{ Str::limit($content->listDescription, 85) }}
                                </p>
                            </div>

                            <div class="card-actions">
                                <a href="{{ route('admin.content.edit', ['contentId' => $content->id]) }}"
                                   class="btn-admin-edit">
                                    <i class="fas fa-edit me-2"></i> Править
                                </a>
                                <a href="#" class="btn-admin-view">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @else
            <div class="admin-empty-state text-center py-5">
                <i class="fas fa-box-open mb-3"></i>
                <p>На горизонте пусто... Записей пока нет.</p>
            </div>
        @endif
    </div>
@endsection
