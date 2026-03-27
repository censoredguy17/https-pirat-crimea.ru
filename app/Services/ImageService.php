<?php
namespace App\Services;

use App\Models\Admin\ImageModel as Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Spatie\Image\Image as SpatieImage;

class ImageService
{
    public function uploadMultiple(Request $request): void
    {
        $files = $request->file('images');
        $categoryId = $request->input('category_id');
        $contentId = $request->input('content_id');

        foreach ($files as $file) {

            $name = Str::uuid() . '.' . $file->getClientOriginalExtension();

            // Папка для оригинала
            $basePath = storage_path("app/public/images/category_{$categoryId}/content{$contentId}");

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
            Image::create(['category_id' => $categoryId, 'content_id' => $contentId,'file' => $name]);
        }
    }

    public function delete(Image $image): void
    {
        $original = "images/category_{$image->category_id}/content{$image->content_id}/original/".$image->file;
        $thumb = "images/category_{$image->category_id}/content{$image->content_id}/thumbs/".$image->file;

        Storage::disk('public')->delete($original);
        Storage::disk('public')->delete($thumb);

        $image->delete();
    }

    public function setMain(Image $image): void
    {
        Image::where('content_id', $image->content_id)
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
