<?php
require_once '../includes/db_connect.php';

echo "<h1>Admin DB Connectivity Diagnostic</h1>";
echo "<p>Checking connection to table: <b>content</b></p>";

try {
    $stmt = $pdo->query("SELECT COUNT(*) as tot FROM content");
    $count = $stmt->fetch()['tot'];
    echo "<div style='color: green; font-weight: bold;'>✔ SUCCESS: Table 'content' is connected.</div>";
    echo "<p>Total articles found: <b>$count</b></p>";
    
    if ($count > 0) {
        echo "<h3>Article List:</h3><ul>";
        $stmt = $pdo->query("SELECT id, title, category FROM content");
        while($row = $stmt->fetch()) {
            echo "<li>[#{$row['id']}] {$row['category']}: <b>{$row['title']}</b></li>";
        }
        echo "</ul>";
    } else {
        echo "<p style='color: orange;'>⚠ Warning: Table is connected but EMPTY.</p>";
    }
} catch (Exception $e) {
    echo "<div style='color: red; font-weight: bold;'>✘ FAILED: Error connecting to table 'content'.</div>";
    echo "<p>Error details: " . $e->getMessage() . "</p>";
}

echo "<hr>";
echo "<p><i>Script location: " . __FILE__ . "</i></p>";
?>
