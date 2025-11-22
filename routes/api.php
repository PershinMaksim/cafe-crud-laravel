<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ItemController;

Route::apiResource('items', ItemController::class);

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

Route::put('/items/{id}', [ItemController::class, 'update']);
Route::patch('/items/{id}', [ItemController::class, 'update']);