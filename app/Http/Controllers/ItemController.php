<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreItemRequest;
use Exception;

class ItemController extends Controller
{
    public function test()
    {
        return response()->json([
            'message' => 'Test method is working!',
            'timestamp' => now()
        ]);
    }

    public function index()
    {
        return response()->json([
            'test' => true,
            'message' => 'Controller is working',
            'data' => []
        ]);
    }

    public function show($id)
    {
        // Простой тест
        return response()->json([
            'test' => true,
            'id_received' => $id,
            'message' => 'Show method working'
        ]);
    }

    public function store(StoreItemRequest $request): JsonResponse
    {
        try {
            \Log::info('Store method called', $request->all());
            
            // Простая валидация вручную для тестирования
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'is_active' => 'sometimes|boolean'
            ]);

            \Log::info('Validation passed', $validated);

            // Простой ответ без репозитория
            return response()->json([
                'success' => true,
                'data' => array_merge($validated, ['id' => rand(100, 999)]),
                'message' => 'Item created successfully (test)'
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            \Log::error('Validation failed', $e->errors());
            return response()->json([
                'success' => false,
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (Exception $e) {
            \Log::error('Store method error: ' . $e->getMessage());
            \Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create item',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
    /*
    public function index(): JsonResponse
    {
        try {
            $items = Item::all();
            
            return response()->json([
                'success' => true,
                'data' => $items,
                'message' => 'Items retrieved successfully',
                'count' => $items->count()
            ]);
        } catch (\Exception $e) {
            Log::error('Failed to retrieve items: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve items',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
    
    public function store(Request $request): JsonResponse
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'price' => 'required|numeric|min:0',
                'quantity' => 'required|integer|min:0',
                'is_active' => 'sometimes|boolean'
            ]);

            $item = Item::create($validated);
            
            return response()->json([
                'success' => true,
                'data' => $item,
                'message' => 'Item created successfully'
            ], 201);
        } catch (\Exception $e) {
            Log::error('Failed to create item: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create item',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
    
    public function show(string $id): JsonResponse
    {
        try {
            $item = Item::find($id);
            
            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found'
                ], 404);
            }
            
            return response()->json([
                'success' => true,
                'data' => $item,
                'message' => 'Item retrieved successfully'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to retrieve item {$id}: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve item',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
    
    public function update(Request $request, string $id): JsonResponse
    {
        try {
            $item = Item::find($id);
            
            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found'
                ], 404);
            }

            $validated = $request->validate([
                'name' => 'sometimes|string|max:255',
                'description' => 'nullable|string',
                'price' => 'sometimes|numeric|min:0',
                'quantity' => 'sometimes|integer|min:0',
                'is_active' => 'sometimes|boolean'
            ]);

            $item->update($validated);
            
            return response()->json([
                'success' => true,
                'data' => $item,
                'message' => 'Item updated successfully'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to update item {$id}: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update item',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }
    
    public function destroy(string $id): JsonResponse
    {
        try {
            $item = Item::find($id);
            
            if (!$item) {
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found'
                ], 404);
            }

            $item->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Item deleted successfully'
            ]);
        } catch (\Exception $e) {
            Log::error("Failed to delete item {$id}: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete item',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }*/
}