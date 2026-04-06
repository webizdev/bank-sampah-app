<?php
require_once '../includes/db_connect.php';

header('Content-Type: application/json');

try {
    // 1. Fetch all products with their parent categories (using JOIN)
    $stmt = $pdo->query("
        SELECT 
            p.*, 
            c.name as parent_name,
            p.category_id as parent_id
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        ORDER BY c.name, p.name ASC
    ");
    $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Fetch all categories (parents) for filtering in Jual UI
    $stmt_cats = $pdo->query("SELECT id, name, slug, description, icon FROM categories ORDER BY name ASC");
    $categories = $stmt_cats->fetchAll(PDO::FETCH_ASSOC);

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
