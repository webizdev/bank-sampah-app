<?php
$hide_nav = true;
include '../includes/header.php';
include 'sidebar.php';
?>

<div class="ml-64 bg-surface min-h-screen pb-20">
    <!-- Header -->
    <header class="bg-white px-8 py-6 flex justify-between items-center border-b border-primary/5 shadow-sm sticky top-0 z-50">
        <div>
            <h1 class="text-xl font-black text-primary headline tracking-tight leading-none">Manajemen Produk</h1>
            <p class="text-[10px] font-bold text-outline uppercase tracking-widest mt-1">Kelola data sampah dan harga beli</p>
        </div>
        <button onclick="openModal()" class="bg-primary text-white text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-xl shadow-lg shadow-primary/20 hover:scale-105 transition-all flex items-center gap-2">
            <span class="material-symbols-outlined text-[16px]">add</span> Tambah Data
        </button>
    </header>

    <main class="max-w-7xl mx-auto px-8 py-10 space-y-6">
        
        <!-- Category Pills -->
        <div class="flex flex-col gap-2">
            <p class="text-[10px] font-bold text-outline uppercase tracking-widest">Filter Kategori :</p>
            <div id="category-pills" class="flex flex-wrap items-center gap-3">
                <div class="px-6 py-2 rounded-full bg-surface-container text-outline text-[10px] font-bold italic animate-pulse">Memuat kategori...</div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-primary/5 shadow-2xl overflow-hidden mt-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low text-[10px] font-black uppercase tracking-[0.2em] text-outline">
                            <th class="px-8 py-6">Produk</th>
                            <th class="px-8 py-6">Kategori</th>
                            <th class="px-8 py-6">Harga / kg</th>
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
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Jenis Data</label>
                    <select id="parent_id" name="parent_id" onchange="togglePriceInput()"
                            class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                        <option value="">-- Tanpa Parent (Ini Kategori) --</option>
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Nama Kategori / Produk</label>
                    <input type="text" id="name" name="name" required onkeyup="generateSlug()"
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                </div>
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Slug (URL)</label>
                    <input type="text" id="slug" name="slug" required readonly
                           class="w-full bg-surface-container/50 border-none rounded-xl px-4 py-4 font-bold text-outline cursor-not-allowed">
                </div>
                <div id="price-group">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Harga (IDR/kg)</label>
                    <input type="number" id="price" name="price_per_kg" required
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Icon (Optional)</label>
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
let currentCategoryFilter = 'all';
function generateSlug() {
    const name = document.getElementById('name').value;
    const slug = name.toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
    document.getElementById('slug').value = slug;
}

async function fetchCategories() {
    const res = await fetch('../api/get_categories.php');
    const result = await res.json();
    if (result.status === 'success') {
        categories = result.all;
        renderPills();
        renderTable();
        updateParentDropdown();
    }
}

function updateParentDropdown() {
    const parentSelect = document.getElementById('parent_id');
    const mainCats = categories.filter(c => !c.parent_id);
    parentSelect.innerHTML = '<option value="">-- Tanpa Parent (Ini Kategori) --</option>' + 
        mainCats.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
}

function togglePriceInput() {
    const parentId = document.getElementById('parent_id').value;
    const priceGroup = document.getElementById('price-group');
    if (parentId) {
        priceGroup.classList.remove('opacity-30', 'pointer-events-none');
        document.getElementById('price').required = true;
    } else {
        priceGroup.classList.add('opacity-30', 'pointer-events-none');
        document.getElementById('price').required = false;
        document.getElementById('price').value = 0;
    }
}

function renderPills() {
    const mainCats = categories.filter(c => !c.parent_id);
    let html = `
        <button onclick="filterCategory('all')" class="px-6 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest transition-all ${currentCategoryFilter === 'all' ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-surface-container hover:bg-primary/5 text-outline'}">
            Semua Produk
        </button>
    `;
    mainCats.forEach(cat => {
        const isActive = currentCategoryFilter == cat.id;
        html += `
            <div class="flex items-center gap-0.5 group">
                <button onclick="filterCategory(${cat.id})" class="px-6 py-2 rounded-l-full text-[10px] font-bold uppercase tracking-widest transition-all ${isActive ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-surface-container hover:bg-primary/5 text-outline'} flex items-center gap-1.5 h-full">
                    ${cat.icon ? `<span class="material-symbols-outlined text-[14px] leading-none">${cat.icon}</span>` : ''} 
                    <span class="leading-none mt-0.5">${cat.name}</span>
                </button>
                <div class="flex flex-col gap-px h-full">
                    <button onclick="editCategory(${cat.id})" class="flex-1 px-2 rounded-tr-lg text-outline hover:bg-primary/10 hover:text-primary bg-surface-container transition-all flex items-center justify-center">
                        <span class="material-symbols-outlined text-[10px]">edit</span>
                    </button>
                    <button onclick="deleteCategory(${cat.id})" class="flex-1 px-2 rounded-br-lg text-red-300 hover:bg-red-50 hover:text-red-500 bg-surface-container transition-all flex items-center justify-center">
                        <span class="material-symbols-outlined text-[10px]">delete</span>
                    </button>
                </div>
            </div>
        `;
    });
    document.getElementById('category-pills').innerHTML = html;
}

function filterCategory(id) {
    currentCategoryFilter = id;
    renderPills();
    renderTable();
}

