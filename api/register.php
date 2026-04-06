<?php
// API: Register User (Passwordless Demo)
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name']) || !isset($data['whatsapp'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing name or whatsapp']);
    exit;
}

try {
    // 1. Check if whatsapp already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE whatsapp = ?");
    $stmt->execute([$data['whatsapp']]);
    if ($stmt->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'Nomor WhatsApp sudah terdaftar']);
        exit;
    }

    // 2. Insert User (Passwordless)
    $stmt = $pdo->prepare("INSERT INTO users (name, whatsapp, role, balance, total_kg, tier, created_at) VALUES (?, ?, 'USER', 0, 0.0, 'Bronze', NOW())");
    $stmt->execute([
        $data['name'],
        $data['whatsapp']
    ]);

    echo json_encode(['status' => 'success', 'message' => 'Pendaftaran berhasil']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Pendaftaran gagal: ' . $e->getMessage()]);
}
?>
