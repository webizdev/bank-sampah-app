<?php
require_once 'includes/db_connect.php';

try {
    // Check if waste_categories exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'waste_categories'");
    $hasOld = $stmt->rowCount() > 0;
    
    // Check if categories exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'categories'");
    $hasCat = $stmt->rowCount() > 0;
    
    // Check if products exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'products'");
    $hasProd = $stmt->rowCount() > 0;
    
    echo "waste_categories exists: " . ($hasOld ? 'Yes' : 'No') . "\n";
    echo "categories exists: " . ($hasCat ? 'Yes' : 'No') . "\n";
    echo "products exists: " . ($hasProd ? 'Yes' : 'No') . "\n";
    
    if ($hasOld) {
        $stmt = $pdo->query("SELECT * FROM waste_categories");
        echo "\nwaste_categories data:\n";
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    
    if ($hasProd) {
        $stmt = $pdo->query("SELECT * FROM products");
        echo "\nproducts data:\n";
        print_r($stmt->fetchAll(PDO::FETCH_ASSOC));
    }
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
