<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use App\Http\Controllers\Api\NewsController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function() {
    Route::post('logout', [AuthController::class, 'logout']);
    // Event
    Route::prefix('event')->group(function() {
        Route::get('/', [EventController::class, 'index']);
    });
    // Blog
    Route::prefix('news')->group(function() {
        Route::get('/', [NewsController::class, 'index']);
    });
});