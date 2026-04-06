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
    
    <div class="flex-1 md:ml-64 p-4 md:p-8 transition-all duration-300 w-full md:w-auto">
        <header class="mb-4 md:mb-6 md:mb-12 flex justify-between items-start">
            <div>
                <h1 class="text-lg md:text-2xl md:text-4xl font-black text-primary headline tracking-tight mb-2">Penjualan (Kasir)</h1>
                <p class="text-on-surface-variant font-medium">Catat pengeluaran stok sampah yang dijual ke pengepul besar.</p>
            </div>
            <button onclick="openSalesModal()" class="bg-primary text-white px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal font-bold rounded-2xl shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex items-center gap-2">
                <span class="material-symbols-outlined">add_shopping_cart</span>
                Tambah Penjualan
            </button>
        </header>

        <section class="bg-white rounded-2xl md:rounded-[2rem] shadow-xl shadow-primary/5 border border-primary/10 overflow-hidden">
            <div class="p-8 border-b border-primary/10 bg-primary/5">
                <h2 class="text-sm md:text-lg lg:text-xl font-bold !leading-tight headline text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined">receipt_long</span> Data Penjualan
                </h2>
            </div>
            
            <div class="p-0 overflow-x-auto">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-surface/50 text-[10px] uppercase tracking-widest text-on-surface-variant">
                            <th class="p-6 font-bold border-b border-outline/10">Tanggal</th>
                            <th class="p-6 font-bold border-b border-outline/10">Produk</th>
                            <th class="p-6 font-bold border-b border-outline/10 text-right">Berat Keluar (kg)</th>
                            <th class="p-6 font-bold border-b border-outline/10 text-right">Harga Jual/kg</th>
                            <th class="p-6 font-bold border-b border-outline/10 text-right">Total Transaksi</th>
                            <th class="p-6 font-bold border-b border-outline/10">Pembeli</th>
                            <th class="p-6 font-bold border-b border-outline/10 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sales-table-body" class="divide-y divide-outline/10">
                        <tr><td colspan="7" class="p-8 text-center text-on-surface-variant">Memuat data...</td></tr>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>

<!-- Modal Form Penjualan -->
<div id="sales-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] p-10 shadow-2xl overflow-y-auto max-h-[90vh]">
        <h3 class="text-lg md:text-2xl font-black text-primary headline tracking-tight mb-2">Input Penjualan Baru</h3>
        <p class="text-sm text-on-surface-variant mb-8 font-medium">Data ini akan memotong stok di Inventori.</p>
        
        <form id="sales-form" class="space-y-6">
            <div>
                <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Pilih Produk</label>
                <select id="product_id" name="product_id" required
                        class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                    <option value="">-- Pilih Produk --</option>
                </select>
                <p id="current-stock-info" class="text-xs text-primary font-bold mt-2 hidden">Stok tersedia: <span id="max-stock">0</span> kg</p>
            </div>
            
            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Berat Terjual (kg)</label>
                    <input type="number" id="weight_sold" name="weight_sold" required step="0.01" min="0.1" oninput="calculateTotal()"
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Harga Jual/kg (IDR)</label>
                    <input type="number" id="price_per_kg" name="price_per_kg" required min="0" oninput="calculateTotal()"
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                </div>
            </div>

            <div class="bg-primary/5 p-4 rounded-xl border border-primary/20">
                <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-1">Total Penjualan</label>
                <input type="number" id="total_price" name="total_price" required readonly
                       class="w-full bg-transparent border-none text-lg md:text-2xl px-0 py-0 font-black text-primary focus:ring-0 cursor-not-allowed">
            </div>

            <div>
                <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Nama Pengepul / Pembeli</label>
                <input type="text" id="buyer_name" name="buyer_name" placeholder="Pengepul Pusat" required
                       class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
            </div>

            <div class="pt-4 flex gap-4">
                <button type="button" onclick="closeSalesModal()" class="flex-1 bg-surface-container text-on-surface font-bold py-4 rounded-2xl hover:bg-outline/10 transition-colors">Batal</button>
                <button type="submit" class="flex-1 bg-primary text-white font-bold py-4 rounded-2xl shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">Simpan & Selesai</button>
            </div>
        </form>
    </div>
</div>

<script>
let inventoryMap = {}; // store max stock

