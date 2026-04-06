<?php
require_once '../includes/db_connect.php';

header('Content-Type: application/json');

// Session check
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'ADMIN') {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

try {
    // 1. Total Users
    $stmt = $pdo->query("SELECT COUNT(*) as total FROM users WHERE role = 'USER'");
    $total_users = $stmt->fetch()['total'];

    // 2. Total Waste (Actual Weight from Verified)
    $stmt = $pdo->query("SELECT SUM(weight_actual) as total FROM transactions WHERE status = 'VERIFIED'");
    $total_waste = $stmt->fetch()['total'] ?? 0;

    // 3. Total Payouts
    $stmt = $pdo->query("SELECT SUM(total_payout) as total FROM transactions WHERE status = 'VERIFIED'");
    $total_payout = $stmt->fetch()['total'] ?? 0;

    // 4. Pending Transactions
    $stmt = $pdo->query("
        SELECT t.*, u.name as user_name, p.name as category_name, p.icon as category_icon, p.price_per_kg
        FROM transactions t
        JOIN users u ON t.user_id = u.id
        JOIN products p ON t.product_id = p.id
        WHERE t.status = 'PENDING'
        ORDER BY t.created_at DESC
        LIMIT 10
    ");
    $pending_transactions = $stmt->fetchAll(PDO::FETCH_ASSOC);

    echo json_encode([
        'status' => 'success',
        'stats' => [
            'total_users' => (int)$total_users,
            'total_waste_kg' => (float)$total_waste,
            'total_payout' => (float)$total_payout
        ],
        'pending' => $pending_transactions
    ]);

} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
