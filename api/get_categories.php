<?php
// API: Get Waste Categories
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

try {
    $stmt = $pdo->query("SELECT * FROM waste_categories ORDER BY category, name ASC");
    $categories = $stmt->fetchAll();
    
    echo json_encode([
        'status' => 'success',
        'data' => $categories
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch categories'
    ]);
}
?>
