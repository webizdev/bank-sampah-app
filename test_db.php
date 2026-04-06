<?php
require_once 'includes/db_connect.php';
function desc($table, $pdo) {
    try {
        echo "<h3>Table: $table</h3>";
        $stmt = $pdo->query("DESCRIBE $table");
        echo "<pre>";
        print_r($stmt->fetchAll());
        echo "</pre>";
    } catch (Exception $e) {
        echo "Error: " . $e->getMessage();
    }
}
desc('categories', $pdo);
desc('products', $pdo);
desc('waste_categories', $pdo);
?>
