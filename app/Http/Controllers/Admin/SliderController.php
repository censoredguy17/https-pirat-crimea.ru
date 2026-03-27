<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\SliderImageModel as Image;
use App\Models\Admin\SliderModel;
use App\Services\SliderService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\Admin\SliderModel as Slider;
use Illuminate\Support\Facades\File;
use Illuminate\View\View;

class SliderController extends Controller
{
    public function index()
    {
        $this->data['sliders'] = Slider::orderBy('id','DESC')->with('mainImage')->get();
        return view('admin.sliders.index', $this->data);
    }

    public function editSlider(int $sliderId):View
    {
        $this->data['slider'] = Slider::findOrFail($sliderId);
        $this->data['images'] = $this->data['slider']->images;
        return view('admin.sliders.edit', $this->data);
    }

    public function createSlider(): View
    {
        return \view('admin.sliders.create', $this->data);
    }

    public function storeSlider(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'admin_name' => 'required|string|max:255',
            'admin_comment' => 'required|string',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        SliderModel::create($validated);
        return redirect()->route('admin.sliders.index')->with('success', 'Слайдер успешно создан!');
    }

    public function updateSlider(Request $request, int $sliderId):RedirectResponse
    {
        $content = SliderModel::findOrFail($sliderId);

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'admin_name' => 'required|string|max:255',
            'admin_comment' => 'required|string',
            'is_active' => 'nullable|boolean'
        ]);

        $validated['is_active'] = $request->has('is_active') ? true : false;
        $content->update($validated);

        return redirect()->route('admin.sliders.index')->with('success', 'Cлайдер успешно обновлён!');
    }

    public function destroySlider(int $sliderId): RedirectResponse
    {
        $slider = SliderModel::findOrFail($sliderId);
        $folderPath = public_path("storage/sliders/slider_{$slider->id}");

        if (File::exists($folderPath)) {
            File::deleteDirectory($folderPath);
        }

        Image::where('slider_id', $slider->id)->delete();

        // Удаляем сам контент
        $slider->delete();
        return redirect()->route('admin.sliders.index')->with('success', 'Слайдер успешно удален!');
    }

    public function uploadSliderImages(Request $request, SliderService $service)
    {
        $request->validate([
            'images.*' => 'required|image|max:10240' // макс 10MB
        ]);

        $service->uploadMultiple($request);

        return back();
    }

    public function deleteSliderImage(Image $image, SliderService $service)
    {
        $service->delete($image);
        return response()->json(['success' => true,'message' => 'Фото удалено!']);
//        return back();
    }

    public function setMainSliderImage(Image $image, SliderService $service)
    {
        $service->setMain($image);
        return response()->json(['success' => true, 'message' => 'Главное фото изменено!']);
//        return back();
    }

    public function updateSliderImage(Request $request, Image $image, SliderService $service)
    {
        $request['is_active'] = $request->has('is_active') ? true : false;
        $service->updateMeta($image, $request->only(['alt','description','is_active']));
        return response()->json([
            'success' => true,
            'message'=> 'Информация о фото сохранена!'
        ]);
//        return back();
    }

    public function sortSliderImage(Request $request, SliderService $service)
    {
        $service->sort($request->ids);
        return response()->json(['status' => 'ok']);
    }

}
