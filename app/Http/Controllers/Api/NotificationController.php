<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index() : JsonResponse
    {
        return response()->json([
            'message' => 'success',
            'data' => Notification::query()
                        ->take(10)
                        ->get()
        ]);
    }
}
