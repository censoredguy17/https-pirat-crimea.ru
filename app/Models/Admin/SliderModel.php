<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class SliderModel extends Model
{
    public $table = 'slider_types';

    protected $fillable = [
        'title',
        'description',
        'is_active',
        'admin_name',
        'admin_comment'
    ];

    protected $casts = [
        'is_active' => 'boolean'
    ];

    public function images()
    {
        return $this->hasMany(SliderImageModel::class, 'slider_id')->orderBy('sort_order');
    }

    public function mainImage()
    {
        return $this->hasOne(SliderImageModel::class, 'slider_id')->orderByDesc('is_main')->orderBy('id');
    }

    public function getMainThumbAttribute()
    {
        return $this->mainImage?->thumb ?? asset('storage/images/no-image.jpg');
    }

    public function getMainOriginalAttribute()
    {
        return $this->mainImage?->original ?? asset('storage/images/no-image.jpg');
    }

}
