<?php
session_start();
// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'alilogis_banksampah');
define('DB_USER', 'alilogis_banksampah');
define('DB_PASS', 'zGBJyhMnQNCDjVzNvjgb');

try {
    // Create PDO connection
    $dsn = "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    
    $pdo = new PDO($dsn, DB_USER, DB_PASS, $options);
    
} catch (PDOException $e) {
    // In production, log this and show a generic error
    die("Database connection failed: " . $e->getMessage());
}
?>
