<?php
$hide_nav = true;
include '../includes/header.php';
include 'sidebar.php';
?>

<div class="md:ml-64 transition-all duration-300 w-full md:w-auto bg-surface min-h-screen pb-20">
    <!-- Header -->
    <header class="bg-white px-4 md:px-8 py-4 md:py-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-primary/5 shadow-sm sticky top-0 z-50">
        <div>
            <h1 class="text-lg md:text-xl font-black text-primary headline tracking-tight leading-none">Database Member</h1>
            <p class="text-xs font-bold text-outline uppercase tracking-widest mt-1">Kelola profil, role, dan saldo warga</p>
        </div>
        <div class="flex items-center gap-4">
             <button onclick="openModal()" class="bg-primary text-white text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-xl shadow-lg shadow-primary/20 hover:scale-105 transition-all flex items-center gap-2">
                 <span class="material-symbols-outlined text-[16px]">person_add</span> Tambah Member
             </button>
             <div class="relative">
                <span class="material-symbols-outlined absolute left-4 top-1/2 -translate-y-1/2 text-outline text-[18px]">search</span>
                <input type="text" id="user-search" onkeyup="filterUsers()" placeholder="Cari nama atau whatsapp..." 
                        class="bg-surface-container border-none rounded-xl pl-12 pr-4 py-3 text-sm font-bold focus:ring-2 focus:ring-primary w-64 transition-all">
             </div>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 md:px-8 py-6 md:py-10">
        <div class="bg-white rounded-[2.5rem] border border-primary/5 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low text-xs font-black uppercase tracking-[0.2em] text-outline">
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">Member</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">Role & Tier</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-center">Kontribusi</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">Saldo (IDR)</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="user-table" class="divide-y divide-primary/5">
                        <tr>
                            <td colspan="5" class="px-8 py-20 text-center text-outline italic">Memuat data member...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Modal Form -->
<div id="form-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] p-10 shadow-2xl">
        <h3 id="modal-title" class="text-lg md:text-2xl font-black text-primary headline tracking-tight mb-2">Edit Member</h3>
        <p class="text-sm text-on-surface-variant mb-8 font-medium">Perbarui data profil dan hak akses user.</p>
        
        <form id="user-form" class="space-y-6">
            <input type="hidden" id="user-id" name="id">
            
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-outline uppercase tracking-widest mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name" required 
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                </div>
                <div class="col-span-2">
                    <label class="block text-xs font-bold text-outline uppercase tracking-widest mb-2">WhatsApp</label>
                    <input type="text" id="whatsapp" name="whatsapp" required
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                </div>
                <div>
                    <label class="block text-xs font-bold text-outline uppercase tracking-widest mb-2">Role</label>
                    <select id="role" name="role" class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                        <option value="USER">USER (Warga)</option>
                        <option value="ADMIN">ADMIN (Staf)</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-outline uppercase tracking-widest mb-2">User Tier</label>
                    <select id="tier" name="tier" class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                        <option value="Bronze">Bronze</option>
                        <option value="Silver">Silver</option>
                        <option value="Gold">Gold</option>
                    </select>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-primary/5">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 font-bold text-outline hover:text-primary transition-all">Batal</button>
                <button type="submit" class="flex-1 bg-primary text-white py-4 font-bold rounded-2xl shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">Simpan Perubahan</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Saldo -->
<div id="balance-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[110] hidden flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-sm rounded-[2.5rem] p-10 shadow-2xl">
        <h3 class="text-lg md:text-2xl font-black text-primary headline tracking-tight mb-2">Koreksi Saldo</h3>
        <p class="text-sm text-on-surface-variant mb-8 font-medium">Sesuaikan saldo member jika diperlukan.</p>
        
        <form id="balance-form" class="space-y-6">
            <input type="hidden" id="balance-user-id" name="id">
            <div>
                <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Saldo Sekarang (IDR)</label>
                <input type="number" id="balance-input" name="balance" required
                       class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary text-lg md:text-2xl font-black text-primary">
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeBalanceModal()" class="flex-1 py-4 font-bold text-outline">Batal</button>
                <button type="submit" class="flex-1 bg-secondary text-white py-4 font-bold rounded-2xl shadow-xl shadow-secondary/20 transition-all">Update Saldo</button>
            </div>
        </form>
    </div>
</div>

<script>
let users = [];

async function fetchUsers() {
    const res = await fetch('../api/manage_admin.php?entity=users');
    const result = await res.json();
    if (result.status === 'success') {
        users = result.data;
        renderTable(users);
    }
}

