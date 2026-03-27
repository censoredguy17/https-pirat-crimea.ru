@extends('admin.layouts.app')
@section('title', 'Title')
@section('metaDescription', 'Description')
@section('metaKeywords', 'Keywords')

@section('content')

    <div class="container-fluid py-4">
        <div class="admin-editor-wrapper">

            <div class="editor-header-sticky d-flex justify-content-between align-items-center">
                <div class="header-info d-flex align-items-center">
                    <a href="{{ route('admin.sliders.index') }}" class="btn-back-circle me-3">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <div class="title-box">
                        <h2 class="editor-title mb-0">Новый <span class="text-warning">слайдер</span></h2>
                        <small class="text-muted text-uppercase letter-spacing-1">Подготовка нового холста</small>
                    </div>
                </div>

                <div class="header-actions">
                    <button type="submit" form="slider-create-form" class="btn-admin-save">
                        <i class="fas fa-anchor me-2"></i> Спустить на воду
                    </button>
                </div>
            </div>

            <form id="slider-create-form" action="{{ route('admin.sliders.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="row mt-4">
                    <div class="col-lg-8">
                        <div class="editor-card mb-4">
                            <h5 class="card-subtitle mb-4">
                                <i class="fas fa-paint-brush me-2 text-warning"></i>Внешний вид (на сайте)
                            </h5>

                            <div class="mb-4">
                                <label class="admin-label">Заголовок слайда</label>
                                <input type="text" class="admin-input" name="title" value="{{ old('title') }}" placeholder="Напр: Логово в Утесе">
                                @error('title') <div class="admin-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-0">
                                <label class="admin-label">Краткое описание</label>
                                <input type="text" class="admin-input" name="description" value="{{ old('description') }}" placeholder="Текст под заголовком...">
                                @error('description') <div class="admin-error">{{ $message }}</div> @enderror
                            </div>
                        </div>

                        <div class="editor-card">
                            <h5 class="card-subtitle mb-4">
                                <i class="fas fa-user-shield me-2 text-warning"></i>Служебная информация
                            </h5>

                            <div class="mb-4">
                                <label class="admin-label">Название для админки</label>
                                <input type="text" class="admin-input" name="admin_name" value="{{ old('admin_name') }}" placeholder="Техническое название...">
                                @error('admin_name') <div class="admin-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-0">
                                <label class="admin-label">Заметка боцмана (комментарий)</label>
                                <textarea class="admin-input ckeditor" name="admin_comment" rows="4">{{ old('admin_comment') }}</textarea>
                                @error('admin_comment') <div class="admin-error">{{ $message }}</div> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="editor-card mb-4">
                            <h5 class="card-subtitle mb-3 text-warning">Публикация</h5>
                            <div class="status-toggle-wrapper p-3">
                                <div class="form-check form-switch custom-switch">
                                    <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                           value="1" {{ old('is_active') ? 'checked' : '' }}>
                                    <label class="form-check-label text-white" for="is_active">Активировать сразу</label>
                                </div>
                            </div>
                            <p class="text-muted small mt-3 px-2">
                                <i class="fas fa-info-circle me-1"></i> Если выключено, слайд будет сохранен как черновик и не виден гостям.
                            </p>
                        </div>

                        <div class="editor-card info-sidebar-card">
                            <div class="text-center py-3">
                                <i class="fas fa-cloud-upload-alt text-muted fs-1 mb-3"></i>
                                <p class="small text-muted mb-0">После сохранения вы сможете добавить изображения для этого слайдера.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
