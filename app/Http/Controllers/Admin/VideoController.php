<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Admin\ContentVideo;
use Illuminate\Http\Request;

class VideoController extends Controller
{
    public function store(Request $request)
    {
        $video = ContentVideo::create($request->all());

        // Возвращаем отрендеренный кусочек HTML
        $html = view('admin.parts.video_item', compact('video'))->render();

        return response()->json(['html' => $html]);
    }

    public function update(Request $request, ContentVideo $video)
    {
        $video->update($request->only([
            'title',
            'iframe',      // Поле добавлено
            'sort_order',
            'is_published'
        ]));

        return response()->json(['success' => true]);
    }

    public function destroy(ContentVideo $video)
    {
        $video->delete();
        return response()->json(['success' => true]);
    }
}
