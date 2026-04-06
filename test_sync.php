<?php
require_once 'includes/db_connect.php';

echo "<h1>Sync Test</h1>";

try {
    // 1. Check existing content
    $stmt = $pdo->query("SELECT COUNT(*) FROM content");
    $count = $stmt->fetchColumn();
    echo "Current articles in 'content' table: $count<br>";

    // 2. Insert a test article
    $title = "Test Sync " . time();
    $stmt = $pdo->prepare("INSERT INTO content (title, subtitle, content, category, location, cta_link) VALUES (?, ?, ?, ?, ?, ?)");
    $stmt->execute([
        $title,
        "Testing if this shows up in admin and user dashboard",
        "This is a test content added via script.",
        "AGENDA",
        "Test Location",
        "https://google.com"
    ]);
    $newId = $pdo->lastInsertId();
    echo "✔ Inserted test article with ID: $newId and Title: $title<br>";

    // 3. Verify insertion
    $stmt = $pdo->prepare("SELECT * FROM content WHERE id = ?");
    $stmt->execute([$newId]);
    $row = $stmt->fetch();
    echo "✔ Verified row in DB: " . json_encode($row) . "<br>";

    echo "<br><a href='admin/articles.php'>Check Admin Page</a><br>";
    echo "<a href='user/dashboard.php'>Check User Dashboard</a><br>";

} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage();
}
?>
