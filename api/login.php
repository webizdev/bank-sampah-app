<?php
// API: Login User (Passwordless Demo)
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

$data = json_decode(file_get_contents('php://input'), true);

if (!isset($data['whatsapp'])) {
    http_response_code(400);
    echo json_encode(['status' => 'error', 'message' => 'Nomor WhatsApp diperlukan']);
    exit;
}

try {
    // 1. Fetch user by whatsapp
    $stmt = $pdo->prepare("SELECT * FROM users WHERE whatsapp = ?");
    $stmt->execute([$data['whatsapp']]);
    $user = $stmt->fetch();

    // 2. Simple Login (No Password for Demo)
    if ($user) {
        // Successful login
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['name'];
        $_SESSION['user_role'] = $user['role'];
        
        // Regenerate session ID for security
        session_regenerate_id(true);

        echo json_encode([
            'status' => 'success', 
            'message' => 'Login berhasil',
            'role' => $user['role']
        ]);
    } else {
        // Failed login
        echo json_encode(['status' => 'error', 'message' => 'Nomor WhatsApp tidak terdaftar']);
    }

} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Gagal masuk: ' . $e->getMessage()]);
}
?>
