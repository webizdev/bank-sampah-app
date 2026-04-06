<?php
// API: Get Waste Categories and Products (Unified list for admin UI)
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

try {
    // 1. Fetch categories (from the dedicated categories table)
    $stmt = $pdo->query("SELECT id, name, slug, description, icon, is_popular, image_url, 'category' as type FROM categories ORDER BY name ASC");
    $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);

    // 2. Fetch products (from the dedicated products table, with parent_id mapping)
    $prodStmt = $pdo->query("SELECT id, name, slug, description, icon, category_id, category_id as parent_id, price_per_kg, is_popular, image_url, 'product' as type FROM products ORDER BY name ASC");
    $products = $prodStmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'categories' => $categories,
        'products' => $products,
        'all' => array_merge($categories, $products)
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch categories: ' . $e->getMessage()
    ]);
}
?>
