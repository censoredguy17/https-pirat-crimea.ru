<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\CategoryModel;
use App\Models\Admin\ContentModel;
use App\Models\Admin\ImageModel;
use App\Models\Admin\ImageModel as Image;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminController extends Controller
{

    public function index(): View
    {
        return \view('admin.index', $this->data);
    }

    public function categoryShow(int $id):View
    {
        $this->data['category'] = CategoryModel::where('id', $id)->first();
        $this->data['contents'] = ContentModel::where('category_id', $id)->with('mainImage')->get();
        return \view('admin.category', $this->data);
    }

    public function contentCreate(int $categoryId): View
    {
        $this->data['category'] = CategoryModel::where('id', $categoryId)->first();
        return \view('admin.contentCreate', $this->data);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'categoryId' => 'required',
            'listTitle' => 'required|string|max:255',
            'listDescription' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'textTop' => 'required|string',
            'textBottom' => 'required|string',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'metaTitle' => 'required|string|max:255',
            'metaDescription' => 'required|string|max:255',
        ]);

        $validated['is_published'] = $request->has('is_published') ? true : false;
        $validated['slug'] = Str::slug($validated['title']).'-'.rand(1,99999);
        $validated['category_id'] = $validated['categoryId'];

        ContentModel::create($validated);
        return redirect()->route('admin.category.show', ['id' => $validated['categoryId']])->with('success', 'Контент успешно создан!');
    }

    public function edit(int $contentId):View
    {
        $this->data['content'] = ContentModel::where('id', $contentId)->first();
        $this->data['category'] = CategoryModel::where('id', $this->data['content']->category_id)->first();
        $this->data['images'] = $this->data['content']->images;
        return \view('admin.contentEdit', $this->data);
    }

    public function update(Request $request, int $contentId):RedirectResponse
    {
        // 1. Находим запись
        $content = ContentModel::findOrFail($contentId);

        // 2. Валидируем входные данные
        $validated = $request->validate([
            'listTitle' => 'nullable|string|max:255',
            'listDescription' => 'nullable|string|max:255',
            'title' => 'required|string|max:255',
            'textTop' => 'nullable|string',
            'textBottom' => 'nullable|string',
            'is_published' => 'nullable|boolean',
            'published_at' => 'nullable|date',
            'metaTitle' => 'nullable|string|max:255',
            'metaDescription' => 'nullable|string|max:255',
        ]);

        $validated['is_published'] = $request->has('is_published') ? true : false;

        // 3. Генерируем уникальный slug на основе title
        $slug = Str::slug($validated['title']);
        $originalSlug = $slug;
        $counter = 1;

        while (ContentModel::where('slug', $slug)->where('id', '!=', $contentId)->exists()) {
            $slug = $originalSlug . '-' . $counter;
            $counter++;
        }
        $validated['slug'] = $slug;

        // 4. Обновляем запись
        $content->update($validated);

        // 5. Перенаправление или возврат ответа
        return redirect()->route('admin.category.show' , ['id' => $content['category_id']])->with('success', 'Контент успешно обновлён!');
    }

    public function destroy(int $contentId): RedirectResponse
    {
        $content = ContentModel::findOrFail($contentId);

        // Можно удалить все связанные изображения
//        $content->images()->each(function($image) {
//            // Удаляем файлы
//            if(file_exists($image->original_path)) unlink($image->original_path);
//            if(file_exists($image->thumb_path)) unlink($image->thumb_path);
//            $image->delete();
//        });


        // Путь к папке контента
        $folderPath = public_path("storage/images/category_{$content->category_id}/content{$content->id}");

        // Удаляем всю папку со всеми вложениями
        if (File::exists($folderPath)) {
            File::deleteDirectory($folderPath);
        }

        // Удаляем все записи в таблице images, которые относились к этому контенту
        ImageModel::where('content_id', $content->id)->delete();

        // Удаляем сам контент
        $content->delete();
        return redirect()->route('admin.category.show' , ['id' => $content['category_id']])->with('success', 'Контент успешно удален!');
    }
}
