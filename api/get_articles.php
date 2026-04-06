<?php
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

try {
    $limit = isset($_GET['limit']) ? (int)$_GET['limit'] : 100;
    
    // If admin flag is set, we return everything sorted by ID
    if (isset($_GET['admin']) && $_GET['admin'] === 'true') {
        $stmt = $pdo->query("SELECT * FROM content ORDER BY id DESC");
    } else {
        $stmt = $pdo->query("SELECT * FROM content ORDER BY created_at DESC LIMIT $limit");
    }
    
    $articles = $stmt->fetchAll(PDO::FETCH_ASSOC);
    echo json_encode(['status' => 'success', 'data' => $articles]);
} catch (PDOException $e) {
    echo json_encode(['status' => 'error', 'message' => 'API DB Error: ' . $e->getMessage()]);
}
