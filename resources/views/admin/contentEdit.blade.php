@extends('admin.layouts.app')
@section('title', 'Title')
@section('metaDescription', 'Description')
@section('metaKeywords', 'Keywords')

@section('content')

    <div class="container-fluid py-4">
        <div class="admin-editor-wrapper">

            <div class="editor-header-sticky d-flex justify-content-between align-items-center">
                <div class="header-info d-flex align-items-center">
                    <a href="{{ route('admin.category.show', $category->id) }}" class="btn-back-circle me-3">
                        <i class="fas fa-chevron-left"></i>
                    </a>
                    <div class="title-box">
                        <h2 class="editor-title mb-0">Раздел: <span class="text-warning">{{ $category->name }}</span></h2>
                        <small class="text-muted text-uppercase letter-spacing-1">Редактирование страницы</small>
                    </div>
                </div>

                <div class="header-actions d-flex gap-2">
                    <form method="POST" action="{{ route('admin.content.delete', $content->id) }}"
                          onsubmit="return confirm('Вы уверены, что хотите уничтожить этот контент?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn-admin-danger">
                            <i class="fas fa-trash-alt me-2"></i> Удалить
                        </button>
                    </form>

                    <button type="submit" form="content-main-form" class="btn-admin-save">
                        <i class="fas fa-check-circle me-2"></i> Сохранить контент
                    </button>
                </div>
            </div>

            <form id="content-main-form" action="{{ route('admin.content.update', $content->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PATCH')
                <input type="hidden" name="categoryId" value="{{ $category->id }}">

                <div class="row mt-4">
                    <div class="col-lg-8">
                        <div class="editor-card mb-4">
                            <h5 class="card-subtitle mb-4"><i class="fas fa-pen-nib me-2 text-warning"></i>Заголовки и тексты</h5>

                            <div class="mb-4">
                                <label class="admin-label">Название в списке (превью)</label>
                                <input type="text" class="admin-input" name="listTitle" value="{{ $content->listTitle }}">
                                @error('listTitle') <div class="admin-error">{{ $message }}</div> @enderror
                            </div>

                            <div class="mb-4">
                                <label class="admin-label">Краткое описание в списке</label>
                                <textarea class="admin-input" name="listDescription" rows="2">{{ $content->listDescription }}</textarea>
                            </div>

                            <hr class="sidebar-divider">

                            <div class="mb-4">
                                <label class="admin-label">Название страницы (H1)</label>
                                <input type="text" class="admin-input fs-5 fw-bold" name="title" value="{{ $content->title }}">
                            </div>

                            <div class="mb-4">
                                <label class="admin-label">Верхний текстовый блок</label>
                                <textarea class="admin-input ckeditor" name="textTop">{{ $content->textTop }}</textarea>
                            </div>

                            <div class="mb-0">
                                <label class="admin-label">Нижний текстовый блок</label>
                                <textarea class="admin-input ckeditor" name="textBottom">{{ $content->textBottom }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-4">
                        <div class="editor-card mb-4">
                            <h5 class="card-subtitle mb-3 text-warning">Публикация</h5>
                            <div class="form-check form-switch custom-switch mb-3">
                                <input class="form-check-input" type="checkbox" id="is_published" name="is_published"
                                       value="1" {{ $content->is_published ? 'checked' : '' }}>
                                <label class="form-check-label text-white" for="is_published">Статус: Опубликовано</label>
                            </div>
                            <div class="mb-0">
                                <label class="admin-label">Дата публикации</label>
                                <input type="datetime-local" class="admin-input" name="published_at" value="{{ $content->published_at }}">
                            </div>
                        </div>

                        <div class="editor-card mb-4">
                            <label class="admin-label">Slug (URL адрес)</label>
                            <div class="slug-wrapper-custom d-flex align-items-center">
                                <div class="slug-prefix">/</div>
                                <input type="text" class="admin-input slug-input-field" value="{{ $content->slug }}" disabled>
                            </div>
                            <div class="mt-2 d-flex align-items-center">
                                <i class="fas fa-magic text-warning me-2" style="font-size: 0.7rem;"></i>
                                <small class="text-muted" style="font-size: 0.75rem; color: gold!important;">Генерируется автоматически из заголовка</small>
                            </div>
                        </div>

                        <div class="editor-card mb-4">
                            <h5 class="card-subtitle mb-3 text-info"><i class="fas fa-search me-2"></i>SEO настройки</h5>
                            <div class="mb-3">
                                <label class="admin-label">Meta Title</label>
                                <input type="text" class="admin-input" name="metaTitle" value="{{ $content->metaTitle }}">
                            </div>
                            <div class="mb-0">
                                <label class="admin-label">Meta Description</label>
                                <textarea class="admin-input" name="metaDescription" rows="3">{{ $content->metaDescription }}</textarea>
                            </div>
                        </div>

                        <div class="editor-card">
                            <ul class="list-unstyled admin-meta-list mb-0">
                                <li>
                                    <span class="meta-label">ID контента:</span>
                                    <span class="meta-value">{{ $content->id }}</span>
                                </li>
                                <li class="mt-2">
                                    <span class="meta-label">Последнее обновление:</span>
                                    <span class="meta-value">{{ $content->updated_at->format('d.m.Y H:i') }}</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>


    {{-- Блок управления видео --}}
    <div id="video-manager"
         class="container-fluid mb-4"
         data-content-id="{{ $content->id }}"
         data-store-url="{{ route('admin.videos.store') }}">

        <div class="editor-card shadow-sm p-4" style="background: #1a1a1a; border-radius: 15px;">
            <h5 class="card-subtitle mb-4 text-warning pirate-font">
                <i class="fas fa-video me-2"></i> Видеохроники (YouTube / Rutube)
            </h5>

            <div class="video-add-box p-3 border rounded mb-4" style="background: rgba(255,255,255,0.05); border-color: #444!important;">
                <div class="row g-3">
                    <div class="col-md-4">
                        <label class="admin-label">Название ролика</label>
                        <input type="text" id="new_video_title" class="admin-input" placeholder="Напр: Вид с палубы">
                    </div>
                    <div class="col-md-6">
                        <label class="admin-label">Ссылка или iframe код</label>
                        <input type="text" id="new_video_raw" class="admin-input" placeholder="Вставьте ссылку на YouTube, Rutube или <iframe>">
                    </div>
                    <div class="col-md-2 d-flex align-items-end">
                        <button type="button" id="btn-add-video" class="btn-admin-save w-100 py-2">
                            <i class="fas fa-plus-circle me-1"></i> Добавить
                        </button>
                    </div>
                </div>
            </div>

            <div id="video-list-wrapper" class="row g-4">
                @foreach($content->videos as $video)
                    @include('admin.parts.video_item', ['video' => $video])
                @endforeach
            </div>
        </div>
    </div>


    <div class="container my-4">
        <div class="card shadow-sm p-4 bg-light">
            <h5 class="card-title mb-3">Upload Images</h5>
            <form action="{{ route('admin.images.upload') }}" method="POST" enctype="multipart/form-data"
                  class="d-flex flex-column gap-3">
                @csrf
                <!-- Выбор файлов -->
                <div class="mb-2">
                    <input type="file" name="images[]" multiple class="form-control">
                </div>

                <!-- Скрытые поля -->
                <input type="hidden" name="category_id" value="{{ $category->id }}">
                <input type="hidden" name="content_id" value="{{ $content->id }}">

                <!-- Кнопка загрузки -->
                <button type="submit" class="btn btn-primary w-25 align-self-start">Upload</button>
            </form>
        </div>
    </div>
    @if(isset($images))
        <div class="container my-4">
            <div id="gallery" class="row row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 g-4">
                <input type="hidden" name="type_sort_images" value="content">
                @foreach($images as $image)
                    <div class="col image-item" data-id="{{ $image->id }}">
                        <div class="card shadow-sm h-100 bg-light">
                            <!-- Изображение -->
                            <img src="{{ $image->thumb }}" class="card-img-top" alt="{{ $image->alt }}"
                                 style="object-fit: cover; height: 150px;">

                            <div class="card-body d-flex flex-column">
                                <!-- Форма редактирования -->
                                <form class="image-update-form mb-3" method="POST"
                                      action="{{ route('admin.images.update', $image) }}">
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
                                    <form class="image-update-form" data-type="setMain" method="POST" action="{{ route('admin.images.setMain', $image) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success btn-sm" {{ $image->is_main ? 'disabled' : '' }}>
                                            Set Main
                                        </button>
                                    </form>

                                    <form class="image-update-form" data-type="delete" method="POST" action="{{ route('admin.images.delete', $image) }}">
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
