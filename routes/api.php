<?php

use App\Http\Controllers\Api\AttendeeController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\EventController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('/login', [AuthController::class, 'login'])->middleware('throttle:5,1');
Route::post('/logout', [AuthController::class, 'logout'])->middleware('auth:sanctum');


Route::apiResource('events', EventController::class)
    ->only(['index', 'show']);

Route::apiResource('events', EventController::class)
    ->only(['store', 'update', 'destroy'])
    ->middleware(['auth:sanctum', 'throttle:30,1']);

// Public
Route::apiResource('events.attendees', AttendeeController::class)
    ->scoped()
    ->only(['index', 'show']);

// Protected
Route::apiResource('events.attendees', AttendeeController::class)
    ->scoped()
    ->only([ 'store','destroy'])
    ->middleware(['auth:sanctum', 'throttle:30,1']);
