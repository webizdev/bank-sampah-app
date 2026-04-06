<?php
require_once '../includes/db_connect.php';

header('Content-Type: application/json');

try {
    // Fetch all products (sub-categories) with their parent names
    $query = "SELECT c1.*, c2.name as parent_name 
              FROM waste_categories c1 
              LEFT JOIN waste_categories c2 ON c1.parent_id = c2.id 
              WHERE c1.parent_id IS NOT NULL 
              ORDER BY c2.name, c1.name ASC";
    
    $stmt = $pdo->query($query);
    $products = $stmt->fetchAll();

    // Fetch all categories (parents) for filtering
    $stmt_cats = $pdo->query("SELECT * FROM waste_categories WHERE parent_id IS NULL ORDER BY name ASC");
    $categories = $stmt_cats->fetchAll();

    echo json_encode([
        'status' => 'success',
        'data' => $products,
        'categories' => $categories
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
