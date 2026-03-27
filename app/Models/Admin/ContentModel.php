<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentModel extends Model
{
    use HasFactory, SoftDeletes;

    public $table = 'contents';

    protected $fillable = [
        'listTitle',
        'listDescription',
        'slug',
        'title',
        'textTop',
        'textBottom',
        'is_published',
        'published_at',
        'metaTitle',
        'metaDescription',
        'category_id'
    ];

    protected $casts = [
        'is_published' => 'boolean',
        'published_at' => 'datetime'
    ];

    public function category()
    {
        return $this->belongsTo(CategoryModel::class, 'category_id');
    }

    public function images()
    {
        return $this->hasMany(ImageModel::class, 'content_id')->orderBy('sort_order');
    }

    public function videos()
    {
        return $this->hasMany(ContentVideo::class, 'content_id')
            ->orderBy('sort_order');
    }

    public function mainImage()
    {
        return $this->hasOne(ImageModel::class, 'content_id')->orderByDesc('is_main')->orderBy('id');
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
