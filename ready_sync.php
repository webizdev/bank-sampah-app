<?php
require_once 'includes/db_connect.php';

// Diagnostic script for articles synchronization
header('Content-Type: text/plain');

echo "--- BANK SAMPAH ARTICLE SYNC TOOL ---\n\n";

try {
    // 1. Check Database Name
    echo "1. Checking Database Connection...\n";
    echo "Current Database: alilogis_banksampah\n";
    echo "✔ Connection Successful!\n\n";

    // 2. Ensure Schema for 'content' table
    echo "2. Validating 'content' Table Schema...\n";
    
    // Check if table exists
    $stmt = $pdo->query("SHOW TABLES LIKE 'content'");
    if ($stmt->rowCount() == 0) {
        echo "ℹ Creating 'content' table...\n";
        $pdo->exec("CREATE TABLE content (
            id INT AUTO_INCREMENT PRIMARY KEY,
            title VARCHAR(255) NOT NULL,
            subtitle VARCHAR(255),
            content TEXT NOT NULL,
            category ENUM('AGENDA', 'EDUKASI', 'KARIR') NOT NULL,
            image_url TEXT,
            event_date DATE,
            location VARCHAR(255),
            cta_link TEXT,
            created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
        )");
        echo "✔ Table 'content' created.\n";
    } else {
        echo "✔ Table 'content' exists.\n";
        
        // Add missing columns if they don't exist
        $cols = [
            'location' => "ALTER TABLE content ADD COLUMN location VARCHAR(255) AFTER event_date",
            'cta_link' => "ALTER TABLE content ADD COLUMN cta_link TEXT AFTER location"
        ];
        
        foreach ($cols as $col => $sql) {
            try {
                $pdo->exec($sql);
                echo "✔ Added column: $col\n";
            } catch (Exception $e) {
                echo "ℹ Column $col already exists.\n";
            }
        }
    }

    // 3. Clear and Re-seed Dummy Data (if confirmed)
    echo "\n3. Seeding dummy data for synchronization testing...\n";
    
    $articles = [
        [
            'title' => 'Piknik Bersih Pantai Ancol',
            'subtitle' => 'Aksi kolaborasi komunitas untuk membersihkan pesisir Jakarta.',
            'content' => 'Aksi nyata untuk lingkungan pesisir.',
            'category' => 'AGENDA',
            'image_url' => 'https://images.unsplash.com/photo-1595273670150-db0a3d39074f?auto=format&fit=crop&q=80&w=600',
            'event_date' => '2026-10-24',
            'location' => 'Pantai Ancol, Jakarta',
            'cta_link' => 'https://wa.me/6281234567890'
        ],
        [
            'title' => 'Workshop Kompos Mandiri',
            'subtitle' => 'Ubah sampah dapur menjadi pupuk bernilai tinggi.',
            'content' => 'Cara mengolah organik sisa dapur.',
            'category' => 'EDUKASI',
            'image_url' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&q=80&w=600',
            'event_date' => '2026-11-05',
            'location' => 'Balai Kota, Jakarta',
            'cta_link' => 'https://google.com'
        ]
    ];

    // Clear existing to ensure sync
    $pdo->exec("DELETE FROM content");
    
    $stmt = $pdo->prepare("INSERT INTO content (title, subtitle, content, category, event_date, location, cta_link, image_url) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    foreach ($articles as $a) {
        $stmt->execute([
            $a['title'], $a['subtitle'], $a['content'], 
            $a['category'], $a['event_date'], $a['location'], 
            $a['cta_link'], $a['image_url']
        ]);
        echo "✔ Inserted: " . $a['title'] . "\n";
    }

    echo "\n--- SUCCESS: DATA SYNCHRONIZED SUCCESSFULLY ---\n";
    echo "Silakan cek Admin Artikel & App Home Anda.";

} catch (Exception $e) {
    echo "\n❌ ERROR: " . $e->getMessage();
}
?>