function renderTable() {
    const tbody = document.getElementById('category-table');
    const mainCats = categories.filter(c => !c.parent_id);
    const allProducts = categories.filter(c => c.parent_id);

    const orphans = allProducts.filter(p => !mainCats.find(c => c.id == p.parent_id));

    let filteredProducts = [];
    if (currentCategoryFilter === 'all') {
        filteredProducts = allProducts;
    } else {
        filteredProducts = allProducts.filter(p => p.parent_id == currentCategoryFilter);
    }

    if (filteredProducts.length === 0 && (currentCategoryFilter !== 'all' || orphans.length === 0)) {
        tbody.innerHTML = '<tr><td colspan="4" class="px-8 py-20 text-center text-outline italic">Belum ada data produk di kategori ini.</td></tr>';
        return;
    }

    let html = '';

    filteredProducts.forEach(prod => {
        const parent = mainCats.find(c => c.id == prod.parent_id);
        const parentName = parent ? parent.name : 'Unknown';
        
        html += `
            <tr class="hover:bg-primary/[0.02] transition-colors">
                <td class="px-8 py-4">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary">
                            <span class="material-symbols-outlined text-[20px]">inventory_2</span>
                        </div>
                        <div>
                            <p class="font-bold text-on-surface text-sm">${prod.name}</p>
                            <p class="text-[10px] text-outline truncate max-w-[200px]">${prod.description || '-'}</p>
                        </div>
                    </div>
                </td>
                <td class="px-8 py-4">
                    <span class="px-3 py-1.5 bg-surface-container-high rounded-lg text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">${parentName}</span>
                    ${prod.is_popular ? '<span class="px-3 py-1.5 bg-secondary/10 text-secondary text-[10px] font-bold rounded-lg ml-1 uppercase tracking-widest">POPULER</span>' : ''}
                </td>
                <td class="px-8 py-4 font-black text-sm text-primary">
                    IDR ${new Intl.NumberFormat('id-ID').format(prod.price_per_kg)}
                </td>
                <td class="px-8 py-4 text-right">
                    <div class="flex justify-end gap-2">
                        <button onclick="editCategory(${prod.id})" class="w-8 h-8 rounded-lg bg-white border border-primary/10 flex items-center justify-center text-outline hover:text-primary hover:border-primary/30 transition-all">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                        </button>
                        <button onclick="deleteCategory(${prod.id})" class="w-8 h-8 rounded-lg bg-white border border-red-50 flex items-center justify-center text-red-300 hover:text-red-500 hover:border-red-200 transition-all">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });

    if (currentCategoryFilter === 'all' && orphans.length > 0) {
        html += `<tr class="bg-red-50/50"><td colspan="4" class="px-8 py-3 text-[10px] font-bold text-red-500 uppercase tracking-widest">Produk Tanpa Kategori</td></tr>`;
        orphans.forEach(prod => {
             html += `
                <tr class="hover:bg-red-50 transition-colors">
                    <td class="px-8 py-4">
                        <div class="flex items-center gap-4">
                            <div class="w-10 h-10 rounded-xl bg-red-100/50 text-red-400 flex items-center justify-center">
                                <span class="material-symbols-outlined text-[20px]">warning</span>
                            </div>
                            <div>
                                <p class="font-bold text-red-500 text-sm">${prod.name}</p>
                                <p class="text-[10px] text-red-400/70 truncate max-w-[200px]">${prod.description || '-'}</p>
                            </div>
                        </div>
                    </td>
                    <td class="px-8 py-4"><span class="px-3 py-1.5 bg-red-100 text-red-500 rounded-lg text-[10px] font-bold uppercase tracking-widest">Orphan</span></td>
                    <td class="px-8 py-4 font-black text-sm text-red-500">IDR ${new Intl.NumberFormat('id-ID').format(prod.price_per_kg)}</td>
                    <td class="px-8 py-4 text-right">
                        <div class="flex justify-end gap-2">
                            <button onclick="editCategory(${prod.id})" class="w-8 h-8 rounded-lg bg-white border border-red-100 flex items-center justify-center text-red-400 hover:text-red-500"><span class="material-symbols-outlined text-[16px]">edit</span></button>
                            <button onclick="deleteCategory(${prod.id})" class="w-8 h-8 rounded-lg bg-white border border-red-100 flex items-center justify-center text-red-400 hover:text-red-600"><span class="material-symbols-outlined text-[16px]">delete</span></button>
                        </div>
                    </td>
                </tr>
            `;
        });
    }

    tbody.innerHTML = html;
}

function openModal(id = null) {
    const form = document.getElementById('category-form');
    form.reset();
    document.getElementById('category-id').value = '';
    document.getElementById('modal-title').innerText = 'Tambah Data';
    document.getElementById('form-modal').classList.remove('hidden');
    updateParentDropdown();
    togglePriceInput();
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
    document.getElementById('parent_id').value = cat.parent_id || '';
    document.getElementById('price').value = cat.price_per_kg;
    document.getElementById('icon').value = cat.icon;
    document.getElementById('description').value = cat.description;
    document.getElementById('popular').checked = parseInt(cat.is_popular) === 1;

    document.getElementById('modal-title').innerText = 'Edit Data';
    document.getElementById('form-modal').classList.remove('hidden');
    togglePriceInput();
}

async function deleteCategory(id) {
    if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;

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
