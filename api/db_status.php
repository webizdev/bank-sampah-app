<?php
require_once '../includes/db_connect.php';

try {
    // Check tables
    $tables = ['waste_categories', 'categories', 'products', 'content', 'transactions'];
    foreach ($tables as $t) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$t'");
        echo "$t exists: " . ($stmt->rowCount() > 0 ? 'Yes' : 'No') . "\n";
    }

    // Check content table schema
    echo "\nContent Table Schema:\n";
    $stmt = $pdo->query("DESCRIBE content");
    print_r($stmt->fetchAll(PDO::FETCH_ASSOC));

    // Check content data count
    echo "\nContent Count: " . $pdo->query("SELECT COUNT(*) FROM content")->fetchColumn() . "\n";

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
