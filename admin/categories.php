<?php
$hide_nav = true;
include '../includes/header.php';
include 'sidebar.php';
?>

<div class="ml-64 bg-surface min-h-screen pb-20">
    <!-- Header -->
    <header class="bg-white px-8 py-6 flex justify-between items-center border-b border-primary/5 shadow-sm sticky top-0 z-50">
        <div>
            <h1 class="text-xl font-black text-primary headline tracking-tight leading-none">Manajemen Produk & Kategori</h1>
            <p class="text-[10px] font-bold text-outline uppercase tracking-widest mt-1">Kelola data sampah dan harga beli</p>
        </div>
        <button onclick="openModal()" class="bg-primary text-white text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-xl shadow-lg shadow-primary/20 hover:scale-105 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-[16px]">add</span> Tambah Kategori
        </button>
    </header>

    <main class="max-w-7xl mx-auto px-8 py-10">
        <div class="bg-white rounded-[2.5rem] border border-primary/5 shadow-2xl overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low text-[10px] font-black uppercase tracking-[0.2em] text-outline">
                            <th class="px-8 py-6">Kategori</th>
                            <th class="px-8 py-6">Harga / kg</th>
                            <th class="px-8 py-6">Status</th>
                            <th class="px-8 py-6 text-right">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="category-table" class="divide-y divide-primary/5">
                        <tr>
                            <td colspan="4" class="px-8 py-20 text-center text-outline italic">Memuat data...</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </main>
</div>

<!-- Modal Form -->
<div id="form-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] p-10 shadow-2xl overflow-y-auto max-h-[90vh]">
        <h3 id="modal-title" class="text-2xl font-black text-primary headline tracking-tight mb-2">Tambah Kategori</h3>
        <p class="text-sm text-on-surface-variant mb-8 font-medium">Lengkapi detail kategori sampah di bawah ini.</p>
        
        <form id="category-form" class="space-y-6">
            <input type="hidden" id="category-id" name="id">
            
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Nama Kategori</label>
                    <input type="text" id="name" name="name" required onkeyup="generateSlug()"
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Slug (URL)</label>
                    <input type="text" id="slug" name="slug" required readonly
                           class="w-full bg-surface-container/50 border-none rounded-xl px-4 py-4 font-bold text-outline cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Harga (IDR/kg)</label>
                    <input type="number" id="price" name="price_per_kg" required
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Icon (Material Symbol)</label>
                    <input type="text" id="icon" name="icon" placeholder="recycling"
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                </div>
            </div>

            <div>
                <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Deskripsi</label>
                <textarea id="description" name="description" rows="3"
                          class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-medium"></textarea>
            </div>

            <div class="flex items-center gap-3">
                <input type="checkbox" id="popular" name="is_popular" class="w-5 h-5 rounded border-primary/20 text-primary focus:ring-primary">
                <label for="popular" class="text-sm font-bold text-on-surface">Tampilkan sebagai kategori populer</label>
            </div>

            <div class="flex gap-4 pt-4">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 font-bold text-outline hover:text-primary transition-all">Batal</button>
                <button type="submit" class="flex-1 bg-primary text-white py-4 font-bold rounded-2xl shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
let categories = [];

function generateSlug() {
    const name = document.getElementById('name').value;
    const slug = name.toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
    document.getElementById('slug').value = slug;
}

async function fetchCategories() {
    const res = await fetch('../api/manage_admin.php?entity=categories');
    const result = await res.json();
    if (result.status === 'success') {
        categories = result.data;
        renderTable();
    }
}

function renderTable() {
    const tbody = document.getElementById('category-table');
    if (categories.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="px-8 py-20 text-center text-outline italic">Belum ada kategori.</td></tr>';
        return;
    }

    tbody.innerHTML = categories.map(cat => `
        <tr class="hover:bg-primary/5 transition-colors">
            <td class="px-8 py-6">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center text-primary">
                        <span class="material-symbols-outlined">${cat.icon || 'recycling'}</span>
                    </div>
                    <div>
                        <p class="font-black text-primary text-sm">${cat.name}</p>
                        <p class="text-[10px] text-outline font-medium truncate max-w-[200px]">${cat.description || '-'}</p>
                    </div>
                </div>
            </td>
            <td class="px-8 py-6 font-black text-sm text-on-surface">
                IDR ${new Intl.NumberFormat('id-ID').format(cat.price_per_kg)}
            </td>
            <td class="px-8 py-6">
                ${cat.is_popular ? '<span class="px-3 py-1 bg-secondary/10 text-secondary text-[10px] font-bold rounded-full">POPULER</span>' : '<span class="text-outline text-[10px]">Regular</span>'}
            </td>
            <td class="px-8 py-6 text-right">
                <div class="flex justify-end gap-2">
                    <button onclick="editCategory(${cat.id})" class="w-8 h-8 rounded-lg bg-surface-container flex items-center justify-center text-outline hover:text-primary transition-all">
                        <span class="material-symbols-outlined text-[18px]">edit</span>
                    </button>
                    <button onclick="deleteCategory(${cat.id})" class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center text-red-400 hover:text-red-600 transition-all">
                        <span class="material-symbols-outlined text-[18px]">delete</span>
                    </button>
                </div>
            </td>
        </tr>
    `).join('');
}

function openModal(id = null) {
    const form = document.getElementById('category-form');
    form.reset();
    document.getElementById('category-id').value = '';
    document.getElementById('modal-title').innerText = 'Tambah Kategori';
    document.getElementById('form-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('form-modal').classList.add('hidden');
}

function editCategory(id) {
    const cat = categories.find(c => c.id == id);
    if (!cat) return;

    document.getElementById('category-id').value = cat.id;
    document.getElementById('name').value = cat.name;
    document.getElementById('slug').value = cat.slug;
    document.getElementById('price').value = cat.price_per_kg;
    document.getElementById('icon').value = cat.icon;
    document.getElementById('description').value = cat.description;
    document.getElementById('popular').checked = parseInt(cat.is_popular) === 1;

    document.getElementById('modal-title').innerText = 'Edit Kategori';
    document.getElementById('form-modal').classList.remove('hidden');
}

async function deleteCategory(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus kategori ini? Semua data transaksi terkait mungkin akan terpengaruh.')) return;

    try {
        const res = await fetch('../api/manage_admin.php?entity=categories&action=delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        const result = await res.json();
        if (result.status === 'success') fetchCategories();
        else alert(result.message);
    } catch (err) {
        console.error(err);
    }
}

document.getElementById('category-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    data.entity = 'categories';
    data.is_popular = document.getElementById('popular').checked;

    try {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await res.json();
        if (result.status === 'success') {
            closeModal();
            fetchCategories();
        } else {
            alert(result.message);
        }
    } catch (err) {
        console.error(err);
    }
});

// Initial load
document.addEventListener('DOMContentLoaded', fetchCategories);
</script>

<?php include '../includes/footer.php'; ?>
