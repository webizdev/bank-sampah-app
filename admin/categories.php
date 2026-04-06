<?php
$hide_nav = true;
include '../includes/header.php';
include 'sidebar.php';
?>

<div class="md:ml-64 transition-all duration-300 w-full md:w-auto bg-surface min-h-screen pb-20">
    <!-- Header -->
    <header class="bg-white px-4 md:px-8 py-4 md:py-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-primary/5 shadow-sm sticky top-0 z-50">
        <div>
            <h1 class="text-lg md:text-xl font-black text-primary headline tracking-tight leading-none">Manajemen Produk</h1>
            <p class="text-[9px] md:text-[10px] font-bold text-outline uppercase tracking-widest mt-1">Kelola data sampah dan harga beli</p>
        </div>
        <div class="flex gap-3">
            <button onclick="openModal('category')" class="bg-surface-container text-primary text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-xl shadow-lg hover:bg-primary/5 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">category</span> Tambah Kategori
            </button>
            <button onclick="openModal('product')" class="bg-primary text-white text-[10px] font-black uppercase tracking-widest px-6 py-3 rounded-xl shadow-lg shadow-primary/20 hover:scale-105 transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px]">add</span> Tambah Produk
            </button>
        </div>
    </header>

    <main class="max-w-7xl mx-auto px-4 md:px-8 py-6 md:py-10 space-y-6">
        
        <!-- Category Pills -->
        <div class="flex flex-col gap-2">
            <p class="text-[9px] md:text-[10px] font-bold text-outline uppercase tracking-widest">Filter Kategori :</p>
            <div id="category-pills" class="flex flex-wrap items-center gap-3">
                <div class="px-6 py-2 rounded-full bg-surface-container text-outline text-[10px] font-bold italic animate-pulse">Memuat kategori...</div>
            </div>
        </div>

        <div class="bg-white rounded-[2.5rem] border border-primary/5 shadow-2xl overflow-hidden mt-6">
            <div class="overflow-x-auto">
                <table class="w-full text-left">
                    <thead>
                        <tr class="bg-surface-container-low text-[10px] font-black uppercase tracking-[0.2em] text-outline">
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">Produk</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">Kategori</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6">Harga / kg</th>
                            <th class="px-6 md:px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal md:py-6 text-right">Aksi</th>
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
        <h3 id="modal-title" class="text-lg md:text-2xl font-black text-primary headline tracking-tight mb-2">Tambah Kategori</h3>
        <p class="text-sm text-on-surface-variant mb-8 font-medium">Lengkapi detail kategori sampah di bawah ini.</p>
        
        <form id="category-form" class="space-y-6">
            <input type="hidden" id="category-id" name="id">
            <input type="hidden" id="category-type" name="type">
            
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2" id="parent-id-wrapper">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Pilih Kategori Induk</label>
                    <select id="parent_id" name="parent_id"
                            class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                        <option value="">-- Pilih Kategori --</option>
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

            <div id="image-upload-group" class="hidden">
                <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Gambar Produk</label>
                <div class="flex items-center gap-4">
                    <div id="image-preview" class="w-20 h-20 rounded-2xl bg-surface-container border border-primary/5 flex items-center justify-center overflow-hidden">
                        <span class="material-symbols-outlined text-outline">image</span>
                    </div>
                    <div class="flex-1">
                        <input type="file" id="product-image" name="image" accept="image/*"
                               class="block w-full text-xs text-outline file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:uppercase file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all">
                        <p class="text-[10px] text-outline/60 mt-1 uppercase tracking-wider">Format: JPG, PNG. Max 2MB.</p>
                    </div>
                </div>
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
let products = [];
let currentCategoryFilter = 'all';

function generateSlug() {
    const name = document.getElementById('name').value;
    const slug = name.toLowerCase()
        .replace(/[^\w ]+/g, '')
        .replace(/ +/g, '-');
    document.getElementById('slug').value = slug;
}

async function fetchCategories() {
    try {
        const res = await fetch('../api/get_categories.php');
        const result = await res.json();
        if (result.status === 'success') {
            categories = result.categories || [];
            products = result.products || [];
            renderPills();
            renderTable();
            updateParentDropdown();
        }
    } catch (err) {
        console.error('Fetch error:', err);
    }
}

