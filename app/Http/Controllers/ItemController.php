<?php

namespace App\Http\Controllers;

use App\Models\Item;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\StoreItemRequest;
use App\Http\Requests\UpdateItemRequest;
use App\Repositories\ItemRepository;
use Exception;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ItemController extends Controller
{
    protected $itemRepository;

    public function __construct(ItemRepository $itemRepository)
    {
        $this->itemRepository = $itemRepository;
    }

    /**
     * Display a listing of the items.
     */
    public function index(): JsonResponse
    {
        try {
            $items = $this->itemRepository->getAll();
            
            return response()->json([
                'success' => true,
                'data' => $items,
                'message' => 'Items retrieved successfully',
                'count' => $items->count()
            ], 200);

        } catch (Exception $e) {
            Log::error('Failed to retrieve items: ' . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve items',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Store a newly created item.
     */
    public function store(StoreItemRequest $request): JsonResponse
    {
        try {
            Log::info('Store method called', $request->validated());

            $item = $this->itemRepository->create($request->validated());

            Log::info('Item created successfully', ['item_id' => $item->id]);

            return response()->json([
                'success' => true,
                'data' => $item,
                'message' => 'Item created successfully'
            ], 201);

        } catch (Exception $e) {
            Log::error('Store method error: ' . $e->getMessage());
            Log::error('Stack trace: ' . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to create item',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Display the specified item.
     */
    public function show($id): JsonResponse
    {
        try {
            $item = $this->itemRepository->findOrFail($id);
            
            return response()->json([
                'success' => true,
                'data' => $item,
                'message' => 'Item retrieved successfully'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ], 404);
            
        } catch (Exception $e) {
            Log::error("Failed to retrieve item {$id}: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to retrieve item',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Update the specified item.
     */
    public function update(UpdateItemRequest $request, $id): JsonResponse
    {
        try {
            \Log::info("=== UPDATE METHOD STARTED ===");
            \Log::info("ID received: " . $id);
            \Log::info("Request data: ", $request->all());
            \Log::info("Validated data: ", $request->validated());

            // Проверим, существует ли элемент
            $existingItem = $this->itemRepository->findById($id);
            \Log::info("Existing item: ", $existingItem ? $existingItem->toArray() : ['not_found']);

            if (!$existingItem) {
                \Log::warning("Item not found for update: " . $id);
                return response()->json([
                    'success' => false,
                    'message' => 'Item not found'
                ], 404);
            }

            $item = $this->itemRepository->update($id, $request->validated());
            
            \Log::info("Item after update: ", $item->toArray());
            \Log::info("=== UPDATE METHOD COMPLETED ===");

            return response()->json([
                'success' => true,
                'data' => $item,
                'message' => 'Item updated successfully'
            ], 200);

        } catch (ModelNotFoundException $e) {
            \Log::error("Model not found: " . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ], 404);
            
        } catch (Exception $e) {
            \Log::error("Failed to update item {$id}: " . $e->getMessage());
            \Log::error("Stack trace: " . $e->getTraceAsString());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to update item',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Remove the specified item.
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->itemRepository->delete($id);
            
            Log::info("Item {$id} deleted successfully");

            return response()->json([
                'success' => true,
                'message' => 'Item deleted successfully'
            ], 200);

        } catch (ModelNotFoundException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Item not found'
            ], 404);
            
        } catch (Exception $e) {
            Log::error("Failed to delete item {$id}: " . $e->getMessage());
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to delete item',
                'error' => config('app.debug') ? $e->getMessage() : 'Internal server error'
            ], 500);
        }
    }

    /**
     * Test method for API connectivity
     */
    public function test(): JsonResponse
    {
        return response()->json([
            'success' => true,
            'message' => 'Test method is working!',
            'timestamp' => now()->toDateTimeString(),
            'data' => [
                'status' => 'OK',
                'version' => '1.0'
            ]
        ], 200);
    }
}