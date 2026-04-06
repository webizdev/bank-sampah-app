<?php
$hide_nav = true;
include '../includes/header.php';
include 'sidebar.php';
?>

<div class="md:ml-64 transition-all duration-300 w-full md:w-auto bg-surface min-h-screen pb-20">
    <!-- Header -->
    <header class="bg-white px-4 md:px-8 py-4 md:py-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-primary/5 shadow-sm sticky top-0 z-50">
        <div>
            <h1 class="text-lg md:text-xl font-black text-primary headline tracking-tight leading-none">Riwayat & Laporan</h1>
            <p class="text-[9px] md:text-[10px] font-bold text-outline uppercase tracking-widest mt-1">Audit log semua aktivitas penukaran sampah</p>
        </div>
        <div class="flex gap-4">
             <a href="../api/export_transactions.php" class="bg-surface-container text-primary text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-xl shadow-lg border border-primary/5 hover:bg-primary hover:text-white transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">download</span> Export CSV
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 md:px-8 py-6 md:py-10 space-y-6">
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
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">ID</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">Waktu</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">Member</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">Kategori</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-center">Berat (kg)</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">Payout</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-center">Status</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-right">Aksi</th>
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

<!-- Modal Verification -->
<div id="verify-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-6 transition-opacity">
    <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-10 shadow-2xl transform transition-transform">
        <h3 class="text-lg md:text-2xl font-black text-primary headline tracking-tight mb-2">Verifikasi Berat</h3>
        <p class="text-sm text-on-surface-variant mb-8 font-medium">Masukkan berat aktual sampah yang diterima.</p>
        
        <form id="verify-form" class="space-y-6">
            <input type="hidden" id="verify-id">
            
            <div>
                <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Berat Aktual (kg)</label>
                <input type="number" id="verify-weight" step="0.01" required 
                       class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary text-lg md:text-2xl font-black text-primary text-center">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeVerifyModal()" class="flex-1 py-4 font-bold text-outline hover:text-primary transition-all">Batal</button>
                <button type="submit" class="flex-1 bg-green-500 text-white py-4 font-bold rounded-2xl shadow-xl shadow-green-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all flex justify-center items-center gap-2"><span class="material-symbols-outlined text-[18px]">check_circle</span> Verifikasi</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Rejection -->
<div id="reject-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-6 transition-opacity">
    <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-10 shadow-2xl transform transition-transform">
        <div class="w-16 h-16 bg-red-100 text-red-500 rounded-full flex items-center justify-center mb-4 md:mb-6 mx-auto">
            <span class="material-symbols-outlined text-xl md:text-3xl">warning</span>
        </div>
        <h3 class="text-lg md:text-2xl font-black text-red-500 headline tracking-tight mb-2 text-center">
            Tolak Transaksi?
        </h3>
        <p class="text-sm text-on-surface-variant mb-8 font-medium text-center">Tindakan ini tidak dapat dibatalkan. Nasabah tidak akan menerima saldo untuk transaksi ini.</p>
        
        <form id="reject-form" class="space-y-6">
            <input type="hidden" id="reject-id">
            
            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeRejectModal()" class="flex-1 py-4 font-bold text-outline hover:text-primary transition-all">Batal</button>
                <button type="submit" class="flex-1 bg-red-500 text-white py-4 font-bold rounded-2xl shadow-xl shadow-red-500/20 hover:scale-[1.02] active:scale-[0.98] transition-all">Ya, Tolak</button>
            </div>
        </form>
    </div>
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
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">
                <span class="text-[10px] font-black text-primary uppercase">#TR-${t.id}</span>
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-[11px] font-medium text-outline">
                ${new Date(t.created_at).toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric', hour:'2-digit', minute:'2-digit'})}
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">
                <p class="font-black text-on-surface text-sm">${t.user_name}</p>
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">
                <span class="px-3 py-1 bg-surface-container text-[10px] font-bold text-outline rounded-full">${t.category_name}</span>
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-center">
                <p class="text-sm font-black text-on-surface">${t.weight_actual || t.weight_est} <span class="text-[9px] text-outline">kg</span></p>
                <p class="text-[9px] text-outline font-medium uppercase tracking-tighter">${t.weight_actual ? 'Aktual' : 'Estimasi'}</p>
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">
                <p class="text-sm font-black text-secondary">IDR ${new Intl.NumberFormat('id-ID').format(t.total_payout || 0)}</p>
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-center">
                <span class="px-3 py-1 rounded-full text-[9px] font-black tracking-widest uppercase ${
                    t.status === 'VERIFIED' ? 'bg-green-100 text-green-700' : 
                    (t.status === 'REJECTED' ? 'bg-red-100 text-red-700' : 'bg-primary/10 text-primary')
                }">
                    ${t.status}
                </span>
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-right">
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

function verifyTransaction(id, weightEst) {
    document.getElementById('verify-id').value = id;
    document.getElementById('verify-weight').value = weightEst;
    document.getElementById('verify-modal').classList.remove('hidden');
    setTimeout(() => document.getElementById('verify-weight').focus(), 100);
}

function closeVerifyModal() {
    document.getElementById('verify-modal').classList.add('hidden');
}

document.getElementById('verify-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const id = document.getElementById('verify-id').value;
    const weightActual = document.getElementById('verify-weight').value;
    
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
        closeVerifyModal();
        fetchTransactions();
        alert('✔ Transaksi berhasil diverifikasi!');
    } else {
        alert("❌ Gagal verifikasi: " + result.message);
    }
});

function rejectTransaction(id) {
    document.getElementById('reject-id').value = id;
    document.getElementById('reject-modal').classList.remove('hidden');
}

function closeRejectModal() {
    document.getElementById('reject-modal').classList.add('hidden');
}

document.getElementById('reject-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const id = document.getElementById('reject-id').value;
    
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
        closeRejectModal();
        fetchTransactions();
        alert('✔ Transaksi berhasil ditolak!');
    } else {
        alert("❌ Gagal memproses: " + result.message);
    }
});

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