async function loadSales() {
    const tbody = document.getElementById('sales-table-body');
    try {
        const res = await fetch('../api/manage_admin.php?entity=sales&action=read');
        const result = await res.json();
        if (result.status === 'success') {
            const data = result.data;
            if (data.length === 0) {
                tbody.innerHTML = `<tr><td colspan="7" class="p-8 text-center text-on-surface-variant font-medium">Belum ada riwayat penjualan.</td></tr>`;
                return;
            }

            tbody.innerHTML = data.map(item => `
                <tr class="hover:bg-surface/50 transition-colors">
                    <td class="p-6 text-sm font-bold text-on-surface-variant">${new Date(item.created_at).toLocaleDateString('id-ID')}</td>
                    <td class="p-6 font-bold text-on-surface">${item.product_name}</td>
                    <td class="p-6 text-sm font-bold text-right">${parseFloat(item.weight_sold).toFixed(2)}</td>
                    <td class="p-6 text-sm font-bold text-right text-on-surface-variant hover:text-on-surface transition-colors cursor-help" title="Rp ${parseInt(item.price_per_kg).toLocaleString('id-ID')}">${parseInt(item.price_per_kg).toLocaleString('id-ID')}</td>
                    <td class="p-6 text-sm font-black text-right text-primary text-lg">Rp ${parseInt(item.total_price).toLocaleString('id-ID')}</td>
                    <td class="p-6 text-sm font-medium text-on-surface-variant">${item.buyer_name}</td>
                    <td class="p-6 text-center">
                        <button onclick="printReceipt(${item.id})" class="bg-secondary/10 text-secondary hover:bg-secondary hover:text-white p-2 rounded-lg transition-colors inline-block" title="Print Nota">
                            <span class="material-symbols-outlined text-sm">print</span>
                        </button>
                        <button onclick="deleteSale(${item.id})" class="bg-red-50 text-red-500 hover:bg-red-500 hover:text-white p-2 rounded-lg transition-colors inline-block ml-1" title="Hapus">
                            <span class="material-symbols-outlined text-sm">delete</span>
                        </button>
                    </td>
                </tr>
            `).join('');
        }
    } catch(e) {
        tbody.innerHTML = `<tr><td colspan="7" class="p-8 text-center text-red-500">Error loading sales data.</td></tr>`;
    }
}

async function fetchProductsForSales() {
    try {
        const res = await fetch('../api/get_inventory.php');
        const result = await res.json();
        if (result.status === 'success') {
            const select = document.getElementById('product_id');
            select.innerHTML = '<option value="">-- Pilih Produk --</option>';
            inventoryMap = {};
            
            result.data.forEach(p => {
                // only add if it's a product
                inventoryMap[p.id] = parseFloat(p.current_stock);
                select.innerHTML += `<option value="${p.id}">${p.name} (Stok: ${p.current_stock} kg)</option>`;
            });
        }
    } catch (e) {
        console.error("Gagal get products:", e);
    }
}

document.getElementById('product_id').addEventListener('change', (e) => {
    const pId = e.target.value;
    const info = document.getElementById('current-stock-info');
    if (pId && inventoryMap[pId] !== undefined) {
        document.getElementById('max-stock').innerText = inventoryMap[pId].toFixed(2);
        info.classList.remove('hidden');
        // You might want to limit input max based on this, or allow negative stock if forcing sale
    } else {
        info.classList.add('hidden');
    }
});

function calculateTotal() {
    const w = parseFloat(document.getElementById('weight_sold').value) || 0;
    const p = parseFloat(document.getElementById('price_per_kg').value) || 0;
    document.getElementById('total_price').value = Math.floor(w * p);
}

function openSalesModal() {
    document.getElementById('sales-form').reset();
    document.getElementById('current-stock-info').classList.add('hidden');
    fetchProductsForSales();
    document.getElementById('sales-modal').classList.remove('hidden');
}

function closeSalesModal() {
    document.getElementById('sales-modal').classList.add('hidden');
}

document.getElementById('sales-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    data.entity = 'sales';
    data.action = 'create';

    const maxStock = inventoryMap[data.product_id];
    if (parseFloat(data.weight_sold) > maxStock) {
        if(!confirm(`Peringatan: Berat terjual (${data.weight_sold} kg) melebihi stok yang tercatat (${maxStock} kg). Lanjutkan?`)) {
            return;
        }
    }

    try {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await res.json();
        if (result.status === 'success') {
            closeSalesModal();
            loadSales();
            printReceipt(result.id);
        } else {
            alert("Error: " + result.message);
        }
    } catch (e) {
        alert("Gagal menghubungi server.");
    }
});

async function deleteSale(id) {
    if(!confirm("Yakin ingin menghapus data penjualan ini? Stok inventori akan kembali bertambah.")) return;
    try {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ entity: 'sales', action: 'delete', id: id })
        });
        const result = await res.json();
        if (result.status === 'success') {
            loadSales();
        } else {
            alert("Gagal menghapus.");
        }
    } catch(e) {
        alert("Bermasalah saat mengontak server.");
    }
}

function printReceipt(salesId) {
    window.open('print_receipt.php?id=' + salesId, '_blank', 'width=400,height=600');
}

document.addEventListener('DOMContentLoaded', loadSales);
</script>

<?php include '../includes/footer.php'; ?>
