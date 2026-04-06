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

if (!$input || !isset($input['product_id']) || !isset($input['weight_est'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing required data']);
    exit;
}

$product_id = $input['product_id'];
$weight_est = (float)$input['weight_est'];

try {
    // 1. Fetch product price from the new 'products' table
    $stmt_price = $pdo->prepare("SELECT price_per_kg FROM products WHERE id = ?");
    $stmt_price->execute([$product_id]);
    $product = $stmt_price->fetch();

    if (!$product) {
        throw new Exception("Produk tidak ditemukan (ID: $product_id)");
    }

    $price_per_kg = $product['price_per_kg'];
    $total_payout = $weight_est * $price_per_kg;

    // 2. Create pending transaction in the new 'transactions' table
    // Note: We use product_id as defined in our new schema
    $stmt = $pdo->prepare("INSERT INTO transactions (user_id, product_id, weight_est, total_payout, status, type) VALUES (?, ?, ?, ?, 'PENDING', 'DROPOFF')");
    $stmt->execute([$user_id, $product_id, $weight_est, $total_payout]);

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
