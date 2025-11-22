<?php
require_once __DIR__ . '/../bootstrap/app.php';

use Illuminate\Http\Request;
use App\Repositories\ItemRepository;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Http\Kernel::class)->handle(Request::capture());

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $request = Request::capture();
        
        $id = $request->input('id');
        
        // Валидация данных
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'is_active' => 'sometimes|string|in:true,false'
        ]);

        // Преобразование данных
        $data = $validated;
        if (isset($data['is_active'])) {
            $data['is_active'] = $data['is_active'] === 'true';
        }

        // Обновление элемента
        $itemRepository = $app->make(ItemRepository::class);
        $item = $itemRepository->update($id, $data);

        $result = json_encode([
            'success' => true,
            'data' => $item,
            'message' => 'Item updated successfully'
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        header("Location: crud.php?update_result=" . urlencode($result) . "&update_success=1&tab=update");
        exit;
    }
} catch (Exception $e) {
    $result = json_encode([
        'success' => false,
        'message' => 'Failed to update item: ' . $e->getMessage()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
    header("Location: crud.php?update_result=" . urlencode($result) . "&update_success=0&tab=update");
    exit;
}