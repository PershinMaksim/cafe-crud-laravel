<?php
require_once __DIR__ . '/../bootstrap/app.php';

use App\Repositories\ItemRepository;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Http\Kernel::class)->handle(Request::capture());

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        
        $itemRepository = $app->make(ItemRepository::class);
        $itemRepository->delete($id);

        $result = json_encode([
            'success' => true,
            'message' => 'Item deleted successfully'
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        header("Location: crud.php?delete_result=" . urlencode($result) . "&delete_success=1&tab=delete");
        exit;
    }
} catch (Exception $e) {
    $result = json_encode([
        'success' => false,
        'message' => 'Failed to delete item: ' . $e->getMessage()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
    header("Location: crud.php?delete_result=" . urlencode($result) . "&delete_success=0&tab=delete");
    exit;
}