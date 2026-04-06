<?php
require_once '../includes/db_connect.php';

// Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'ADMIN') {
    die("Unauthorized");
}

$query = "SELECT t.id, t.created_at, u.name as user_name, u.email as user_email, 
                 c.name as category_name, t.weight_est, t.weight_actual, t.total_payout, t.status, t.type
          FROM transactions t 
          JOIN users u ON t.user_id = u.id 
          JOIN waste_categories c ON t.category_id = c.id 
          ORDER BY t.created_at DESC";

$stmt = $pdo->query($query);
$transactions = $stmt->fetchAll();

$filename = "laporan_transaksi_" . date('Y-m-d_H-i') . ".csv";

header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=' . $filename);

$output = fopen('php://output', 'w');

// BOM for Excel
fputs($output, $bom =( chr(0xEF) . chr(0xBB) . chr(0xBF) ));

// Header
fputcsv($output, ['ID Transaksi', 'Tanggal', 'Nama Member', 'Email Member', 'Kategori Sampah', 'Estimasi (kg)', 'Berat Aktual (kg)', 'Total Payout (IDR)', 'Status', 'Tipe']);

foreach ($transactions as $row) {
    fputcsv($output, [
        $row['id'],
        $row['created_at'],
        $row['user_name'],
        $row['user_email'],
        $row['category_name'],
        $row['weight_est'],
        $row['weight_actual'] ?: '-',
        $row['total_payout'] ?: 0,
        $row['status'],
        $row['type']
    ]);
}

fclose($output);
exit;
?>
