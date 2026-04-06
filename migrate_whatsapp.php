<?php
// Migration Script: Switch to WhatsApp-based Authentication
require_once 'includes/db_connect.php';

try {
    echo "<h2>Starting Migration...</h2>";

    // 1. Add whatsapp column
    $pdo->exec("ALTER TABLE users ADD COLUMN IF NOT EXISTS whatsapp VARCHAR(20) UNIQUE AFTER name");
    echo "<p style='color: green;'>✔ Column 'whatsapp' added successfully (or already exists).</p>";

    // 2. Make email nullable
    $pdo->exec("ALTER TABLE users MODIFY COLUMN email VARCHAR(100) NULL");
    echo "<p style='color: green;'>✔ Column 'email' is now nullable.</p>";

    // 3. Make password nullable
    $pdo->exec("ALTER TABLE users MODIFY COLUMN password VARCHAR(255) NULL");
    echo "<p style='color: green;'>✔ Column 'password' is now nullable.</p>";

    echo "<h3>Migration Complete!</h3>";
    echo "<p>You can now use WhatsApp-based passwordless login.</p>";
    echo "<a href='index.php'>Go to Landing Page</a>";

} catch (PDOException $e) {
    echo "<h2 style='color: red;'>Migration Failed!</h2>";
    echo "<p>" . $e->getMessage() . "</p>";
}
?>
