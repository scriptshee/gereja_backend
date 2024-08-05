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
        $attendace = Attandance::with('event')
            ->where('user_id', auth()->id())
            ->where('is_present', true)
            ->latest()
            ->get()
            ->transform(fn($item) => [
                'id' => $item->id,
                'event_id' => $item->event->id,
                'event' => $item->event,
                'event_start' => \Carbon\Carbon::parse($item->event->start_datetime)->format('d-m-Y H:i'),
                'end_datetime' => \Carbon\Carbon::parse($item->event->end_datetime)->format('d-m-Y H:i'),
            ]);
        return response()->json([
            'message' => 'success',
            'data' => $attendace
        ]);
    }
}
