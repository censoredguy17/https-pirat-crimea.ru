<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ImageModel as Image;
use App\Services\ImageService;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::orderBy('sort_order')->get();
        return view('admin.images.index', compact('images'));
    }

    public function upload(Request $request, ImageService $service)
    {
        $request->validate([
            'images.*' => 'required|image|max:10240' // макс 10MB
        ]);

        $service->uploadMultiple($request);

        return back();
    }

    public function delete(Image $image, ImageService $service)
    {
        $service->delete($image);
        return response()->json(['success' => true,'message' => 'Фото удалено!']);
//        return back();
    }

    public function setMain(Image $image, ImageService $service)
    {
        $service->setMain($image);
        return response()->json(['success' => true, 'message' => 'Главное фото изменено!']);
//        return back();
    }

    public function update(Request $request, Image $image, ImageService $service)
    {
        $request['is_active'] = $request->has('is_active') ? true : false;
        $service->updateMeta($image, $request->only(['alt','description','is_active']));
        return response()->json([
            'success' => true,
            'message'=> 'Информация о фото сохранена!'
        ]);
//        return back();
    }

    public function sort(Request $request, ImageService $service)
    {
        $service->sort($request->ids);
        return response()->json(['status' => 'ok']);
    }
}
