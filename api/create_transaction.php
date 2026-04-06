<?php
require_once '../includes/db_connect.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    http_response_code(401);
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$user_id = $_SESSION['user_id'];
$input = json_decode(file_get_contents('php://input'), true);

if (!$input || !isset($input['category_id']) || !isset($input['weight_est'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing required data']);
    exit;
}

$category_id = $input['category_id'];
$weight_est = (float)$input['weight_est'];

try {
    // Fetch product price
    $stmt_price = $pdo->prepare("SELECT price_per_kg FROM waste_categories WHERE id = ?");
    $stmt_price->execute([$category_id]);
    $product = $stmt_price->fetch();

    if (!$product) {
        throw new Exception("Produk tidak ditemukan");
    }

    $price_per_kg = $product['price_per_kg'];
    $total_payout = $weight_est * $price_per_kg;

    // Create pending transaction
    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, category_id, weight_est, total_payout, status, type) VALUES (?, ?, ?, ?, 'PENDING', 'DROPOFF')");
    $stmt->execute([$user_id, $category_id, $weight_est, $total_payout]);

    echo json_encode([
        'status' => 'success',
        'message' => 'Laporan penjualan berhasil diajukan. Menunggu verifikasi admin.',
        'transaction_id' => $pdo->lastInsertId()
    ]);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => $e->getMessage()]);
}
?>
