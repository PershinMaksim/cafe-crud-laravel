<?php

use App\Http\Controllers\DishController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/test', function () {
    return response()->json([
        'status' => 'success',
        'message' => 'API is working!',
        'timestamp' => now()
    ]);
});
Route::get('/fix-categories', function() {
    \App\Models\Dish::where('category', '0')->orWhere('category', '')->update(['category' => 'Основные блюда']);
    return response()->json(['message' => 'Categories fixed']);
});

Route::apiResource('dishes', DishController::class);

// CRUD для блюд
Route::get('/dishes', [DishController::class, 'index']);
Route::post('/dishes', [DishController::class, 'store']);
Route::put('/dishes/{id}', [DishController::class, 'update']);
Route::delete('/dishes/{id}', [DishController::class, 'destroy']);