function updateParentDropdown() {
    const parentSelect = document.getElementById('parent_id');
    parentSelect.innerHTML = '<option value="">-- Pilih Kategori --</option>' + 
        categories.map(c => `<option value="${c.id}">${c.name}</option>`).join('');
}

function togglePriceInput(forcedType = null) {
    const type = forcedType || document.getElementById('category-type').value;
    const priceGroup = document.getElementById('price-group');
    const imageGroup = document.getElementById('image-upload-group');
    
    if (type === 'product') {
        priceGroup.classList.remove('opacity-30', 'pointer-events-none');
        imageGroup.classList.remove('hidden');
        document.getElementById('price').required = true;
    } else {
        priceGroup.classList.add('opacity-30', 'pointer-events-none');
        imageGroup.classList.add('hidden');
        document.getElementById('price').required = false;
        document.getElementById('price').value = 0;
    }
}

function renderPills() {
    let html = `
        <button onclick="filterCategory('all')" class="px-6 py-2 rounded-full text-[10px] font-bold uppercase tracking-widest transition-all ${currentCategoryFilter === 'all' ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-surface-container hover:bg-primary/5 text-outline'}">
            Semua Produk
        </button>
    `;
    categories.forEach(cat => {
        const isActive = currentCategoryFilter == cat.id;
        html += `
            <div class="flex items-center gap-0.5 group">
                <button onclick="filterCategory(${cat.id})" class="px-6 py-2 rounded-l-full text-[10px] font-bold uppercase tracking-widest transition-all ${isActive ? 'bg-primary text-white shadow-md shadow-primary/20' : 'bg-surface-container hover:bg-primary/5 text-outline'} flex items-center gap-1.5 h-full">
                    ${cat.icon ? `<span class="material-symbols-outlined text-[14px] leading-none">${cat.icon}</span>` : ''} 
                    <span class="leading-none mt-0.5">${cat.name}</span>
                </button>
                <div class="flex flex-col gap-px h-full">
                    <button onclick="editCategory(${cat.id}, 'category')" class="flex-1 px-2 rounded-tr-lg text-outline hover:bg-primary/10 hover:text-primary bg-surface-container transition-all flex items-center justify-center">
                        <span class="material-symbols-outlined text-[10px]">edit</span>
                    </button>
                    <button onclick="deleteCategory(${cat.id}, 'category')" class="flex-1 px-2 rounded-br-lg text-outline hover:bg-red-50 hover:text-red-500 bg-surface-container transition-all flex items-center justify-center">
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
    
    let filteredProducts = [];
    if (currentCategoryFilter === 'all') {
        filteredProducts = products;
    } else {
        filteredProducts = products.filter(p => p.category_id == currentCategoryFilter);
    }

    if (filteredProducts.length === 0) {
        tbody.innerHTML = '<tr><td colspan="4" class="px-8 py-20 text-center text-outline italic">Belum ada data produk di kategori ini.</td></tr>';
        return;
    }

    let html = '';
    filteredProducts.forEach(prod => {
        const parent = categories.find(c => c.id == prod.category_id);
        const parentName = parent ? parent.name : 'Unknown';
        
        html += `
            <tr class="hover:bg-primary/[0.02] transition-colors">
                <td class="px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-surface-container flex items-center justify-center text-primary overflow-hidden shadow-sm">
                            ${prod.image_url ? `<img src="${prod.image_url}" class="w-full h-full object-cover">` : `<span class="material-symbols-outlined text-[20px]">inventory_2</span>`}
                        </div>
                        <div>
                            <p class="font-bold text-on-surface text-sm">${prod.name}</p>
                            <p class="text-[10px] text-outline truncate max-w-[200px]">${prod.description || '-'}</p>
                        </div>
                    </div>
                </td>
                <td class="px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal">
                    <span class="px-3 py-1.5 bg-surface-container-high rounded-lg text-[10px] font-bold text-on-surface-variant uppercase tracking-widest">${parentName}</span>
                    ${prod.is_popular ? '<span class="px-3 py-1.5 bg-secondary/10 text-secondary text-[10px] font-bold rounded-lg ml-1 uppercase tracking-widest">POPULER</span>' : ''}
                </td>
                <td class="px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal font-black text-sm text-primary">
                    IDR ${new Intl.NumberFormat('id-ID').format(prod.price_per_kg)}
                </td>
                <td class="px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal text-right">
                    <div class="flex justify-end gap-2">
                        <button onclick="editCategory(${prod.id}, 'product')" class="w-8 h-8 rounded-lg bg-white border border-primary/10 flex items-center justify-center text-outline hover:text-primary hover:border-primary/30 transition-all">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                        </button>
                        <button onclick="deleteCategory(${prod.id}, 'product')" class="w-8 h-8 rounded-lg bg-white border border-red-50 flex items-center justify-center text-red-300 hover:text-red-500 hover:border-red-200 transition-all">
                            <span class="material-symbols-outlined text-[16px]">delete</span>
                        </button>
                    </div>
                </td>
            </tr>
        `;
    });

    tbody.innerHTML = html;
}

function openModal(type = 'category') {
    const form = document.getElementById('category-form');
    form.reset();
    document.getElementById('category-id').value = '';
    document.getElementById('category-type').value = type;
    
    updateParentDropdown();
    
    const parentWrapper = document.getElementById('parent-id-wrapper');
    const parentSelect = document.getElementById('parent_id');
    
    if (type === 'category') {
        document.getElementById('modal-title').innerText = 'Tambah Kategori';
        parentWrapper.classList.add('hidden');
        parentSelect.removeAttribute('required');
        parentSelect.value = '';
    } else {
        document.getElementById('modal-title').innerText = 'Tambah Produk';
        parentWrapper.classList.remove('hidden');
        parentSelect.setAttribute('required', 'true');
    }
    
    document.getElementById('form-modal').classList.remove('hidden');
    togglePriceInput(type);
}

function closeModal() {
    document.getElementById('form-modal').classList.add('hidden');
}

function editCategory(id, type) {
    let item;
    if (type === 'category') {
        item = categories.find(c => c.id == id);
    } else {
        item = products.find(p => p.id == id);
    }
    
    if (!item) return;

    document.getElementById('category-id').value = item.id;
    document.getElementById('category-type').value = type;
    document.getElementById('name').value = item.name;
    document.getElementById('slug').value = item.slug;
    document.getElementById('price').value = item.price_per_kg || 0;
    document.getElementById('icon').value = item.icon || '';
    document.getElementById('description').value = item.description || '';
    document.getElementById('popular').checked = parseInt(item.is_popular) === 1;

    const parentWrapper = document.getElementById('parent-id-wrapper');
    const parentSelect = document.getElementById('parent_id');

    if (type === 'product') {
        document.getElementById('modal-title').innerText = 'Edit Produk';
        parentWrapper.classList.remove('hidden');
        parentSelect.setAttribute('required', 'true');
        document.getElementById('parent_id').value = item.category_id || '';
    } else {
        document.getElementById('modal-title').innerText = 'Edit Kategori';
        parentWrapper.classList.add('hidden');
        parentSelect.removeAttribute('required');
        document.getElementById('parent_id').value = '';
    }

    document.getElementById('form-modal').classList.remove('hidden');
    
    // Preview Image if exists
    const preview = document.getElementById('image-preview');
    if (item.image_url) {
        preview.innerHTML = `<img src="${item.image_url}" class="w-full h-full object-cover">`;
    } else {
        preview.innerHTML = `<span class="material-symbols-outlined text-outline">image</span>`;
    }

    togglePriceInput(type);
}

async function deleteCategory(id, type) {
    if (!confirm('Apakah Anda yakin ingin menghapus data ini?')) return;

    try {
        const entity = type === 'product' ? 'products' : 'categories';
        const res = await fetch(`../api/manage_admin.php?entity=${entity}&action=delete`, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        const result = await res.json();
        if (result.status === 'success') {
            fetchCategories();
        } else {
            alert(result.message);
        }
    } catch (err) {
        console.error(err);
    }
}

document.getElementById('category-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    
    const type = document.getElementById('category-type').value;

    if (type === 'product') {
        formData.append('entity', 'products');
    } else {
        formData.append('entity', 'categories');
    }
    
    formData.append('is_popular', document.getElementById('popular').checked ? 1 : 0);

    try {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            body: formData
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

document.getElementById('product-image').addEventListener('change', function(e) {
    if (this.files && this.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('image-preview').innerHTML = `<img src="${e.target.result}" class="w-full h-full object-cover">`;
        }
        reader.readAsDataURL(this.files[0]);
    }
});

document.addEventListener('DOMContentLoaded', fetchCategories);
</script>

<?php include '../includes/footer.php'; ?>
