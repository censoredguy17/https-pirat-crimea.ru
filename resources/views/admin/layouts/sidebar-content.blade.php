<div class="sidebar-header d-flex align-items-center mb-3">
    <i class="fas fa-skull-crossbones me-2 text-warning"></i>
    <span class="fs-4 fw-bold pirate-sidebar-title text-white">Админка</span>
</div>

<ul class="nav nav-pills flex-column mb-auto custom-scrollbar">
    <li class="nav-label text-uppercase mb-2 small">Навигация</li>
    <li class="nav-item mb-2">
        <a href="{{ route('admin.sliders.index') }}"
           class="nav-link {{ request()->routeIs('admin.sliders.*') ? 'active' : '' }} text-white">
            <i class="fas fa-images me-2"></i> Слайдеры
        </a>
    </li>

    @if($categoriesContent)
        <li class="nav-label text-uppercase mt-4 mb-2 small">Категории</li>
        @foreach($categoriesContent as $categoryContent)
            <li class="nav-item mb-1">
                <a href="{{ route('admin.category.show', $categoryContent->id) }}"
                   class="nav-link {{ request()->fullUrlIs(route('admin.category.show', $categoryContent->id)) ? 'active' : '' }} text-white">
                    <i class="fas fa-folder-open me-2"></i> {{ $categoryContent->name }}
                </a>
            </li>
        @endforeach
    @endif
</ul>
<hr class="sidebar-divider">
<div class="sidebar-footer">
    <a href="/" class="nav-link text-muted small">
        <i class="fas fa-external-link-alt me-2"></i> На сайт
    </a>
</div>