function renderTable(dataList) {
    const tbody = document.getElementById('user-table');
    if (dataList.length === 0) {
        tbody.innerHTML = '<tr><td colspan="5" class="px-8 py-20 text-center text-outline italic">Tidak ada member ditemukan.</td></tr>';
        return;
    }

    tbody.innerHTML = dataList.map(u => `
        <tr class="hover:bg-primary/5 transition-colors group">
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center overflow-hidden border border-primary/5">
                         <img src="https://ui-avatars.com/api/?name=${encodeURIComponent(u.name)}&background=0f5238&color=fff" class="w-full h-full object-cover">
                    </div>
                    <div>
                        <p class="font-black text-primary text-sm">${u.name}</p>
                        <p class="text-xs text-outline font-medium">WA: ${u.whatsapp || '-'}</p>
                    </div>
                </div>
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">
                <div class="flex flex-col gap-1">
                    <span class="text-xs font-black ${u.role === 'ADMIN' ? 'text-primary' : 'text-outline'} uppercase tracking-widest">${u.role}</span>
                    <span class="text-xs font-bold text-secondary">${u.tier} Tier</span>
                </div>
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-center">
                <p class="text-sm font-black text-on-surface">${u.total_kg} <span class="text-[9px] text-outline uppercase tracking-wider">kg</span></p>
                <p class="text-[10px] text-outline font-medium">Terverifikasi</p>
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">
                <p class="text-sm font-black text-primary">IDR ${new Intl.NumberFormat('id-ID').format(u.balance)}</p>
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-right">
                <div class="flex justify-end gap-2">
                    <button onclick="openBalanceModal(${u.id}, ${u.balance})" class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center text-primary hover:bg-primary hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[18px]">account_balance_wallet</span>
                    </button>
                    <button onclick="editUser(${u.id})" class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-outline hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                    </button>
                    <button onclick="deleteUser(${u.id})" class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-400 hover:text-red-600 transition-all">
                        <span class="material-symbols-outlined text-[18px]">person_remove</span>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function filterUsers() {
    const q = document.getElementById('user-search').value.toLowerCase();
    const filtered = users.filter(u => u.name.toLowerCase().includes(q) || (u.whatsapp && u.whatsapp.toLowerCase().includes(q)));
    renderTable(filtered);
}

function openModal() {
    document.getElementById('user-form').reset();
    document.getElementById('user-id').value = '';
    document.getElementById('modal-title').innerText = 'Tambah Member Baru';
    document.getElementById('form-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('form-modal').classList.add('hidden');
}

function closeBalanceModal() {
    document.getElementById('balance-modal').classList.add('hidden');
}

function editUser(id) {
    const u = users.find(user => user.id == id);
    if (!u) return;
    
    document.getElementById('user-id').value = u.id;
    document.getElementById('name').value = u.name;
    document.getElementById('whatsapp').value = u.whatsapp || '';
    document.getElementById('role').value = u.role;
    document.getElementById('tier').value = u.tier;
    
    document.getElementById('modal-title').innerText = 'Edit Member';
    document.getElementById('form-modal').classList.remove('hidden');
}

function openBalanceModal(id, currentBalance) {
    document.getElementById('balance-user-id').value = id;
    document.getElementById('balance-input').value = currentBalance;
    document.getElementById('balance-modal').classList.remove('hidden');
}

async function deleteUser(id) {
    if (!confirm('HAPUS USER? Tindakan ini permanen and akan menghapus semua riwayat transaksi user tersebut.')) return;
    
    try {
        const res = await fetch('../api/manage_admin.php?entity=users&action=delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        const result = await res.json();
        if (result.status === 'success') fetchUsers();
    } catch (err) { console.error(err); }
}

document.getElementById('user-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    data.entity = 'users';

    try {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await res.json();
        if (result.status === 'success') {
            closeModal();
            fetchUsers();
            alert('✔ Berhasil menyimpan data member!');
        } else {
            alert('❌ ' + (result.message || 'Gagal menyimpan data member.'));
        }
    } catch (err) { console.error(err); }
});

document.getElementById('balance-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    data.entity = 'users';
    data.action = 'update_balance';

    try {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        if ((await res.json()).status === 'success') {
            closeBalanceModal();
            fetchUsers();
        }
    } catch (err) { console.error(err); }
});

// Load initial data
document.addEventListener('DOMContentLoaded', fetchUsers);
</script>

<?php include '../includes/footer.php'; ?>
