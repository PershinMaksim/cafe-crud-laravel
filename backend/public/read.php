<?php
// read.php - обновленная версия

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'] ?? '';
    
    // Запрос к API
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, "http://localhost:8000/api/dishes/{$id}");
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Accept: application/json'
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    $result = json_decode($response, true);
    
    if ($httpCode === 200 && $result['success']) {
        header("Location: crud.php?read_result=" . urlencode(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . "&read_success=1&tab=read");
    } else {
        header("Location: crud.php?read_result=" . urlencode(json_encode($result, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)) . "&read_success=0&tab=read");
    }
    exit;
}