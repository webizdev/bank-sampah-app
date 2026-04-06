<?php
// API: Get User Statistics & History
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

// Check Authentication
if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id']; 

try {
    // 1. Fetch User Stats
    $stmt = $pdo->prepare("SELECT name, balance, total_kg, tier FROM users WHERE id = ?");
    $stmt->execute([$user_id]);
    $user = $stmt->fetch();
    
    if (!$user) {
        // For development: insert a mock user if not exists
        $pdo->exec("INSERT INTO users (id, name, email, password, balance, total_kg, tier) VALUES (1, 'Aris Setiawan', 'aris@example.com', 'hashed_pass', 2450, 124.5, 'Gold') ON DUPLICATE KEY UPDATE name = VALUES(name)");
        $stmt->execute([$user_id]);
        $user = $stmt->fetch();
    }

    // 2. Fetch Transaction History
    $stmt = $pdo->prepare("
        SELECT t.*, c.name as category_name, c.icon as category_icon 
        FROM transactions t 
        JOIN waste_categories c ON t.category_id = c.id 
        WHERE t.user_id = ? 
        ORDER BY t.created_at DESC 
        LIMIT 10
    ");
    $stmt->execute([$user_id]);
    $history = $stmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'user' => $user,
        'history' => $history
    ]);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch user data: ' . $e->getMessage()
    ]);
}
?>
