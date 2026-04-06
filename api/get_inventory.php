<?php
// API: Get Inventory
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

try {
    $query = "
        SELECT 
            p.id, 
            p.name, 
            c.name as category_name,
            IFNULL(t.stock_in, 0) as stock_in,
            IFNULL(s.stock_out, 0) as stock_out,
            (IFNULL(t.stock_in, 0) - IFNULL(s.stock_out, 0)) as current_stock
        FROM products p
        LEFT JOIN categories c ON p.category_id = c.id
        LEFT JOIN (
            SELECT product_id, SUM(weight_actual) as stock_in 
            FROM transactions 
            WHERE status IN ('VERIFIED', 'COMPLETED')
            GROUP BY product_id
        ) t ON p.id = t.product_id
        LEFT JOIN (
            SELECT product_id, SUM(weight_sold) as stock_out 
            FROM sales 
            WHERE status IN ('COMPLETED', 'VERIFIED')
            GROUP BY product_id
        ) s ON p.id = s.product_id
        ORDER BY c.name ASC, p.name ASC
    ";
    
    $stmt = $pdo->query($query);
    $inventory = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'data' => $inventory
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch inventory: ' . $e->getMessage()
    ]);
}
?>
