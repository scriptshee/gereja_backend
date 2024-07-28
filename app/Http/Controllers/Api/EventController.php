<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Attandance;
use App\Models\Event;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

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
                    'attendace_total' => $item->attendace->count(),
                    'is_user_attendace' => auth()->id() ?  $item->attendace->where('user_id', auth()->id())->first()?->is_present : false,
                    "created_at" =>  Carbon::parse($item->created_at)->format('d/m/Y'),
                    "updated_at" => Carbon::parse($item->updated_at)->format('d/m/Y')
                ])
        ]);
    }

    public function attendance(Request $request, Event $event): JsonResponse
    {
        DB::beginTransaction();
        try {
            $attandance = Attandance::create([
                'user_id' => auth()->user()->id,
                'event_id' => $event->id,
                'is_present' => $request->input('present'),
                'is_read' => 1,
                'read_time' => now(),
                'note' => $request->input('note')
            ]);
            DB::commit();

            return response()->json([
                'message' => 'success',
                'data' => $attandance
            ], 201);

        }catch (\Exception $th) {
            DB::rollBack();
            return response()->json([
                'message' => 'Eror',
                'data' => $th->getMessage()
            ], 500);
        }
    }
}
