<?php
require_once '../includes/db_connect.php';

header('Content-Type: application/json');

// Session & Role check
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'ADMIN') {
    http_response_code(403);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized access']);
    exit;
}

// Get the POST data
$input = file_get_contents('php://input');
$data = json_decode($input, true);

if (!isset($data['transaction_id']) || !isset($data['status'])) {
    echo json_encode(['status' => 'error', 'message' => 'Missing required data']);
    exit;
}

try {
    $pdo->beginTransaction();

    // 1. Get transaction details to calculate payout and find user
    $stmt = $pdo->prepare("
        SELECT t.*, c.price_per_kg 
        FROM transactions t 
        JOIN waste_categories c ON t.category_id = c.id 
        WHERE t.id = ? AND t.status = 'PENDING'
        FOR UPDATE
    ");
    $stmt->execute([$data['transaction_id']]);
    $transaction = $stmt->fetch();

    if (!$transaction) {
        throw new Exception("Transaction not found or already processed.");
    }

    $weight_actual = ($data['status'] === 'VERIFIED') ? (float)$data['weight_actual'] : 0;
    $total_payout = $weight_actual * $transaction['price_per_kg'];

    // 2. Update Transaction
    $stmt = $pdo->prepare("
        UPDATE transactions 
        SET weight_actual = ?, total_payout = ?, status = ? 
        WHERE id = ?
    ");
    $stmt->execute([
        $weight_actual,
        $total_payout,
        $data['status'],
        $data['transaction_id']
    ]);

    // 3. Update User Balance & Stats if VERIFIED
    if ($data['status'] === 'VERIFIED') {
        $stmt = $pdo->prepare("
            UPDATE users 
            SET balance = balance + ?, total_kg = total_kg + ? 
            WHERE id = ?
        ");
        $stmt->execute([
            $total_payout,
            $weight_actual,
            $transaction['user_id']
        ]);
        
        // Tier upgrade logic could go here
    }

    $pdo->commit();
    echo json_encode(['status' => 'success', 'message' => 'Transaction updated successfully']);

} catch (Exception $e) {
    if ($pdo->inTransaction()) {
        $pdo->rollBack();
    }
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
