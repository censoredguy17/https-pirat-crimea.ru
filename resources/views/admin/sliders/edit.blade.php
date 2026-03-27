@extends('admin.layouts.app')
@section('title', 'Title')
@section('metaDescription', 'Description')
@section('metaKeywords', 'Keywords')

@section('content')

    <div class="container-fluid py-4">
        <div class="admin-editor-wrapper">

            <div class="editor-header-sticky d-flex justify-content-between align-items-center">
                <div class="header-info d-flex align-items-center">
                    <a href="{{ route('admin.sliders.index') }}" class="btn-back-circle me-3" title="Вернуться к списку">
                        <i class="fas fa-chevron-left"></i>
                    </a>

                    <div class="title-box">
                        <h2 class="editor-title mb-0">
                            Редактирование слайда <span class="text-warning">#{{ $slider->id }}</span>
                        </h2>
                        <small class="text-muted text-uppercase letter-spacing-1" style="font-size: 0.65rem;">Панель управления шхуной</small>
                    </div>
                </div>

                <div class="header-actions d-flex gap-2">
                    <form method="POST" action="{{ route('admin.sliders.destroy', $slider->id) }}"
                          onsubmit="return confirm('Вы уверены, что хотите отправить этот слайд на дно?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin-danger">
                            <i class="fas fa-trash-alt me-2"></i> Удалить
                        </button>
                    </form>

                    <button type="submit" form="slider-main-form" class="btn-admin-save">
                        <i class="fas fa-check-circle me-2"></i> Сохранить изменения
                    </button>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-lg-8">
                    <div class="editor-card">
                        <form id="slider-main-form" action="{{ route('admin.sliders.update', $slider->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PATCH')

                            <div class="row">
                                <div class="col-md-6 mb-4">
                                    <label class="admin-label">Название (для сайта)</label>
                                    <input type="text" class="admin-input" name="title" value="{{ $slider->title }}">
                                    @error('title') <div class="admin-error">{{ $message }}</div> @enderror
                                </div>

                                <div class="col-md-6 mb-4">
                                    <label class="admin-label">Название (для админки)</label>
                                    <input type="text" class="admin-input" name="admin_name" value="{{ $slider->admin_name }}">
                                    @error('admin_name') <div class="admin-error">{{ $message }}</div> @enderror
                                </div>
                            </div>

                            <div class="mb-4">
                                <label class="admin-label">Краткое описание</label>
                                <input type="text" class="admin-input" name="description" value="{{ $slider->description }}">
                            </div>

                            <div class="mb-4">
                                <label class="admin-label">Комментарий боцмана (админ-заметка)</label>
                                <textarea class="admin-input ckeditor" name="admin_comment" rows="4">{{ $slider->admin_comment }}</textarea>
                            </div>
                        </form>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="editor-card mb-4">
                        <h5 class="card-subtitle mb-3 text-warning">Статус публикации</h5>
                        <div class="status-toggle-wrapper p-3">
                            <div class="form-check form-switch custom-switch">
                                <input class="form-check-input" type="checkbox" id="is_active" name="is_active"
                                       form="slider-main-form" value="1" {{ $slider->is_active ? 'checked' : '' }}>
                                <label class="form-check-label text-white" for="is_active">Опубликован на сайте</label>
                            </div>
                        </div>
                    </div>

                    <div class="editor-card">
                        <h5 class="card-subtitle mb-3 text-warning">
                            <i class="fas fa-info-circle me-2"></i>Мета-данные
                        </h5>
                        <ul class="list-unstyled admin-meta-list">
                            <li class="mb-3">
                                <span class="meta-label">Создан:</span>
                                <span class="meta-value">{{ $slider->created_at->format('d.m.Y H:i') }}</span>
                            </li>
                            <li>
                                <span class="meta-label">Изменен:</span>
                                <span class="meta-value">{{ $slider->updated_at->format('d.m.Y H:i') }}</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="container my-4">
        <div class="card shadow-sm p-4 bg-light">
            <h5 class="card-title mb-3">Upload Images</h5>
            <form action="{{ route('admin.sliders.images.upload') }}" method="POST" enctype="multipart/form-data"
                  class="d-flex flex-column gap-3">
                @csrf
                <!-- Выбор файлов -->
                <div class="mb-2">
                    <input type="file" name="images[]" multiple class="form-control">
                </div>

                <!-- Скрытые поля -->
                <input type="hidden" name="slider_id" value="{{ $slider->id }}">
                <!-- Кнопка загрузки -->
                <button type="submit" class="btn btn-primary w-25 align-self-start">Upload</button>
            </form>
        </div>
    </div>
    @if(isset($images))
        <div class="container my-4">
            <div id="gallery" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <input type="hidden" name="type_sort_images" value="slider">
                @foreach($images as $image)
                    <div class="col image-item" data-id="{{ $image->id }}">
                        <div class="card shadow-sm h-100 bg-light">
                            <!-- Изображение -->
                            <img src="{{ $image->thumb }}" class="card-img-top" alt="{{ $image->alt }}"
                                 style="object-fit: cover; height: 150px;">

                            <div class="card-body d-flex flex-column">
                                <!-- Форма редактирования -->
                                <form class="image-update-form mb-3" method="POST"
                                      action="{{ route('admin.sliders.images.update', $image) }}">
                                    @csrf
                                    @method('PATCH')
                                    <div class="mb-2">
                                        <input type="text" name="alt" value="{{ $image->alt }}"
                                               class="form-control form-control-sm" placeholder="Alt">
                                    </div>
                                    <div class="mb-2">
                                        <textarea name="description" class="form-control form-control-sm" rows="2"
                                                  placeholder="Description">{{ $image->description }}</textarea>
                                    </div>
                                    <div class="form-check mb-2">
                                        <input class="form-check-input" type="checkbox" name="is_active" value="1"
                                               id="activeCheck{{ $image->id }}" {{ $image->is_active ? 'checked' : '' }}>
                                        <label class="form-check-label" for="activeCheck{{ $image->id }}">Active</label>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-sm w-100">Save</button>
                                </form>

                                <!-- Кнопки Set Main и Delete -->
                                <div class="d-flex justify-content-between">
                                    <form class="image-update-form" data-type="setMain" method="POST" action="{{ route('admin.sliders.images.setMain', $image) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" {{ $image->is_main ? 'disabled' : '' }}>
                                            Set Main
                                        </button>
                                    </form>

                                    <form class="image-update-form" data-type="delete" method="POST" action="{{ route('admin.sliders.images.delete', $image) }}">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </div>
                            </div> <!-- card-body -->
                        </div> <!-- card -->
                    </div> <!-- col -->
                @endforeach
            </div> <!-- row -->
        </div> <!-- container -->
    @endif

@endsection
