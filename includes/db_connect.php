<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start([
        'cookie_httponly' => true,
        'cookie_secure' => isset($_SERVER['HTTPS']),
        'use_strict_mode' => true
    ]);
}
define('BASE_PATH', dirname(__DIR__));
// Database Configuration
$is_local = getenv('IS_LOCAL_DOCKER') === 'true';

if ($is_local) {
    define('DB_HOST', 'db');
    define('DB_NAME', 'banksampah');
    define('DB_USER', 'root');
    define('DB_PASS', 'root');
    // Dev settings
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    // Shared Hosting / Live DB Configuration
    define('DB_HOST', 'localhost');
    define('DB_NAME', 'alilogis_banksampah');
    define('DB_USER', 'alilogis_banksampah');
    define('DB_PASS', 'zGBJyhMnQNCDjVzNvjgb');
    // Production settings
    error_reporting(0);
    ini_set('display_errors', 0);
}

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
    if ($is_local) {
        die("Database connection failed: " . $e->getMessage());
    } else {
        error_log("Connection failed: " . $e->getMessage());
        die("Maaf, terjadi kendala teknis pada server kami. Silakan coba beberapa saat lagi.");
    }
}
?>
