<?php
require_once 'includes/db_connect.php';
try {
    $stmt = $pdo->query("SELECT name, whatsapp, role FROM users WHERE role = 'ADMIN'");
    $admins = $stmt->fetchAll();
    echo "<h1>Admin Users</h1>";
    echo "<table border='1'><tr><th>Name</th><th>WhatsApp</th></tr>";
    foreach ($admins as $admin) {
        echo "<tr><td>{$admin['name']}</td><td>{$admin['whatsapp']}</td></tr>";
    }
    echo "</table>";
} catch (Exception $e) {
    echo "Error: " . $e->getMessage();
}
