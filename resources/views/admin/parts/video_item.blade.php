<div class="col-md-6 video-item-card"
     data-id="{{ $video->id }}"
     data-update-url="{{ route('admin.videos.update', $video->id) }}"
     data-delete-url="{{ route('admin.videos.destroy', $video->id) }}">

    <div class="p-3 border rounded h-100 bg-dark-soft shadow-sm {{ $video->is_published ? '' : 'border-danger' }}"
         style="background: #252525; transition: 0.3s; opacity: {{ $video->is_published ? '1' : '0.6' }};">

        <div class="video-preview mb-3" style="background: #000; border-radius: 8px; overflow: hidden; border: 1px solid #555;">
            <div class="ratio ratio-16x9">
                <iframe src="{{ $video->iframe }}" frameborder="0" allowfullscreen></iframe>
            </div>
        </div>

        <div class="d-flex justify-content-between align-items-center mb-2">
            <div class="form-check form-switch custom-switch">
                <input class="form-check-input video-edit-active" type="checkbox"
                       id="activeVideo{{ $video->id }}" {{ $video->is_published ? 'checked' : '' }}>
                <label class="form-check-label text-white small" for="activeVideo{{ $video->id }}">Опубликовано</label>
            </div>
            <button type="button" class="btn-delete-video text-danger border-0 bg-transparent p-0" title="Удалить">
                <i class="fas fa-trash-alt"></i>
            </button>
        </div>

        <div class="row g-2 mb-2">
            <div class="col-9">
                <label class="admin-label small text-warning">Название</label>
                <input type="text" class="video-edit-title admin-input admin-input-sm" value="{{ $video->title }}">
            </div>
            <div class="col-3">
                <label class="admin-label small text-warning">Сорт.</label>
                <input type="number" class="video-edit-order admin-input admin-input-sm" value="{{ $video->sort_order }}">
            </div>
        </div>

        <div class="mb-3">
            <label class="admin-label small text-warning">Embed URL (ссылка для плеера)</label>
            <input type="text" class="video-edit-iframe admin-input admin-input-sm" value="{{ $video->iframe }}">
        </div>

        <button type="button" class="btn btn-sm btn-primary w-100 btn-update-video">
            <i class="fas fa-save me-1"></i> Сохранить изменения
        </button>
    </div>
</div>
