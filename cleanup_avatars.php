<?php
require 'includes/db_connect.php';
try {
    $stmt = $pdo->prepare("UPDATE users SET avatar_url = REPLACE(avatar_url, '../', '') WHERE avatar_url LIKE '../%'");
    $stmt->execute();
    echo "Cleanup successful. Removed ../ from paths.";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
unlink(__FILE__);
?>
