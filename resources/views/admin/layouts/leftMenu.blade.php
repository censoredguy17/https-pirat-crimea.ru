<!-- Кнопка для открытия меню на мобилках -->
<!-- Мобильная шапка на всю ширину (видна только до 768px) -->
<div class="d-md-none w-100 bg-dark border-bottom border-warning shadow-sm sticky-top">
    <div class="d-flex align-items-center justify-content-between p-3">
        <div class="d-flex align-items-center">
            <i class="fas fa-skull-crossbones text-warning me-2"></i>
            <span class="text-white fw-bold">PIRATE ADMIN</span>
        </div>

        <button class="btn btn-warning btn-sm" type="button" data-bs-toggle="offcanvas" data-bs-target="#adminSidebarMobile">
            <i class="fas fa-bars me-1"></i> Меню
        </button>
    </div>
</div>

<!-- Сайдбар для ПК (скрыт на мобилках d-none d-md-flex) -->
<div class="admin-sidebar d-none d-md-flex flex-column flex-shrink-0 p-3">
    @include('admin.layouts.sidebar-content') {{-- Вынесем контент в отдельный файл, чтобы не дублировать код --}}
</div>

<!-- Сайдбар для МОБИЛОК (выезжает слева) -->
<div class="offcanvas offcanvas-start bg-dark text-white d-md-none" tabindex="-1" id="adminSidebarMobile" aria-labelledby="adminSidebarMobileLabel">
    <div class="offcanvas-header">
        <h5 class="offcanvas-title text-warning" id="adminSidebarMobileLabel">
            <i class="fas fa-skull-crossbones me-2"></i>Админка
        </h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="offcanvas" aria-label="Close"></button>
    </div>
    <div class="offcanvas-body p-0">
        <div class="admin-sidebar-mobile p-3">
            @include('admin.layouts.sidebar-content')
        </div>
    </div>
</div>

