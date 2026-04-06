<?php
require_once 'includes/db_connect.php';
$stmt = $pdo->query("SHOW TABLES");
echo "<h1>Tables:</h1><pre>";
print_r($stmt->fetchAll(PDO::FETCH_COLUMN));
echo "</pre>";

$stmt = $pdo->query("DESCRIBE content");
echo "<h1>Schema 'content':</h1><pre>";
print_r($stmt->fetchAll());
echo "</pre>";
?>
