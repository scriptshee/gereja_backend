<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'success',
            'data' => Notification::query()
                ->take(10)
                ->get()
                ->transform(fn($item) => [
                    "id" => $item->id,
                    "title" => $item->title,
                    "context" => $item->context,
                    "is_pin" => $item->is_pin,
                    "created_at" => $item->created_at->format('d-m-Y'),
                ])
        ]);
    }
}
