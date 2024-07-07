<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Blog;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(): JsonResponse
    {
        $blog = Blog::query()->whereNotNull('published_date')->get()
            ->transform(fn ($item) => [
                "id" => $item->id,
                "thumbnail" => sprintf('%s/storage/%s', env('APP_URL'), $item->thumbnail),
                'title' => $item->title,
                'content' => $item->content,
                'user' => [
                    'id' => $item->user->id,
                    'name' => $item->user->name,
                ],
                'published_date' => $item->published_date,
            ]);
        return response()->json([
            'message' => 'success',
            'data' => $blog
        ]);
    }
}
