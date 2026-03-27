@extends('admin.layouts.app')
@section('title', 'Title')
@section('metaDescription', 'Description')
@section('metaKeywords', 'Keywords')

@section('content')

    <div class="container-fluid py-4">
        <div class="admin-editor-wrapper">

            <div class="editor-header-sticky d-flex justify-content-between align-items-center">
                <div class="header-info d-flex align-items-center">
                    <a href="{{ route('admin.category.show', $category->id) }}" class="btn-back-circle me-3" title="Назад к списку">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <div class="title-box">
                        <h2 class="editor-title mb-0">Новая страница: <span class="text-warning">{{ $category->name }}</span></h2>
                        <small class="text-muted text-uppercase letter-spacing-1">Создание контента</small>
                    </div>
                </div>

                <div class="header-actions">
                    <button type="submit" form="content-create-form" class="btn-admin-save">
                        <i class="fas fa-plus-circle me-2"></i> Создать страницу
                    </button>
                </div>
            </div>

            <form id="content-create-form" action="{{ route('admin.content.store') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="categoryId" value="{{ $category->id }}">

                <div class="row mt-4">
                    <div class="col-lg-8">
                        <div class="editor-card mb-4">
                            <h5 class="card-subtitle mb-4">
                                <i class="fas fa-file-alt me-2 text-warning"></i>Основная информация
                            </h5>

                            <div class="mb-4">
                                <label class="admin-label">Название в списке (превью)</label>
                                <input type="text" class="admin-input" name="listTitle" value="{{ old('listTitle') }}" placeholder="Короткое название...">
                                @error('listTitle') <div class="admin-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="admin-label">Маленькое описание в списке</label>
                                <textarea class="admin-input" name="listDescription" rows="2" placeholder="Краткая суть для карточки...">{{ old('listDescription') }}</textarea>
                                @error('listDescription') <div class="admin-error">{{ $message }}</div> @enderror
                            </div>

                            <hr class="sidebar-divider">

                            <div class="mb-4">
                                <label class="admin-label">Полный заголовок страницы (H1)</label>
                                <input type="text" class="admin-input fs-5 fw-bold" name="title" value="{{ old('title') }}" placeholder="Введите основной заголовок...">
                                @error('title') <div class="admin-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="admin-label">Текст вверху страницы</label>
                                <textarea class="admin-input ckeditor" name="textTop">{{ old('textTop') }}</textarea>
                            </div>

                            <div class="mb-0">
                                <label class="admin-label">Текст внизу страницы</label>
                                <textarea class="admin-input ckeditor" name="textBottom">{{ old('textBottom') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="editor-card mb-4">
                            <h5 class="card-subtitle mb-3 text-warning">Публикация</h5>
                            <div class="form-check form-switch custom-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published"
                                       value="1" {{ old('is_published') ? 'checked' : '' }}>
                                <label class="form-check-label text-white" for="is_published">Опубликовать сразу</label>
                            </div>
                            <div class="mb-0">
                                <label class="admin-label">Дата публикации</label>
                                <input type="datetime-local" class="admin-input" name="published_at"
                                       value="{{ old('published_at', now()->format('Y-m-d\TH:i')) }}">
                            </div>
                        </div>

                        <div class="editor-card mb-4">
                            <label class="admin-label">Slug (URL адрес)</label>
                            <div class="slug-wrapper-custom d-flex align-items-center">
                                <div class="slug-prefix">/</div>
                                <input type="text" class="admin-input slug-input-field" value="{{ old('slug') }}" disabled placeholder="автогенерация...">
                            </div>
                            <div class="mt-2 d-flex align-items-center">
                                <i class="fas fa-magic text-warning me-2" style="font-size: 0.7rem;"></i>
                                <small class="text-muted" style="font-size: 0.75rem; color: gold!important;">Сформируется из заголовка</small>
                            </div>
                        </div>

                        <div class="editor-card mb-4">
                            <h5 class="card-subtitle mb-3 text-info"><i class="fas fa-search me-2"></i>SEO настройки</h5>
                            <div class="mb-3">
                                <label class="admin-label">Meta Title</label>
                                <input type="text" class="admin-input" name="metaTitle" value="{{ old('metaTitle') }}" placeholder="Для поисковиков...">
                            </div>
                            <div class="mb-0">
                                <label class="admin-label">Meta Description</label>
                                <textarea class="admin-input" name="metaDescription" rows="3" placeholder="Краткое SEO описание...">{{ old('metaDescription') }}</textarea>
                            </div>
                        </div>

                        <div class="editor-card info-sidebar-card">
                            <div class="d-flex align-items-center text-muted">
                                <i class="fas fa-lightbulb text-warning me-3 fs-3"></i>
                                <p class="small mb-0">Заполните заголовок, и система автоматически создаст для вас чистый URL-адрес.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
