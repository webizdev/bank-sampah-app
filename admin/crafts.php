<?php
$hide_nav = true;
include '../includes/header.php';
include 'sidebar.php';
?>

<div class="md:ml-64 transition-all duration-300 w-full md:w-auto bg-surface min-h-screen pb-20">
    <!-- Header -->
    <header class="bg-white px-4 md:px-8 py-4 md:py-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-primary/5 shadow-sm sticky top-0 z-50">
        <div>
            <h1 class="text-lg md:text-xl font-black text-primary headline tracking-tight leading-none">Katalog Craft</h1>
            <p class="text-[9px] md:text-[10px] font-bold text-outline uppercase tracking-widest mt-1">Kelola produk kreatif daur ulang</p>
        </div>
        <button onclick="openModal()" class="w-full sm:w-auto bg-primary text-white px-4 py-2.5 md:px-6 md:py-3 rounded-xl font-bold text-[11px] md:text-xs flex items-center justify-center sm:justify-start gap-2 shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
            <span class="material-symbols-outlined text-[16px] md:text-[18px]">add_circle</span>
            Tambah Produk
        </button>
    </header>

    <main class="max-w-7xl mx-auto px-4 md:px-8 py-6 md:py-10">
        <div id="craft-list" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6">
            <!-- Loaded by JS -->
            <div class="animate-pulse bg-white/50 h-64 rounded-[2rem]"></div>
        </div>
    </main>
</div>

<!-- Modal Form -->
<div id="form-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] p-10 shadow-2xl overflow-y-auto max-h-[90vh]">
        <h3 id="modal-title" class="text-lg md:text-2xl font-black text-primary headline tracking-tight mb-2">Tambah Produk Craft</h3>
        <p class="text-sm text-on-surface-variant mb-8 font-medium">Isi detail produk untuk ditampilkan di katalog user.</p>
        
        <form id="craft-form" class="space-y-6">
            <input type="hidden" id="craft-id" name="id">
            
            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Nama Produk</label>
                    <input type="text" id="title" name="title" required 
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                </div>
                
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Harga (IDR)</label>
                    <input type="number" id="price" name="price" required 
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Deskripsi Singkat</label>
                    <textarea id="description" name="description" rows="3" required
                              class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold"></textarea>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">CTA Link (WhatsApp/Tokopedia)</label>
                    <input type="url" id="cta_link" name="cta_link" required
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold" placeholder="https://...">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Gambar Produk</label>
                    <input type="file" id="image" name="image" accept="image/*" class="w-full text-xs text-outline font-bold file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-primary/10 file:text-primary file:uppercase">
                    <p id="current-image-name" class="text-[9px] text-primary font-bold mt-2"></p>
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-primary/5">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 font-bold text-outline">Batal</button>
                <button type="submit" class="flex-1 bg-primary text-white py-4 font-bold rounded-2xl shadow-xl shadow-primary/20 transition-all">Simpan Produk</button>
            </div>
        </form>
    </div>
</div>

<script>
let crafts = [];

async function fetchCrafts() {
    const res = await fetch('../api/manage_admin.php?entity=crafts');
    const result = await res.json();
    if (result.status === 'success') {
        crafts = result.data;
        renderCrafts(crafts);
    }
}

function renderCrafts(data) {
    const container = document.getElementById('craft-list');
    if (data.length === 0) {
        container.innerHTML = '<div class="col-span-full py-20 text-center text-outline italic">Belum ada produk craft.</div>';
        return;
    }

    container.innerHTML = data.map(c => `
        <div class="bg-white rounded-2xl md:rounded-[2rem] border border-primary/5 shadow-xl overflow-hidden group">
            <div class="h-32 md:h-48 relative overflow-hidden bg-surface-container">
                <img src="${c.image_url || 'https://via.placeholder.com/400x300?text=No+Image'}" 
                     class="w-full h-full object-cover">
                <div class="absolute top-2 right-2 md:top-4 md:right-4 flex gap-1 md:gap-2">
                    <button onclick="editCraft(${c.id})" class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-white/90 shadow-lg text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[14px] md:text-[18px]">edit</span>
                    </button>
                    <button onclick="deleteCraft(${c.id})" class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-white/90 shadow-lg text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[14px] md:text-[18px]">delete</span>
                    </button>
                </div>
            </div>
            <div class="p-3 md:p-6">
                <div class="flex flex-col md:flex-row justify-between items-start mb-2 gap-1 md:gap-0">
                    <h4 class="text-xs md:text-base headline font-black text-primary line-clamp-2 md:line-clamp-none">${c.title}</h4>
                    <span class="text-[10px] md:text-xs font-black text-secondary">IDR ${new Intl.NumberFormat('id-ID').format(c.price)}</span>
                </div>
                <p class="text-[8px] md:text-[10px] text-outline font-medium line-clamp-2 mb-3 md:mb-4">${c.description}</p>
                <div class="flex items-center gap-2 text-[9px] font-black text-primary uppercase bg-primary/5 p-2 rounded-lg">
                    <span class="material-symbols-outlined text-[14px]">link</span>
                    <span class="truncate">${c.cta_link}</span>
                </div>
            </div>
        </div>
    `).join('');
}

function openModal() {
    document.getElementById('modal-title').innerText = 'Tambah Produk Craft';
    document.getElementById('craft-form').reset();
    document.getElementById('craft-id').value = '';
    document.getElementById('current-image-name').innerText = '';
    document.getElementById('form-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('form-modal').classList.add('hidden');
}

function editCraft(id) {
    const c = crafts.find(item => item.id == id);
    if (!c) return;
    
    document.getElementById('modal-title').innerText = 'Edit Produk Craft';
    document.getElementById('craft-id').value = c.id;
    document.getElementById('title').value = c.title;
    document.getElementById('price').value = c.price;
    document.getElementById('description').value = c.description;
    document.getElementById('cta_link').value = c.cta_link;
    document.getElementById('current-image-name').innerText = c.image_url ? 'Gambar saat ini: ' + c.image_url.split('/').pop() : '';
    
    document.getElementById('form-modal').classList.remove('hidden');
}

async function deleteCraft(id) {
    if (!confirm('Hapus produk ini?')) return;
    
    try {
        const res = await fetch('../api/manage_admin.php?entity=crafts&action=delete', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id })
        });
        if ((await res.json()).status === 'success') fetchCrafts();
    } catch (err) { console.error(err); }
}

document.getElementById('craft-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    formData.append('entity', 'crafts');

    try {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            body: formData
        });
        const result = await res.json();
        if (result.status === 'success') {
            closeModal();
            fetchCrafts();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (err) { console.error(err); }
});

document.addEventListener('DOMContentLoaded', fetchCrafts);
</script>

<?php include '../includes/footer.php'; ?>
