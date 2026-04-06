<?php
$hide_nav = true; // Admin has its own sidebar/nav
include '../includes/header.php';
?>

<div class="bg-surface min-h-screen pb-20">
    <!-- Admin Top Header -->
    <header class="bg-white px-8 py-6 flex justify-between items-center border-b border-primary/5 shadow-sm sticky top-0 z-50">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white">
                <span class="material-symbols-outlined">analytics</span>
            </div>
            <div>
                <h1 class="text-xl font-black text-primary headline tracking-tight leading-none">Admin Console</h1>
                <p class="text-[10px] font-bold text-outline uppercase tracking-widest mt-1">Staf Bank Sampah</p>
            </div>
        </div>
        <div class="flex items-center gap-4">
            <div class="text-right hidden sm:block">
                <p class="text-xs font-bold text-on-surface"><?php echo $_SESSION['user_name']; ?></p>
                <p class="text-[9px] font-black text-primary uppercase">Administrator</p>
            </div>
            <a href="../logout.php" class="w-10 h-10 rounded-full bg-surface-container-low flex items-center justify-center text-outline hover:text-red-500 hover:bg-red-50 transition-all">
                <span class="material-symbols-outlined">logout</span>
            </a>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-8 py-10 space-y-12">
        <!-- Stats Grid -->
        <section class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-[2rem] border border-primary/5 shadow-xl shadow-primary/5">
                <div class="flex justify-between items-center mb-6">
                    <span class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">group</span>
                    </span>
                    <span class="text-xs font-black text-outline uppercase tracking-widest">Total Member</span>
                </div>
                <h3 id="stat-users" class="text-5xl font-black text-primary headline tracking-tighter">0</h3>
                <p class="text-xs text-on-surface-variant font-medium mt-4">Warga aktif terdaftar</p>
            </div>
            
            <div class="bg-white p-8 rounded-[2rem] border border-primary/5 shadow-xl shadow-primary/5">
                <div class="flex justify-between items-center mb-6">
                    <span class="w-12 h-12 rounded-2xl bg-secondary/10 flex items-center justify-center text-secondary">
                        <span class="material-symbols-outlined">eco</span>
                    </span>
                    <span class="text-xs font-black text-outline uppercase tracking-widest">Total Sampah</span>
                </div>
                <h3 id="stat-waste" class="text-5xl font-black text-secondary headline tracking-tighter">0 <span class="text-xl">kg</span></h3>
                <p class="text-xs text-on-surface-variant font-medium mt-4">Berat aktual terverifikasi</p>
            </div>

            <div class="bg-white p-8 rounded-[2rem] border border-primary/5 shadow-xl shadow-primary/5">
                <div class="flex justify-between items-center mb-6">
                    <span class="w-12 h-12 rounded-2xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">payments</span>
                    </span>
                    <span class="text-xs font-black text-outline uppercase tracking-widest">Total Payout</span>
                </div>
                <h3 id="stat-payout" class="text-4xl font-black text-primary headline tracking-tighter">IDR 0</h3>
                <p class="text-xs text-on-surface-variant font-medium mt-4">Total dana cair ke member</p>
            </div>
        </section>

        <!-- Transaction Queue -->
        <section class="space-y-8">
            <div class="flex justify-between items-end">
                <div>
                    <h2 class="text-3xl font-black text-primary headline tracking-tight">Menunggu Verifikasi</h2>
                    <p class="text-sm text-on-surface-variant font-medium">Antrian penjemputan sampah warga.</p>
                </div>
                <button onclick="fetchAdminData()" class="flex items-center gap-2 text-xs font-bold text-primary uppercase tracking-widest border-b border-primary/20 pb-1 hover:border-primary">
                    <span class="material-symbols-outlined text-[16px]">refresh</span> Refresh Antrian
                </button>
            </div>

            <div class="bg-white rounded-[2.5rem] border border-primary/5 shadow-2xl overflow-hidden">
                <div class="overflow-x-auto">
                    <table class="w-full text-left">
                        <thead>
                            <tr class="bg-surface-container-low text-[10px] font-black uppercase tracking-[0.2em] text-outline">
                                <th class="px-8 py-6">ID Transaksi</th>
                                <th class="px-8 py-6">Member</th>
                                <th class="px-8 py-6">Kategori</th>
                                <th class="px-8 py-6 text-center">Estimasi (kg)</th>
                                <th class="px-8 py-6">Waktu Request</th>
                                <th class="px-8 py-6 text-right">Aksi</th>
                            </tr>
                        </thead>
                        <tbody id="admin-pending-table" class="divide-y divide-primary/5">
                            <!-- JS Rendered -->
                            <tr>
                                <td colspan="6" class="px-8 py-20 text-center text-outline italic">Memuat data antrian...</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </section>
    </main>
