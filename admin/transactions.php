<?php
$hide_nav = true;
include '../includes/header.php';
include 'sidebar.php';
?>

<div class="ml-64 bg-surface min-h-screen pb-20">
    <!-- Header -->
    <header class="bg-white px-8 py-6 flex justify-between items-center border-b border-primary/5 shadow-sm sticky top-0 z-50">
        <div>
            <h1 class="text-xl font-black text-primary headline tracking-tight leading-none">Riwayat & Laporan</h1>
            <p class="text-[10px] font-bold text-outline uppercase tracking-widest mt-1">Audit log semua aktivitas penukaran sampah</p>
        </div>
        <div class="flex gap-4">
             <a href="../api/export_transactions.php" class="bg-surface-container text-primary text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-xl shadow-lg border border-primary/5 hover:bg-primary hover:text-white transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">download</span> Export CSV
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-8 py-10 space-y-6">
        <!-- Filters (Optional UI) -->
        <div class="bg-white p-6 rounded-[2rem] border border-primary/5 shadow-xl flex gap-6 items-end">
             <div class="flex-1">
                <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Cari Transaksi</label>
                <input type="text" id="tx-search" onkeyup="filterTransactions()" placeholder="Nama member atau kategori..." 
                       class="w-full bg-surface-container border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-primary">
             </div>
             <div>
                <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Status</label>
                <select id="status-filter" onchange="filterTransactions()" class="bg-surface-container border-none rounded-xl px-4 py-3 text-xs font-bold focus:ring-2 focus:ring-primary">
                    <option value="">Semua Status</option>
                    <option value="PENDING">PENDING</option>
                    <option value="VERIFIED">VERIFIED</option>
                    <option value="REJECTED">REJECTED</option>
                </select>
             </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-primary/5 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low text-[10px] font-black uppercase tracking-[0.2em] text-outline">
                            <th class="px-8 py-6">ID</th>
                            <th class="px-8 py-6">Waktu</th>
                            <th class="px-8 py-6">Member</th>
                            <th class="px-8 py-6">Kategori</th>
                            <th class="px-8 py-6 text-center">Berat (kg)</th>
                            <th class="px-8 py-6">Payout</th>
                            <th class="px-8 py-6 text-center">Status</th>
                            <th class="px-8 py-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="transaction-table" class="divide-y divide-primary/5">
                        <tr>
                            <td colspan="8" class="px-8 py-20 text-center text-outline italic">Memuat data histori...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<script>
let transactions = [];

async function fetchTransactions() {
    const res = await fetch('../api/manage_admin.php?entity=transactions');
    const result = await res.json();
    if (result.status === 'success') {
        transactions = result.data;
        renderTable(transactions);
    }
}

function renderTable(dataList) {
    const tbody = document.getElementById('transaction-table');
    if (dataList.length === 0) {
        tbody.innerHTML = '<tr><td colspan="8" class="px-8 py-20 text-center text-outline italic">Tidak ada transaksi ditemukan.</td></tr>';
        return;
    }

    tbody.innerHTML = dataList.map(t => `
        <tr class="hover:bg-primary/5 transition-colors">
            <td class="px-8 py-6">
                <span class="text-[10px] font-black text-primary uppercase">#TR-${t.id}</span>
            </td>
            <td class="px-8 py-6 text-[11px] font-medium text-outline">
                ${new Date(t.created_at).toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit'})}
            </td>
            <td class="px-8 py-6">
                <p class="font-black text-on-surface text-sm">${t.user_name}</p>
            </td>
            <td class="px-8 py-6">
                <span class="px-3 py-1 bg-surface-container text-[10px] font-bold text-outline rounded-full">${t.category_name}</span>
            </td>
            <td class="px-8 py-6 text-center">
                <p class="text-sm font-black text-on-surface">${t.weight_actual || t.weight_est} <span class="text-[9px] text-outline">kg</span></p>
                <p class="text-[9px] text-outline font-medium uppercase tracking-tighter">${t.weight_actual ? 'Aktual' : 'Estimasi'}</p>
            </td>
            <td class="px-8 py-6">
                <p class="text-sm font-black text-secondary">IDR ${new Intl.NumberFormat('id-ID').format(t.total_payout || 0)}</p>
            </td>
            <td class="px-8 py-6 text-center">
                <span class="px-3 py-1 rounded-full text-[9px] font-black tracking-widest uppercase ${
                    t.status === 'VERIFIED' ? 'bg-green-100 text-green-700' : 
                    (t.status === 'REJECTED' ? 'bg-red-100 text-red-700' : 'bg-primary/10 text-primary')
                }">
                    ${t.status}
                </span>
            </td>
            <td class="px-8 py-6 text-right">
                ${t.status === 'PENDING' ? `
                    <div class="flex justify-end gap-2">
                        <button onclick="verifyTransaction(${t.id}, ${t.weight_est})" 
                                class="w-8 h-8 rounded-lg bg-green-100 text-green-600 flex items-center justify-center hover:bg-green-600 hover:text-white transition-all shadow-sm"
                                title="Verifikasi">
                            <span class="material-symbols-outlined text-[18px]">check_circle</span>
                        </button>
                        <button onclick="rejectTransaction(${t.id})" 
                                class="w-8 h-8 rounded-lg bg-red-100 text-red-600 flex items-center justify-center hover:bg-red-600 hover:text-white transition-all shadow-sm"
                                title="Tolak">
                            <span class="material-symbols-outlined text-[18px]">cancel</span>
                        </button>
                    </div>
                ` : `
                    <span class="material-symbols-outlined text-outline/30 text-[18px]">check_circle</span>
                `}
            </td>
        </tr>
    `).join('');
}

async function verifyTransaction(id, weightEst) {
    const weightActual = prompt("Masukkan berat aktual (kg):", weightEst);
    if (weightActual === null) return;

    if (confirm(`Verifikasi transaksi #${id} dengan berat ${weightActual}kg? Saldo akan langsung ditambahkan ke user.`)) {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            body: new URLSearchParams({
                entity: 'transactions',
                action: 'verify',
                id: id,
                weight_actual: weightActual
            })
        });
        const result = await res.json();
        if (result.status === 'success') {
            fetchTransactions();
        } else {
            alert("Gagal verifikasi: " + result.message);
        }
    }
}

async function rejectTransaction(id) {
    if (confirm(`Tolak transaksi #${id}?`)) {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            body: new URLSearchParams({
                entity: 'transactions',
                action: 'reject',
                id: id
            })
        });
        const result = await res.json();
        if (result.status === 'success') {
            fetchTransactions();
        } else {
            alert("Gagal memproses: " + result.message);
        }
    }
}

function filterTransactions() {
    const q = document.getElementById('tx-search').value.toLowerCase();
    const s = document.getElementById('status-filter').value;
    
    const filtered = transactions.filter(t => {
        const matchSearch = t.user_name.toLowerCase().includes(q) || t.category_name.toLowerCase().includes(q);
        const matchStatus = s === '' || t.status === s;
        return matchSearch && matchStatus;
    });
    
    renderTable(filtered);
}

// Initial Load
document.addEventListener('DOMContentLoaded', fetchTransactions);
</script>

<?php include '../includes/footer.php'; ?>
