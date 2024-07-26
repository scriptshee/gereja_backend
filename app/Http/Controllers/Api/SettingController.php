<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index($key): \Illuminate\Http\JsonResponse
    {
        $setting = Setting::query()->where('key' , 'LIKE', $key.'%')->first();

        return response()->json([
            'message' => 'success',
            'data' => $setting->value
        ]);
    }
}
