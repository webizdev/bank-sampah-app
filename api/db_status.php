<?php
require_once '../includes/db_connect.php';

echo "<pre>";
try {
    // 1. Check if tables exist
    $tables = ['users', 'categories', 'products', 'transactions', 'sales', 'content', 'crafts', 'services', 'settings'];
    echo "=== TABLE STATUS ===\n";
    foreach ($tables as $t) {
        $stmt = $pdo->query("SHOW TABLES LIKE '$t'");
        echo str_pad($t, 15) . ": " . ($stmt->rowCount() > 0 ? '[OK] EXISTS' : '[!!] MISSING') . "\n";
    }

    // 2. Sample Data Verification
    echo "\n=== DATA SUMMARY ===\n";
    $stats = [
        'Users' => "SELECT COUNT(*) FROM users",
        'Categories' => "SELECT COUNT(*) FROM categories",
        'Products' => "SELECT COUNT(*) FROM products",
        'Transactions' => "SELECT COUNT(*) FROM transactions",
        'Articles' => "SELECT COUNT(*) FROM content"
    ];
    foreach ($stats as $label => $sql) {
        $stmt = $pdo->query($sql);
        echo str_pad($label, 15) . ": " . $stmt->fetchColumn() . " records\n";
    }

    // 3. Transactions Table Schema (Critical Check)
    echo "\n=== TRANSACTIONS SCHEMA ===\n";
    $stmt = $pdo->query("DESCRIBE transactions");
    $columns = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($columns as $col) {
        echo str_pad($col['Field'], 15) . " | " . str_pad($col['Type'], 15) . " | " . $col['Null'] . "\n";
    }

} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
echo "</pre>";
?>
