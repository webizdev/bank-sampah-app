<?php
// API: Register User
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['name']) || !isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
    exit;
}

try {
    // 1. Check if email already exists
    $stmt = $pdo->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$data['email']]);
    if ($stmt->fetch()) {
        echo json_encode(['status' => 'error', 'message' => 'Email already registered']);
        exit;
    }

    // 2. Hash Password
    $hashed_password = password_hash($data['password'], PASSWORD_DEFAULT);

    // 3. Insert User
    $stmt = $pdo->prepare("INSERT INTO users (name, email, password, balance, total_kg, tier, created_at) VALUES (?, ?, ?, 0, 0.0, 'Bronze', NOW())");
    $stmt->execute([
        $data['name'],
        $data['email'],
        $hashed_password
    ]);

    echo json_encode(['status' => 'success', 'message' => 'User registered successfully']);

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Registration failed: ' . $e->getMessage()]);
}
?>
