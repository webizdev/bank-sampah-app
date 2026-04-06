<?php
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

try {
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 10;
    
    // Safer to inject integer limit directly after casting to (int)
    $stmt = $pdo->query("SELECT * FROM content ORDER BY created_at DESC LIMIT $limit");
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    echo json_encode(['status' => 'success', 'data' => $articles]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'DB Error: ' . $e->getMessage()]);
}
