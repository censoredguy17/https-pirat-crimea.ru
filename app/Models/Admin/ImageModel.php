<?php
namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Model;

class ImageModel extends Model
{
    public $table = 'images';

    protected $fillable = [
        'file',
        'alt',
        'description',
        'is_active',
        'is_main',
        'sort_order',
        'category_id',
        'content_id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'is_main' => 'boolean',
    ];

    public function getOriginalAttribute()
    {
        $originalPath = "storage/images/category_{$this->category_id}/content{$this->content_id}/original/";
        return asset($originalPath.$this->file);
    }

    public function getThumbAttribute()
    {
        $thumbPath = "storage/images/category_{$this->category_id}/content{$this->content_id}/thumbs/";
        return asset($thumbPath.$this->file);
    }

}
