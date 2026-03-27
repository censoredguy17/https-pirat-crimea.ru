<?php
namespace App\Services;

use App\Models\Admin\SliderImageModel as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image as SpatieImage;

class SliderService
{
    public function uploadMultiple(Request $request): void
    {
        $files = $request->file('images');
        $sliderId = $request->input('slider_id');

        foreach ($files as $file) {

            $name = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Папка для оригинала
            $basePath = storage_path("app/public/sliders/slider_{$sliderId}");

            $originalDir = $basePath . '/original/';
            $thumbDir = $basePath . '/thumbs/';

            // создаём папки если их нет
            File::ensureDirectoryExists($originalDir);
            File::ensureDirectoryExists($thumbDir);

            $originalPath = $originalDir . $name;
            $thumbPath = $thumbDir . $name;

            // Сохраняем оригинал
            $file->move($originalDir, $name);

            // Создаём ресайз 1600px (ширина или высота)
            $image = SpatieImage::load($originalPath);

            if ($image->getWidth() > $image->getHeight()) {
                $image->width(1600);
            } else {
                $image->height(1600);
            }

            $image->save($originalPath);

            // Создаём миниатюру 300px
            $thumb = SpatieImage::load($originalPath);

            if ($thumb->getWidth() > $thumb->getHeight()) {
                $thumb->width(300);
            } else {
                $thumb->height(300);
            }

            $thumb->save($thumbPath);

            // Сохраняем запись в базе
            Image::create(['slider_id' => $sliderId, 'file' => $name]);
        }
    }

    public function delete(Image $image): void
    {
        $originalPath = "sliders/slider_{$image->slider_id}/original/".$image->file;
        $thumbPath = "sliders/slider_{$image->slider_id}/thumbs/".$image->file;

        Storage::disk('public')->delete($originalPath);
        Storage::disk('public')->delete($thumbPath);

        $image->delete();
    }

    public function setMain(Image $image): void
    {
        Image::where('slider_id', $image->slider_id)
            ->update(['is_main' => false]);

        $image->update(['is_main' => true]);
    }

    public function updateMeta(Image $image, array $data): void
    {
        $image->update($data);
    }

    public function sort(array $ids): void
    {
        foreach ($ids as $index => $id) {
            Image::where('id', $id)->update(['sort_order' => $index]);
        }
    }
}
