<?php
// API: Get Waste Categories and Products (Unified list for admin UI)
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

try {
    // Fetch categories (top-level)
    $catStmt = $pdo->query("SELECT id, name, slug, description, icon, parent_id, price_per_kg, is_popular, image_url FROM waste_categories WHERE parent_id IS NULL ORDER BY name ASC");
    $categories = $catStmt->fetchAll(PDO::FETCH_ASSOC);

    // Fetch products (children)
    $prodStmt = $pdo->query("SELECT id, name, slug, description, icon, parent_id, price_per_kg, is_popular, image_url FROM waste_categories WHERE parent_id IS NOT NULL ORDER BY name ASC");
    $products = $prodStmt->fetchAll(PDO::FETCH_ASSOC);

    // Merge into flat list with explicit typing
    foreach ($categories as &$c) { $c['type'] = 'category'; }
    foreach ($products as &$p) { $p['type'] = 'product'; }
    $all = array_merge($categories, $products);

    echo json_encode([
        'status' => 'success',
        'categories' => $categories,
        'products' => $products,
        'all' => $all
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch categories: ' . $e->getMessage()
    ]);
}
?>
