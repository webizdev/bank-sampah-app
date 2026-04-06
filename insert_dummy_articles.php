<?php
require_once 'includes/db_connect.php';

$articles = [
    [
        'title' => 'Piknik Bersih Pantai Ancol',
        'subtitle' => 'Aksi kolaborasi komunitas untuk membersihkan pesisir Jakarta dari sampah plastik.',
        'content' => 'Mari bergabung dalam aksi nyata untuk lingkungan! Kita akan berkeliling pesisir Ancol untuk memungut sampah serta memberikan edukasi kepada pengunjung tentang pentingnya menjaga kebersihan laut.',
        'category' => 'AGENDA',
        'image_url' => 'https://images.unsplash.com/photo-1595273670150-db0a3d39074f?auto=format&fit=crop&q=80&w=600',
        'event_date' => '2026-10-24',
        'location' => 'Pantai Ancol, Jakarta',
        'cta_link' => 'https://wa.me/6281234567890?text=Halo%20saya%20tertarik%20ikut%20Piknik%20Bersih'
    ],
    [
        'title' => 'Workshop Kompos Mandiri',
        'subtitle' => 'Ubah sampah dapur menjadi pupuk bernilai tinggi dengan teknik komposting sederhana.',
        'content' => 'Dalam workshop ini, Anda akan belajar cara membuat komposter rumah tangga dan mengolah sisa organik menjadi pupuk organik cair maupun padat.',
        'category' => 'EDUKASI',
        'image_url' => 'https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&q=80&w=600',
        'event_date' => '2026-11-05',
        'location' => 'Balai Kota, Jakarta',
        'cta_link' => 'https://google.com/search?q=tutorial+kompos'
    ],
    [
        'title' => 'Program Duta Lingkungan 2026',
        'subtitle' => 'Dibuka kesempatan bagi generasi muda untuk menjadi penggerak perubahan lingkungan.',
        'content' => 'Cari pengalaman berharga sebagai penggerak komunitas pengelola sampah. Dapatkan pelatihan khusus dan networking luas di bidang keberlanjutan.',
        'category' => 'KARIR',
        'image_url' => 'https://images.unsplash.com/photo-1544027993-37dbfe43562a?auto=format&fit=crop&q=80&w=600',
        'event_date' => '2026-12-01',
        'location' => 'Gedung Kesenian, Jakarta',
        'cta_link' => 'https://wa.me/6281234567890?text=Info%20Duta%20Lingkungan'
    ]
];

try {
    // Clear existing content to avoid duplicates during this dummy insertion
    $pdo->exec("DELETE FROM content");
    
    $stmt = $pdo->prepare("INSERT INTO content (title, subtitle, content, category, image_url, event_date, location, cta_link) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    
    foreach ($articles as $a) {
        $stmt->execute([
            $a['title'],
            $a['subtitle'],
            $a['content'],
            $a['category'],
            $a['image_url'],
            $a['event_date'],
            $a['location'],
            $a['cta_link']
        ]);
        echo "Inserted: " . $a['title'] . "\n";
    }
    
    echo "\nSuccess: 3 articles inserted.";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
