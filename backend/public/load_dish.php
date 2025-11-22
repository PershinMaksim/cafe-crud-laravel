<?php
require_once __DIR__ . '/../bootstrap/app.php';

use App\Repositories\DishRepository;

$app = require_once __DIR__ . '/../bootstrap/app.php';
$app->make(Illuminate\Contracts\Http\Kernel::class)->handle(Request::capture());

try {
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $id = $_POST['id'];
        
        $dishRepository = $app->make(DishRepository::class);
        $dish = $dishRepository->findOrFail($id);

        $result = json_encode([
            'success' => true,
            'data' => $dish,
            'message' => 'Dish loaded successfully'
        ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);

        // Передаем данные обратно в форму update
        header("Location: crud.php?dish_data=" . urlencode($result) . "&tab=update");
        exit;
    }
} catch (Exception $e) {
    $result = json_encode([
        'success' => false,
        'message' => 'Failed to load dish: ' . $e->getMessage()
    ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
    
    header("Location: crud.php?update_result=" . urlencode($result) . "&update_success=0&tab=update");
    exit;
}