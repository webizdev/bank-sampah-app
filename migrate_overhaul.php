<?php
require_once 'includes/db_connect.php';

echo "<h1>Database Overhaul Migration</h1>";

try {
    // 1. Update Users Table
    $queries = [
        "ALTER TABLE users ADD COLUMN bank_name VARCHAR(100) DEFAULT NULL AFTER tier",
        "ALTER TABLE users ADD COLUMN account_number VARCHAR(50) DEFAULT NULL AFTER bank_name",
        "ALTER TABLE users ADD COLUMN avatar_url TEXT DEFAULT NULL AFTER account_number",
        "ALTER TABLE users ADD COLUMN latitude DECIMAL(10, 8) DEFAULT NULL AFTER avatar_url",
        "ALTER TABLE users ADD COLUMN longitude DECIMAL(11, 8) DEFAULT NULL AFTER latitude",
        "ALTER TABLE users ADD COLUMN address TEXT DEFAULT NULL AFTER longitude",
        "ALTER TABLE users ADD COLUMN organization VARCHAR(100) DEFAULT NULL AFTER address"
    ];

    foreach ($queries as $query) {
        try {
            $pdo->exec($query);
            echo "✔ Executed: " . substr($query, 0, 50) . "...<br>";
        } catch (PDOException $e) {
            echo "ℹ Skipped (likely already exists): " . $e->getMessage() . "<br>";
        }
    }

    // 2. Create Crafts Table
    $createTable = "CREATE TABLE IF NOT EXISTS crafts (
        id INT AUTO_INCREMENT PRIMARY KEY,
        title VARCHAR(255) NOT NULL,
        description TEXT,
        price DECIMAL(15, 2) NOT NULL,
        image_url TEXT,
        cta_link TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    )";
    $pdo->exec($createTable);
    echo "✔ Table 'crafts' ready.<br>";

    // 3. Seed Sample Crafts
    $checkCrafts = $pdo->query("SELECT COUNT(*) FROM crafts")->fetchColumn();
    if ($checkCrafts == 0) {
        $seedData = [
            [
                'title' => 'Tas Belanja Upcycled',
                'description' => 'Tas belanja stylish yang terbuat dari 100% limbah plastik kemasan sabun dan kopi.',
                'price' => 45000,
                'image_url' => 'https://images.unsplash.com/photo-1544816155-12df9643f363?auto=format&fit=crop&q=80&w=600',
                'cta_link' => 'https://wa.me/628123456789?text=Saya+ingin+pesan+Tas+Belanja+Upcycled'
            ],
            [
                'title' => 'Pot Bunga Estetik',
                'description' => 'Pot bunga minimalis hasil daur ulang limbah semen dan serbuk kayu.',
                'price' => 25000,
                'image_url' => 'https://images.unsplash.com/photo-1485955900006-10f4d324d411?auto=format&fit=crop&q=80&w=600',
                'cta_link' => 'https://wa.me/628123456789?text=Saya+ingin+pesan+Pot+Bunga+Estetik'
            ],
            [
                'title' => 'Lampu Meja Karakter',
                'description' => 'Lampu hias unik yang dibuat dari botol kaca bekas dan fitting kayu pinus.',
                'price' => 125000,
                'image_url' => 'https://images.unsplash.com/photo-1507473885765-e6ed057f782c?auto=format&fit=crop&q=80&w=600',
                'cta_link' => 'https://wa.me/628123456789?text=Saya+ingin+pesan+Lampu+Meja+Karakter'
            ]
        ];

        $stmt = $pdo->prepare("INSERT INTO crafts (title, description, price, image_url, cta_link) VALUES (?, ?, ?, ?, ?)");
        foreach ($seedData as $craft) {
            $stmt->execute([$craft['title'], $craft['description'], $craft['price'], $craft['image_url'], $craft['cta_link']]);
        }
        echo "✔ Sample crafts seeded.<br>";
    }

    echo "<h2 style='color: green;'>Migration Complete!</h2>";
    echo "<p>Please delete this file for security.</p>";
} catch (PDOException $e) {
    echo "<h2 style='color: red;'>Migration Failed: " . $e->getMessage() . "</h2>";
}
?>
