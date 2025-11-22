<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::apiResource('items', ItemController::class);

// Простой тестовый маршрут
/*Route::get('/test', function () {
    return response()->json([
        'message' => 'API is working!',
        'timestamp' => now()->toDateTimeString(),
        'status' => 'success'
    ]);
});*/

// Альтернативный тестовый маршрут с контроллером
Route::get('/test2', function () {
    return [
        'status' => 'OK',
        'data' => 'Test endpoint works'
    ];
});

// Добавьте этот маршрут
Route::get('/test', function () {
    return response()->json([
        'message' => 'Test route is working!',
        'timestamp' => now()
    ]);
});