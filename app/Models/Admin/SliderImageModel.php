<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SliderImageModel extends Model
{
    public $table = 'slider_images';

    protected $fillable = [
        'file',
        'alt',
        'description',
        'is_active',
        'is_main',
        'sort_order',
        'slider_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_main' => 'boolean',
    ];

    public function getOriginalAttribute()
    {
        $originalPath = "storage/sliders/slider_{$this->slider_id}/original/";
        return asset($originalPath.$this->file);
    }

    public function getThumbAttribute()
    {
        $thumbPath = "storage/sliders/slider_{$this->slider_id}/thumbs/";
        return asset($thumbPath.$this->file);
    }

    public function getOriginalPathAttribute()
    {
        return public_path("storage/sliders/slider_{$this->slider_id}/original/".$this->file);
    }

    // Путь к миниатюре на диске (для unlink)
    public function getThumbPathAttribute()
    {
        return public_path("storage/sliders/slider_{$this->slider_id}/thumbs/".$this->file);
    }
}
