<?php

namespace App\Models\Admin;

use App\Models\Admin\ContentModel;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ContentVideo extends Model
{
    use SoftDeletes;

    public $table = 'videos';

    protected $fillable = [
        'content_id',
        'title',
        'iframe',
        'is_published',
        'sort_order',
        'published_at'
    ];

    protected $casts = [
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    // Обратная связь с контентом
    public function content()
    {
        return $this->belongsTo(ContentModel::class, 'content_id');
    }
}