</div>

<!-- Modal Verifikasi -->
<div id="verify-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-10 shadow-2xl">
        <h3 class="text-2xl font-black text-primary headline tracking-tight mb-2">Verifikasi Sampah</h3>
        <p class="text-sm text-on-surface-variant mb-8 font-medium">Masukkan berat aktual yang timbangan catat.</p>
        
        <form id="verify-form" class="space-y-6">
            <input type="hidden" id="verify-id" name="transaction_id">
            <div>
                 <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Pilih Aksi</label>
                 <select id="verify-status" name="status" class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                     <option value="VERIFIED">VERIFIED (Diterima)</option>
                     <option value="REJECTED">REJECTED (Ditolak)</option>
                 </select>
            </div>
            <div id="weight-input-container">
                <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Berat Aktual (kg)</label>
                <input type="number" step="0.01" id="weight_actual" name="weight_actual" required 
                       class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary text-2xl font-black text-primary">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeVerifyModal()" class="flex-1 py-4 font-bold text-outline hover:text-primary transition-all">Batal</button>
                <button type="submit" class="flex-1 bg-primary text-white py-4 font-bold rounded-2xl shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
async function fetchAdminData() {
    try {
        const response = await fetch('../api/get_admin_stats.php');
        const result = await response.json();

        if (result.status === 'success') {
            document.getElementById('stat-users').innerText = result.stats.total_users;
            document.getElementById('stat-waste').innerHTML = `${result.stats.total_waste_kg} <span class="text-xl">kg</span>`;
            document.getElementById('stat-payout').innerText = `IDR ${new Intl.NumberFormat('id-ID').format(result.stats.total_payout)}`;

            renderPendingQueue(result.pending);
        }
    } catch (err) {
        console.error('Error:', err);
    }
}

function renderPendingQueue(pending) {
    const table = document.getElementById('admin-pending-table');
    if (pending.length === 0) {
        table.innerHTML = '<tr><td colspan="6" class="px-8 py-20 text-center text-outline italic">Tidak ada antrian tertunda. Semuanya bersih!</td></tr>';
        return;
    }

    table.innerHTML = pending.map(item => `
        <tr class="hover:bg-primary/5 transition-colors group">
            <td class="px-8 py-6 font-bold text-xs text-primary">#TR-${item.id}</td>
            <td class="px-8 py-6">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-[10px] font-bold text-primary">
                        ${item.user_name.charAt(0)}
                    </div>
                    <span class="text-xs font-bold text-on-surface">${item.user_name}</span>
                </div>
            </td>
            <td class="px-8 py-6">
                <span class="px-3 py-1 bg-surface-container text-[10px] font-bold text-outline rounded-full">${item.category_name}</span>
            </td>
            <td class="px-8 py-6 text-center font-black text-xs text-on-surface">${item.weight_est} kg</td>
            <td class="px-8 py-6 text-[11px] text-on-surface-variant font-medium">
                ${new Date(item.created_at).toLocaleDateString('id-ID', {day:'2-digit', month:'short', hour:'2-digit', minute:'2-digit'})}
            </td>
            <td class="px-8 py-6 text-right">
                <button onclick="openVerifyModal(${item.id}, ${item.weight_est})" class="bg-primary text-white text-[10px] font-black uppercase tracking-widest px-6 py-2 rounded-xl shadow-lg shadow-primary/10 hover:shadow-primary/30 transition-all">
                    Verify
                </button>
            </td>
        </tr>
    `).join('');
}

function openVerifyModal(id, estWeight) {
    document.getElementById('verify-id').value = id;
    document.getElementById('weight_actual').value = estWeight;
    document.getElementById('verify-modal').classList.remove('hidden');
}

function closeVerifyModal() {
    document.getElementById('verify-modal').classList.add('hidden');
}

document.getElementById('verify-status').addEventListener('change', (e) => {
    document.getElementById('weight-input-container').style.display = e.target.value === 'REJECTED' ? 'none' : 'block';
});

document.getElementById('verify-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());

    try {
        const response = await fetch('../api/verify_transaction.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        if (result.status === 'success') {
            closeVerifyModal();
            fetchAdminData();
        } else {
            alert(result.message);
        }
    } catch (err) {
        console.error(err);
        alert('Gagal memproses verifikasi.');
    }
});

// Initial Load
document.addEventListener('DOMContentLoaded', fetchAdminData);
</script>

<?php include '../includes/footer.php'; ?>
