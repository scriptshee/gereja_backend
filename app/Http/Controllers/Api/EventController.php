<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class EventController extends Controller
{
    public function index(): JsonResponse
    {
        return response()->json([
            'message' => 'success',
            'data' => Event::query()->get()
                ->transform(fn ($item) => [
                    "id" =>  $item->id,
                    "thumbnail" =>  sprintf("%s/storage/%s",env('APP_URL'), $item->thumbnail),
                    "title" =>  $item->title,
                    "description" =>  $item->description,
                    "content" =>  $item->content,
                    "start_datetime" =>  Carbon::parse($item->start_datetime)->format('d/m/Y'),
                    "end_datetime" =>  Carbon::parse($item->end_datetime)->format('d/m/Y'),
                    "is_endedtime" =>  $item->is_endedtime,
                    "user" =>  value( fn($user) => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                    ], $item->user),
                    "created_at" =>  Carbon::parse($item->created_at)->format('d/m/Y'),
                    "updated_at" => Carbon::parse($item->updated_at)->format('d/m/Y')
                ])
        ]);
    }
}
