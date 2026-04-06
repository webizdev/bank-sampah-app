<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'ADMIN') {
    die("Unauthorized access");
}
require_once '../includes/db_connect.php';

$id = $_GET['id'] ?? null;
if (!$id) die("No ID provided");

try {
    // Get sale data
    $stmt = $pdo->prepare("SELECT s.*, p.name as product_name FROM sales s JOIN products p ON s.product_id = p.id WHERE s.id = ?");
    $stmt->execute([$id]);
    $sale = $stmt->fetch();
    
    if (!$sale) die("Sale not found");

    // Get settings data for receipt header
    $stmt2 = $pdo->query("SELECT setting_key, setting_value FROM settings");
    $settingsRaw = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    $settings = [];
    foreach ($settingsRaw as $row) {
        $settings[$row['setting_key']] = $row['setting_value'];
    }
    
    $appName = $settings['app_name'] ?? 'Bank Sampah';
    $address = $settings['address'] ?? '';
    $wa = $settings['wa_cs_number'] ?? '';

} catch (Exception $e) {
    die("Database error");
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nota Penjualan #<?= str_pad($sale['id'], 5, '0', STR_PAD_LEFT) ?></title>
    <style>
        @page {
            margin: 0;
        }
        body {
            font-family: 'Courier New', Courier, monospace;
            font-size: 12px;
            color: #000;
            background: #fff;
            margin: 0;
            padding: 15px;
            width: 100%;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }
        h1 {
            font-size: 16px;
            text-align: center;
            margin: 5px 0;
            text-transform: uppercase;
        }
        p {
            margin: 3px 0;
            text-align: center;
        }
        .divider {
            border-top: 1px dashed #000;
            margin: 10px 0;
        }
        .text-left { text-align: left; }
        .text-right { text-align: right; }
        .flex {
            display: flex;
            justify-content: space-between;
        }
        .bold { font-weight: bold; }
        .mb { margin-bottom: 5px; }
        .mt { margin-top: 5px; }
        @media print {
            .no-print { display: none; }
        }
        button.no-print {
            display: block;
            width: 100%;
            padding: 10px;
            background: #000;
            color: #fff;
            border: none;
            font-size: 14px;
            cursor: pointer;
            font-family: inherit;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>

    <button onclick="window.print()" class="no-print">Cetak Nota Sekarang</button>

    <h1><?= htmlspecialchars($appName) ?></h1>
    <?php if($address): ?><p><?= nl2br(htmlspecialchars($address)) ?></p><?php endif; ?>
    <?php if($wa): ?><p>WA: <?= htmlspecialchars($wa) ?></p><?php endif; ?>

    <div class="divider"></div>

    <div class="flex mb">
        <span>No Nota:</span>
        <span>#<?= str_pad($sale['id'], 5, '0', STR_PAD_LEFT) ?></span>
    </div>
    <div class="flex mb">
        <span>Tanggal:</span>
        <span><?= date('d/m/Y H:i', strtotime($sale['created_at'])) ?></span>
    </div>
    <div class="flex mb">
        <span>Pembeli:</span>
        <span><?= htmlspecialchars($sale['buyer_name']) ?></span>
    </div>

    <div class="divider"></div>

    <div class="text-left bold mb">Rincian:</div>
    <div class="flex mb">
        <span><?= htmlspecialchars($sale['product_name']) ?></span>
    </div>
    <div class="flex mb text-right" style="padding-left: 20px;">
        <span><?= number_format($sale['weight_sold'], 2, ',', '.') ?> kg x <?= number_format($sale['price_per_kg'], 0, ',', '.') ?></span>
    </div>

    <div class="divider"></div>

    <div class="flex bold mt">
        <span>TOTAL BELANJA</span>
        <span>Rp <?= number_format($sale['total_price'], 0, ',', '.') ?></span>
    </div>

    <div class="divider"></div>

    <p style="margin-top: 20px;">Terima kasih atas kerjasamanya!</p>
    <p>Dicetak oleh: Administrator</p>

    <script>
        // Auto print prompt when loaded
        window.onload = function() {
            window.print();
        }
    </script>
</body>
</html>
