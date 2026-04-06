<?php
// API: Submit Waste Transaction
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

// Check Authentication
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id']; 

// Get POST data
$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['category_id']) || !isset($data['weight_est'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing required fields']);
    exit;
}

try {
    // 1. Get Category Price
    $stmt = $pdo->prepare("SELECT price_per_kg FROM waste_categories WHERE id = ?");
    $stmt->execute([$data['category_id']]);
    $category = $stmt->fetch();
    
    if (!$category) {
        throw new Exception("Category not found");
    }

    $estimated_payout = $data['weight_est'] * $category['price_per_kg'];

    // 2. Insert Transaction
    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, category_id, weight_est, total_payout, status, created_at) VALUES (?, ?, ?, ?, 'PENDING', NOW())");
    $stmt->execute([
        $user_id,
        $data['category_id'],
        $data['weight_est'],
        $estimated_payout
    ]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Request submitted successfully',
        'data' => [
            'transaction_id' => $pdo->lastInsertId(),
            'estimated_payout' => $estimated_payout
        ]
    ]);

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
