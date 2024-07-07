<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index() : JsonResponse 
    {
        return response()->json([
            'message' => 'success',
            'data' => Event::query()->get() 
        ]);
    }
}
