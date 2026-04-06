<?php
include '../includes/header.php';
?>

<!-- Header / Search -->
<section class="mb-10 px-2 animate-slide-up">
    <div class="flex flex-col gap-6">
        <div class="">
            <span class="text-secondary font-black text-[10px] uppercase tracking-[0.25em] mb-3 block headline opacity-70">Layanan Kontribusi</span>
            <h2 class="headline text-4xl font-black tracking-tighter text-on-surface leading-none">Jual Sampah</h2>
            <p class="text-on-surface-variant mt-4 text-sm font-bold leading-relaxed">Pilih jenis sampah yang ingin Anda tukarkan menjadi saldo digital hari ini.</p>
        </div>
        
        <!-- Premium Search Bar -->
        <div class="w-full">
            <div class="bg-white px-6 py-4 flex items-center gap-4 rounded-2xl shadow-lg border border-primary/5 focus-within:border-primary/20 transition-all">
                <span class="material-symbols-outlined text-primary font-bold">search</span>
                <input type="text" id="product-search" onkeyup="filterProducts()" placeholder="Urutkan atau cari jenis sampah..." class="bg-transparent border-none focus:ring-0 text-sm font-black w-full p-0 placeholder:text-outline/50 placeholder:font-bold">
            </div>
        </div>
    </div>
</section>

<!-- Category Horizontal Filter -->
<div id="category-filter" class="flex gap-3 overflow-x-auto pb-8 hide-scrollbar mb-4 px-2 animate-slide-up" style="animation-delay: 0.1s">
    <!-- Categories will be loaded here -->
    <div class="animate-pulse bg-surface-container-highest w-28 h-12 rounded-full"></div>
    <div class="animate-pulse bg-surface-container-highest w-28 h-12 rounded-full"></div>
</div>

<!-- Product Bento Grid -->
<section id="catalog-grid" class="grid grid-cols-2 gap-5 pb-40 px-2 animate-slide-up" style="animation-delay: 0.2s">
    <!-- Skeleton cards -->
    <div class="animate-pulse bg-white border border-primary/5 h-64 rounded-[2.25rem]"></div>
    <div class="animate-pulse bg-white border border-primary/5 h-64 rounded-[2.25rem]"></div>
</section>

<!-- Sell Modal (Bottom Sheet style on Mobile) -->
<div id="sell-modal" class="fixed inset-0 bg-black/70 backdrop-blur-md z-[1000] hidden flex items-end justify-center p-0">
    <div class="bg-surface w-full max-w-md rounded-t-[3rem] p-9 shadow-2xl animate-slide-up relative">
        <div class="w-12 h-1.5 bg-outline-variant/30 rounded-full mx-auto mb-8"></div>
        
        <div class="flex justify-between items-start mb-8">
            <div>
                <h3 id="modal-title" class="text-3xl font-black text-primary headline tracking-tighter leading-none">Setor Sampah</h3>
                <p id="modal-subtitle" class="text-[10px] font-black text-outline uppercase tracking-[0.2em] mt-3">Estimasi Payout Digital</p>
            </div>
            <button onclick="closeModal()" class="w-12 h-12 rounded-2xl bg-surface-container-highest flex items-center justify-center text-primary active:scale-90 transition-transform">
                <span class="material-symbols-outlined font-bold">close</span>
            </button>
        </div>

        <form id="sell-form" class="space-y-8">
            <input type="hidden" id="modal-product-id" name="category_id">
            
            <div class="bg-white p-7 rounded-[2.5rem] border border-primary/5 shadow-inner">
                <div class="flex justify-between items-center mb-6">
                    <span id="display-product-name" class="font-black text-primary text-sm uppercase tracking-widest">Botol PET</span>
                    <span id="display-product-price" class="text-[10px] font-black text-secondary bg-secondary/10 px-4 py-1.5 rounded-full">Rp0 / kg</span>
                </div>
                
                <div class="relative flex flex-col items-center">
                    <input type="number" id="weight-input" name="weight_est" step="0.1" required
                           oninput="updateEstimate()"
                           class="w-full bg-transparent border-none text-center text-6xl font-black text-primary focus:ring-0 p-0 placeholder:text-primary/5" 
                           placeholder="0.0">
                    <span class="text-[10px] font-black text-outline uppercase tracking-[0.3em] mt-2">KILOGRAM (KG)</span>
                </div>
            </div>

            <div class="flex justify-between items-center px-4 bg-secondary/5 p-5 rounded-2xl border border-secondary/10">
                <span class="text-[10px] font-black text-secondary uppercase tracking-[0.2em]">Estimasi Saldo</span>
                <span id="estimated-payout" class="text-2xl font-black text-secondary tracking-tighter">Rp 0</span>
            </div>

            <button type="submit" class="btn-premium w-full !h-16 !text-lg !rounded-[1.5rem]">
                <span class="material-symbols-outlined font-bold">send</span>
                Kirim Laporan
            </button>
            <p class="text-[10px] text-center text-outline font-bold leading-relaxed px-4">Setelah dikirim, silakan bawa sampah Anda ke pos terdekat untuk verifikasi timbangan.</p>
        </form>
    </div>
</div>

<script>
let allProducts = [];
let currentFilter = '';

async function loadData() {
    try {
        const res = await fetch('../api/get_products.php');
        const result = await res.json();
        
        if (result.status === 'success') {
            allProducts = result.data;
            renderCategories(result.categories);
            renderProducts(allProducts);
        }
    } catch (err) {
        console.error(err);
    }
}

