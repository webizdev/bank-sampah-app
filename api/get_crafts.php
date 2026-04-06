<?php
require_once '../includes/db_connect.php';

header('Content-Type: application/json');

try {
    $stmt = $pdo->query("SELECT * FROM crafts ORDER BY created_at DESC");
    $crafts = $stmt->fetchAll();

    echo json_encode([
        'status' => 'success',
        'data' => $crafts
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch crafts'
    ]);
}
?>
