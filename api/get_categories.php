<?php
// API: Get Waste Categories
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

try {
    // Fetch all categories and products
    $stmt = $pdo->query("SELECT * FROM waste_categories ORDER BY parent_id ASC, name ASC");
    $all = $stmt->fetchAll();
    
    // Structure the data (Categories with their Products)
    $categories = [];
    $productsByParent = [];
    
    foreach ($all as $item) {
        if ($item['parent_id'] === null) {
            $categories[] = $item;
        } else {
            $productsByParent[$item['parent_id']][] = $item;
        }
    }
    
    echo json_encode([
        'status' => 'success',
        'categories' => $categories,
        'products' => $productsByParent,
        'all' => $all // Kept for backward compatibility if needed
    ]);
    
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch categories'
    ]);
}
?>
