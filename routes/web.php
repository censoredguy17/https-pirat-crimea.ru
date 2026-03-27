<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\AuthController;
use App\Http\Controllers\Admin\ImageController;
use App\Http\Controllers\Admin\SliderController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\MainController;
use Illuminate\Support\Facades\Route;

// 1. Маршруты входа (открыты для всех)
Route::get('/admin/login', [AuthController::class, 'showLogin'])->name('admin.login');
Route::post('/admin/login', [AuthController::class, 'login']);
Route::get('/admin/logout', [AuthController::class, 'logout'])->name('admin.logout');

// 2. ЗАЩИЩЕННАЯ ЗОНА
Route::middleware(['admin.auth'])->prefix('admin')->group(function () {

    // Главная страница админки
    Route::get('/', [App\Http\Controllers\Admin\AdminController::class, 'index'])->name('admin.index');

    // Твои ресурсы (категории, контент и т.д.)
    // Route::resource('categories', ...);
    // Route::resource('contents', ...);

});

Route::prefix('admin')->as('admin.')->group(function () {

    Route::get('/', [AdminController::class, 'index'])->name('index');

    Route::prefix('category')->as('category.')->group(function () {
        Route::get('{id}', [AdminController::class, 'categoryShow'])->name('show');
    });

    Route::prefix('content')->as('content.')->group(function () {
        Route::get('/create/{categoryId}', [AdminController::class, 'contentCreate'])->name('create');
        Route::post('/store', [AdminController::class, 'store'])->name('store');
        Route::get('{contentId}/edit', [AdminController::class, 'edit'])->name('edit');
        Route::patch('/{contentId}', [AdminController::class, 'update'])->name('update');
        Route::delete('/{content}', [AdminController::class, 'destroy'])->name('delete');
    });

    Route::prefix('images')->as('images.')->group(function () {
        Route::post('/upload', [ImageController::class, 'upload'])->name('upload');
        Route::delete('/{image}', [ImageController::class, 'delete'])->name('delete');
        Route::post('/sort', [ImageController::class, 'sort'])->name('sort');
        Route::post('/{image}/main', [ImageController::class, 'setMain'])->name('setMain');
        Route::patch('/{image}/update', [ImageController::class, 'update'])->name('update');
    });

    Route::prefix('videos')->as('videos.')->group(function () {
        Route::post('videos', [VideoController::class, 'store'])->name('store');
        Route::patch('videos/{video}', [VideoController::class, 'update'])->name('update');
        Route::delete('videos/{video}', [VideoController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('sliders')->as('sliders.')->group(function () {
        Route::get('/show', [SliderController::class, 'index'])->name('index');
        Route::get('/create', [SliderController::class, 'createSlider'])->name('create');
        Route::post('/store', [SliderController::class, 'storeSlider'])->name('store');
        Route::get('{sliderId}/edit', [SliderController::class, 'editSlider'])->name('edit');
        Route::patch('/{sliderId}', [SliderController::class, 'updateSlider'])->name('update');
        Route::delete('/{sliderId}', [SliderController::class, 'destroySlider'])->name('destroy');

        Route::prefix('images')->as('images.')->group(function () {
            Route::post('/upload', [SliderController::class, 'uploadSliderImages'])->name('upload');
            Route::delete('/{image}', [SliderController::class, 'deleteSliderImage'])->name('delete');
            Route::post('/sort', [SliderController::class, 'sortSliderImage'])->name('sort');
            Route::post('/{image}/main', [SliderController::class, 'setMainSliderImage'])->name('setMain');
            Route::patch('/{image}/update', [SliderController::class, 'updateSliderImage'])->name('update');
        });

    });


});


Route::get('/', [MainController::class, 'index'])->name('index');
Route::get('/contacts', [MainController::class, 'contacts'])->name('contacts');
Route::get('/category/{slug}', [MainController::class, 'category'])->name('category');
Route::get('/gallery', [MainController::class, 'gallery'])->name('gallery');
Route::get('/content/{slug}', [MainController::class, 'content'])->name('content');
