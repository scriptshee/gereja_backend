<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Carousel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class CarouselController extends Controller
{
    public function index() : JsonResponse
    {
        $carousel = Carousel::query()
            ->where('active', true)
            ->get()
            ->transform(fn($item) => [
                'id' => $item->id,
                'image' => sprintf('%s/storage/%s', env('APP_URL'), $item->image)
            ]);
        return response()->json([
            'success' => true,
            'data' => $carousel
        ], 200);
    }
}
