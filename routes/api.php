<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('register', [AuthController::class, 'register']);
Route::post('login', [AuthController::class, 'login']);
Route::get('setting/{key}', [\App\Http\Controllers\Api\SettingController::class, 'index']);
Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
    // Event
    Route::prefix('event')->group(function() {
        Route::get('/', [EventController::class, 'index']);
        Route::post('/attendance/{event:id}', [EventController::class, 'attendance']);
    });
    // Blog
    Route::prefix('news')->group(function() {
        Route::get('/', [NewsController::class, 'index']);
    });
});
