<?php
// create.php - обновленная версия, работающая через API

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $_POST['name'] ?? '';
    $description = $_POST['description'] ?? '';
    $price = $_POST['price'] ?? 0;
    $quantity = $_POST['quantity'] ?? 0;
    $is_active = isset($_POST['is_active']) ? 'true' : 'false';
    
    // Подготовка данных для API
    $postData = http_build_query([
        'name' => $name,
        'description' => $description,
        'price' => $price,
        'quantity' => $quantity,
        'is_active' => $is_active
    ]);
    
    // Отправка запроса к API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'http://localhost:8000/api/dishes');
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    // Обработка ответа
    $result = json_decode($response, true);
    
    if ($httpCode === 201 && $result['success']) {
        header("Location: crud.php?create_result=" . urlencode(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . "&create_success=1&tab=create");
    } else {
        header("Location: crud.php?create_result=" . urlencode(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . "&create_success=0&tab=create");
    }
    exit;
}