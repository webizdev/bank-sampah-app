<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'ADMIN') {
    header("Location: ../login.php");
    exit;
}
include '../includes/header.php';
?>

<div class="flex min-h-screen bg-surface">
    <?php include 'sidebar.php'; ?>
    
    <div class="flex-1 ml-64 p-8">
        <header class="mb-12">
            <h1 class="text-4xl font-black text-primary headline tracking-tight mb-2">Inventori Produk</h1>
            <p class="text-on-surface-variant font-medium">Pantau akumulasi stok sampah yang masuk dari nasabah dan keluar ke pengepul.</p>
        </header>

        <section class="bg-white rounded-[2rem] shadow-xl shadow-primary/5 border border-primary/10 overflow-hidden">
            <div class="p-8 border-b border-primary/10 flex justify-between items-center bg-primary/5">
                <h2 class="text-xl font-bold headline text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined">inventory_2</span> Tabel Inventori
                </h2>
                <button onclick="loadInventory()" class="text-primary hover:bg-primary/10 p-2 rounded-xl transition-all">
                    <span class="material-symbols-outlined">refresh</span>
                </button>
            </div>
            
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface/50 text-[10px] uppercase tracking-widest text-on-surface-variant">
                            <th class="p-6 font-bold border-b border-outline/10">Kategori</th>
                            <th class="p-6 font-bold border-b border-outline/10">Produk</th>
                            <th class="p-6 font-bold border-b border-outline/10 text-right">Masuk (kg)</th>
                            <th class="p-6 font-bold border-b border-outline/10 text-right text-red-500">Keluar (kg)</th>
                            <th class="p-6 font-bold border-b border-outline/10 text-right text-primary">Sisa Stok (kg)</th>
                        </tr>
                    </thead>
                    <tbody id="inventory-table-body" class="divide-y divide-outline/10">
                        <!-- Data will be loaded here -->
                        <tr>
                            <td colspan="5" class="p-8 text-center text-on-surface-variant">Memuat data inventori...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<script>
async function loadInventory() {
    const tbody = document.getElementById('inventory-table-body');
    try {
        const response = await fetch('../api/get_inventory.php');
        const result = await response.json();
        
        if (result.status === 'success') {
            const data = result.data;
            if (data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="5" class="p-8 text-center text-on-surface-variant font-medium">Belum ada data inventori.</td></tr>`;
                return;
            }

            tbody.innerHTML = data.map(item => `
                <tr class="hover:bg-surface/50 transition-colors">
                    <td class="p-6 text-sm font-bold text-on-surface-variant">${item.category_name}</td>
                    <td class="p-6">
                        <p class="font-bold text-on-surface">${item.name}</p>
                    </td>
                    <td class="p-6 text-sm font-bold text-right">${parseFloat(item.stock_in).toFixed(2)}</td>
                    <td class="p-6 text-sm font-bold text-right text-red-500">${parseFloat(item.stock_out).toFixed(2)}</td>
                    <td class="p-6 text-sm font-black text-right text-primary text-lg">${parseFloat(item.current_stock).toFixed(2)}</td>
                </tr>
            `).join('');
        } else {
            tbody.innerHTML = `<tr><td colspan="5" class="p-8 text-center text-red-500">Error loading inventory.</td></tr>`;
        }
    } catch (e) {
        tbody.innerHTML = `<tr><td colspan="5" class="p-8 text-center text-red-500">Failed to connect to server.</td></tr>`;
    }
}

document.addEventListener('DOMContentLoaded', loadInventory);
</script>

<?php include '../includes/footer.php'; ?>