function renderCategories(categories) {
    const container = document.getElementById('category-filter');
    container.innerHTML = `
        <button onclick="setFilter('')" class="filter-btn active flex-none bg-primary text-white text-[11px] font-black uppercase tracking-widest px-8 py-4 rounded-full shadow-xl shadow-primary/20 transition-all">Semua</button>
        ${categories.map(c => `
            <button onclick="setFilter('${c.name}')" class="filter-btn flex-none bg-white text-outline border border-primary/5 text-[11px] font-black uppercase tracking-widest px-8 py-4 rounded-full hover:bg-surface-container transition-all">${c.name}</button>
        `).join('')}
    `;
}

function setFilter(catName) {
    currentFilter = catName;
    document.querySelectorAll('.filter-btn').forEach(btn => {
        if(btn.innerText.toLowerCase() === (catName || 'semua').toLowerCase()) {
            btn.classList.add('active', 'bg-primary', 'text-white', 'shadow-xl', 'shadow-primary/20');
            btn.classList.remove('bg-white', 'text-outline');
        } else {
            btn.classList.remove('active', 'bg-primary', 'text-white', 'shadow-xl', 'shadow-primary/20');
            btn.classList.add('bg-white', 'text-outline');
        }
    });
    filterProducts();
}

function filterProducts() {
    const query = document.getElementById('product-search').value.toLowerCase();
    const filtered = allProducts.filter(p => {
        const matchCat = !currentFilter || p.parent_name === currentFilter;
        const matchSearch = p.name.toLowerCase().includes(query) || (p.parent_name && p.parent_name.toLowerCase().includes(query));
        return matchCat && matchSearch;
    });
    renderProducts(filtered);
}

function renderProducts(products) {
    const container = document.getElementById('catalog-grid');
    if (products.length === 0) {
        container.innerHTML = '<div class="col-span-full py-20 text-center text-outline italic font-bold">Produk tidak ditemukan.</div>';
        return;
    }

    container.innerHTML = products.map(p => `
        <div onclick="openModal(${p.id}, '${p.name}', ${p.price_per_kg})" class="bg-white rounded-[2.25rem] border border-primary/5 shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-300 flex flex-col active:scale-95 cursor-pointer relative">
            <div class="h-44 relative overflow-hidden bg-surface-container flex items-center justify-center p-4">
                ${p.image_url ? 
                    `<img src="${p.image_url}" alt="${p.name}" class="w-full h-full object-contain group-hover:scale-110 transition-transform duration-500">` : 
                    `<span class="material-symbols-outlined text-5xl text-primary/20">${p.icon || 'inventory_2'}</span>`
                }
                <div class="absolute top-4 left-4 bg-primary/90 backdrop-blur-md text-white px-3 py-1 rounded-full text-[9px] font-black shadow-lg">
                    Rp${new Intl.NumberFormat('id-ID').format(p.price_per_kg)}
                </div>
            </div>
            <div class="p-6 flex-grow flex flex-col justify-between">
                <div>
                    <span class="text-[9px] font-black text-secondary uppercase tracking-[0.25em] mb-2 block opacity-70">${p.parent_name}</span>
                    <h3 class="headline text-sm font-black text-primary mb-1 line-clamp-2 uppercase tracking-tighter leading-tight">${p.name}</h3>
                </div>
                <div class="mt-6 flex items-center justify-center gap-2 text-primary font-black text-[10px] uppercase tracking-widest bg-primary/5 py-3 rounded-2xl group-hover:bg-primary group-hover:text-white transition-colors">
                    <span class="material-symbols-outlined text-[16px] font-black">add_circle</span>
                    Jual
                </div>
            </div>
        </div>
    `).join('');
}

let selectedProduct = null;

function openModal(id, name, price) {
    selectedProduct = { id, name, price };
    document.getElementById('modal-product-id').value = id;
    document.getElementById('display-product-name').innerText = name;
    document.getElementById('display-product-price').innerText = `Rp${new Intl.NumberFormat('id-ID').format(price)} / kg`;
    document.getElementById('weight-input').value = '';
    document.getElementById('estimated-payout').innerText = 'Rp 0';
    document.getElementById('sell-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('sell-modal').classList.add('hidden');
}

function updateEstimate() {
    const weight = parseFloat(document.getElementById('weight-input').value) || 0;
    const payout = weight * selectedProduct.price;
    document.getElementById('estimated-payout').innerText = `Rp${new Intl.NumberFormat('id-ID').format(payout)}`;
}

document.getElementById('sell-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());

    try {
        const res = await fetch('../api/create_transaction.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await res.json();
        
        if (result.status === 'success') {
            alert('✔ Berhasil! Laporan Anda telah kami terima. Silakan serahkan sampah ke petugas untuk verifikasi.');
            closeModal();
            location.href = 'profile.php';
        } else {
            alert('❌ ' + result.message);
        }
    } catch (err) {
        console.error(err);
        alert('Gagal mengirim data.');
    }
});

// Load on start
document.addEventListener('DOMContentLoaded', loadData);
</script>

<style>
/* Hide scrollbar */
.hide-scrollbar::-webkit-scrollbar { display: none; }
.hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

.animate-slide-up {
    animation: slideUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    opacity: 0;
    transform: translateY(20px);
}

@keyframes slideUp {
    to { opacity: 1; transform: translateY(0); }
}
</style>

<?php include '../includes/footer.php'; ?>
