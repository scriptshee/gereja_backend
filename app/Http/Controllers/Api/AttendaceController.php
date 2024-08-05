<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attandance;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendaceController extends Controller
{
    public function index() : JsonResponse
    {
        $attendace = Attandance::query()->where('user_id', auth()->id())
            ->latest()
            ->get();
        return response()->json([
            'message' => 'success',
            'data' => $attendace
        ]);
    }
}
