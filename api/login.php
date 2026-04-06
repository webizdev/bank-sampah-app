<?php
// API: Login User
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['email']) || !isset($data['password'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Missing fields']);
    exit;
}

try {
    // 1. Fetch user by email
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$data['email']]);
    $user = $stmt->fetch();

    // 2. Verify password
    if ($user && password_verify($data['password'], $user['password'])) {
        // Successful login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        
        // Regenerate session ID for security
        session_regenerate_id(true);

        echo json_encode(['status' => 'success', 'message' => 'Login successful']);
    } else {
        // Failed login
        echo json_encode(['status' => 'error', 'message' => 'Invalid email or password']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Authentication failed: ' . $e->getMessage()]);
}
?>
