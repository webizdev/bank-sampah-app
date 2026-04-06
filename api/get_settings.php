<?php
// API: Get App Settings
header('Content-Type: application/json');
require_once '../includes/db_connect.php';

try {
    $stmt = $pdo->query("SELECT setting_key, setting_value FROM settings");
    $settingsRaw = $stmt->fetchAll(PDO::FETCH_ASSOC);
    
    $settings = [];
    foreach ($settingsRaw as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    
    // Default values if some rows don't exist yet
    $defaults = [
        'app_name' => 'Bank Sampah',
        'wa_cs_number' => '',
        'address' => '',
        'tier_bronze_min' => '0',
        'tier_silver_min' => '50',
        'tier_gold_min' => '200'
    ];
    
    $finalSettings = array_merge($defaults, $settings);

    echo json_encode([
        'status' => 'success',
        'data' => $finalSettings
    ]);
} catch (PDOException $e) {
    http_response_code(500);
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to fetch settings: ' . $e->getMessage()
    ]);
}
?>
