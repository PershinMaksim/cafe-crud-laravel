<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use Illuminate\Http\Request;

class DishController extends Controller
{
    // Получить все блюда
    public function index()
    {
        return response()->json(Dish::all());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            // Добавьте остальные поля если нужно
            'quantity' => 'nullable|integer|min:0',
        ]);

        // Установите значения по умолчанию для отсутствующих полей
        $dishData = array_merge([
            'quantity' => 0,
            'is_active' => true,
        ], $validated);

        $dish = Dish::create($dishData);
        
        return response()->json($dish, 201);
    }

    public function update(Request $request, $id)
    {
        $dish = Dish::findOrFail($id);
        
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'category' => 'required|string|max:255',
            'quantity' => 'nullable|integer|min:0',
        ]);

        $dish->update($validated);
        
        return response()->json($dish);
    }

    public function destroy($id)
    {
        try {
            $dish = Dish::findOrFail($id);
            $dish->delete();
            
            return response()->json([
                'message' => 'Блюдо успешно удалено'
            ], 200);
            
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Ошибка при удалении блюда',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}