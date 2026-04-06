<?php
$hide_nav = true;
include '../includes/header.php';
include 'sidebar.php';
?>

<div class="md:ml-64 transition-all duration-300 w-full md:w-auto bg-surface min-h-screen pb-20">
    <!-- Header -->
    <header class="bg-white px-4 md:px-8 py-4 md:py-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-primary/5 shadow-sm sticky top-0 z-50">
        <div>
            <h1 class="text-lg md:text-xl font-black text-primary headline tracking-tight leading-none">Layanan Eco-System</h1>
            <p class="text-xs font-bold text-outline uppercase tracking-widest mt-1">Kelola program dan jasa penjemputan</p>
        </div>
        <button onclick="openModal()" class="bg-primary text-white text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-xl shadow-lg shadow-primary/20 hover:scale-105 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-[16px]">add_circle</span> Tambah Layanan
        </button>
    </header>

    <main class="max-w-7xl mx-auto px-4 md:px-8 py-6 md:py-10">
        <div class="bg-white rounded-[2.5rem] border border-primary/5 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low text-xs font-black uppercase tracking-[0.2em] text-outline">
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">Layanan</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-center">Tipe</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">Status</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="service-table" class="divide-y divide-primary/5">
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center text-outline italic">Memuat data layanan...</td>
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
        <h3 id="modal-title" class="text-lg md:text-2xl font-black text-primary headline tracking-tight mb-2">Tambah Layanan</h3>
        <p class="text-sm text-on-surface-variant mb-8 font-medium">Informasi detail mengenai layanan baru.</p>
        
        <form id="service-form" class="space-y-6">
            <input type="hidden" id="service-id" name="id">
            
            <div>
                <label class="block text-xs font-bold text-outline uppercase tracking-widest mb-2">Nama Layanan</label>
                <input type="text" id="name" name="name" required 
                       class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
            </div>

            <div>
                <label class="block text-xs font-bold text-outline uppercase tracking-widest mb-2">Tipe Layanan</label>
                <input type="text" id="type" name="type" required placeholder="Contoh: INFO, PICKUP, EDUKASI..." 
                       class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold uppercase">
            </div>

            <div>
                <label class="block text-xs font-bold text-outline uppercase tracking-widest mb-2">Deskripsi Singkat</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-medium text-base"></textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="is_active" name="is_active" class="w-5 h-5 rounded border-primary/20 text-primary focus:ring-primary">
                <label for="is_active" class="text-sm font-bold text-on-surface">Layanan Aktif</label>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 font-bold text-outline hover:text-primary transition-all">Batal</button>
                <button type="submit" class="flex-1 bg-primary text-white py-4 font-bold rounded-2xl shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
let services = [];

async function fetchServices() {
    const res = await fetch('../api/manage_admin.php?entity=services');
    const result = await res.json();
    if (result.status === 'success') {
        services = result.data;
        renderTable();
    }
}

function renderTable() {
    const tbody = document.getElementById('service-table');
    if (services.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="px-8 py-20 text-center text-outline italic">Belum ada layanan terdaftar.</td></tr>';
        return;
    }

    tbody.innerHTML = services.map(srv => `
        <tr class="hover:bg-primary/5 transition-colors">
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">
                <p class="font-black text-primary text-sm">${srv.name}</p>
                <p class="text-xs text-outline font-medium max-w-xs truncate">${srv.description || '-'}</p>
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-center">
                <span class="px-3 py-1 bg-surface-container text-xs font-black text-outline rounded-full uppercase tracking-tighter">${srv.type}</span>
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">
                ${srv.is_active ? 
                    '<span class="flex items-center gap-2 text-xs font-bold text-green-600"><span class="w-2 h-2 rounded-full bg-green-500 animate-pulse"></span> Aktif</span>' : 
                    '<span class="flex items-center gap-2 text-xs font-bold text-outline"><span class="w-2 h-2 rounded-full bg-outline/30"></span> Nonaktif</span>'}
            </td>
            <td class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-right">
                <div class="flex justify-end gap-2">
                    <button onclick="editService(${srv.id})" class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-outline hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[18px]">edit_square</span>
                    </button>
                    <button onclick="deleteService(${srv.id})" class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-400 hover:text-red-600 transition-all">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function openModal() {
    const form = document.getElementById('service-form');
    form.reset();
    document.getElementById('service-id').value = '';
    document.getElementById('modal-title').innerText = 'Tambah Layanan';
    document.getElementById('form-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('form-modal').classList.add('hidden');
}

function editService(id) {
    const srv = services.find(s => s.id == id);
    if (!srv) return;

    document.getElementById('service-id').value = srv.id;
    document.getElementById('name').value = srv.name;
    document.getElementById('type').value = srv.type;
    document.getElementById('description').value = srv.description;
    document.getElementById('is_active').checked = parseInt(srv.is_active) === 1;

    document.getElementById('modal-title').innerText = 'Edit Layanan';
    document.getElementById('form-modal').classList.remove('hidden');
}

async function deleteService(id) {
    if (!confirm('Hapus layanan ini secara permanen?')) return;

    try {
        const res = await fetch('../api/manage_admin.php?entity=services&action=delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        const result = await res.json();
        if (result.status === 'success') fetchServices();
    } catch (err) {
        console.error(err);
    }
}

document.getElementById('service-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    data.entity = 'services';
    data.is_active = document.getElementById('is_active').checked;

    try {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await res.json();
        if (result.status === 'success') {
            closeModal();
            fetchServices();
        }
    } catch (err) {
        console.error(err);
    }
});

// Load initial data
document.addEventListener('DOMContentLoaded', fetchServices);
</script>

<?php include '../includes/footer.php'; ?>
