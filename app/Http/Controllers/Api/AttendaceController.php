<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attandance;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AttendaceController extends Controller
{
    public function index(): JsonResponse
    {
        $attendace = Attandance::query()
            ->where('user_id', auth()->id())
            ->where('is_present', true)
            ->whereHas('event' , function ($query){
                return $query->whereNotNull('id');
            })
            ->latest()
            ->get()
            ->transform(function ($item) {
                return [
                    'id' => $item->id,
                    'event_id' => $item->event_id,
                    'event' => [
                        "id" => $item->event->id,
                        "thumbnail" => sprintf("%s/storage/%s", env('APP_URL'), $item->event->thumbnail),
                        "title" => $item->event->title,
                        "description" => $item->event->description,
                        "content" => $item->event->content,
                        "start_datetime" => Carbon::parse($item->event->start_datetime)->format('d/m/Y'),
                        "end_datetime" => Carbon::parse($item->event->end_datetime)->format('d/m/Y'),
                        "is_endedtime" => $item->event->is_endedtime,
                        "user" => value(fn($user) => [
                            'id' => $user->id,
                            'name' => $user->name,
                            'email' => $user->email,
                        ], $item->event->user),
                        'attendace_total' => $item->event->attendace->count(),
                        'is_user_attendace' => auth()->id() ? $item->event->attendace->where('user_id', auth()->id())->first()?->is_present : false,
                        "created_at" => Carbon::parse($item->event->created_at)->format('d/m/Y'),
                        "updated_at" => Carbon::parse($item->event->updated_at)->format('d/m/Y')
                    ],
                    'event_start' => \Carbon\Carbon::parse($item->event->start_datetime)->format('d-m-Y H:i'),
                    'end_datetime' => \Carbon\Carbon::parse($item->event->end_datetime)->format('d-m-Y H:i'),
                ];
            });
        return response()->json([
            'message' => 'success',
            'data' => $attendace
        ]);
    }
}
