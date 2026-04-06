<?php
include '../includes/header.php';
?>

<!-- Header / Search -->
<section class="mb-10 animate-slide-up">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="max-w-md">
            <span class="text-secondary font-black text-[10px] uppercase tracking-[0.2em] mb-2 block headline">Setor Sampah</span>
            <h2 class="headline text-4xl font-black tracking-tight text-on-surface">Jual Sampah</h2>
            <p class="text-on-surface-variant mt-2 text-sm md:text-base font-medium">Tukarkan sampah anorganik Anda menjadi saldo digital dengan nilai ekonomi tinggi.</p>
        </div>
        <div class="w-full md:w-72">
            <div class="section-container px-4 py-3 flex items-center gap-3">
                <span class="material-symbols-outlined text-outline">search</span>
                <input type="text" id="product-search" onkeyup="filterProducts()" placeholder="Cari jenis sampah..." class="bg-transparent border-none focus:ring-0 text-sm w-full p-0 font-bold">
            </div>
        </div>
    </div>
</section>

<!-- Category Horizontal Filter -->
<div id="category-filter" class="flex gap-4 overflow-x-auto pb-6 hide-scrollbar mb-8 animate-slide-up" style="animation-delay: 0.1s">
    <!-- Categories will be loaded here -->
    <div class="animate-pulse bg-surface-container w-24 h-10 rounded-full"></div>
</div>

<!-- Product Bento Grid -->
<section id="catalog-grid" class="grid grid-cols-2 gap-4 pb-32 animate-slide-up" style="animation-delay: 0.2s">
    <!-- Skeleton cards -->
    <div class="animate-pulse bg-surface-container h-48 rounded-[1.5rem]"></div>
    <div class="animate-pulse bg-surface-container h-48 rounded-[1.5rem]"></div>
</section>

<!-- Sell Modal -->
<div id="sell-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-end sm:items-center justify-center p-0 sm:p-6">
    <div class="bg-white w-full max-w-md rounded-t-[2.5rem] sm:rounded-[2.5rem] p-8 shadow-2xl animate-slide-up">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h3 id="modal-title" class="text-2xl font-black text-primary headline tracking-tight">Jual Sampah</h3>
                <p id="modal-subtitle" class="text-[10px] font-bold text-outline uppercase tracking-widest mt-1">Estimasi Payout Berdasarkan Berat</p>
            </div>
            <button onclick="closeModal()" class="w-10 h-10 rounded-full bg-surface-container flex items-center justify-center text-outline">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <form id="sell-form" class="space-y-6">
            <input type="hidden" id="modal-product-id" name="category_id">
            
            <div class="bg-surface-container-low p-6 rounded-[2rem] border border-primary/5">
                <div class="flex justify-between items-center mb-4">
                    <span id="display-product-name" class="font-black text-primary text-sm uppercase tracking-tight">Botol PET</span>
                    <span id="display-product-price" class="text-[10px] font-black text-secondary bg-secondary/10 px-3 py-1 rounded-full">Rp0 / kg</span>
                </div>
                
                <div class="relative">
                    <input type="number" id="weight-input" name="weight_est" step="0.1" required
                           oninput="updateEstimate()"
                           class="w-full bg-white border-none rounded-2xl px-6 py-5 text-3xl font-black text-on-surface focus:ring-4 focus:ring-primary/10 shadow-inner" 
                           placeholder="0.0">
                    <span class="absolute right-6 top-1/2 -translate-y-1/2 font-black text-outline text-xl">kg</span>
                </div>
            </div>

            <div class="flex justify-between items-center px-4">
                <span class="text-[11px] font-black text-outline uppercase tracking-widest">Estimasi Saldo</span>
                <span id="estimated-payout" class="text-2xl font-black text-secondary">Rp 0</span>
            </div>

            <button type="submit" class="w-full bg-primary text-white py-5 rounded-[2rem] font-black headline text-xl shadow-2xl shadow-primary/30 active:scale-95 transition-all flex items-center justify-center gap-3">
                <span class="material-symbols-outlined">send</span>
                Setor Sekarang
            </button>
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
        <button onclick="setFilter('')" class="filter-btn active flex-none bg-primary text-white text-xs font-black uppercase tracking-widest px-8 py-3 rounded-full shadow-lg transition-all">Semua</button>
        ${categories.map(c => `
            <button onclick="setFilter('${c.name}')" class="filter-btn flex-none bg-white text-outline border border-primary/5 text-xs font-bold uppercase tracking-widest px-8 py-3 rounded-full hover:bg-surface-container transition-all">${c.name}</button>
        `).join('')}
    `;
}

function setFilter(catName) {
    currentFilter = catName;
    document.querySelectorAll('.filter-btn').forEach(btn => {
        if(btn.innerText.toLowerCase() === (catName || 'semua').toLowerCase()) {
            btn.classList.add('active', 'bg-primary', 'text-white');
            btn.classList.remove('bg-white', 'text-outline');
        } else {
            btn.classList.remove('active', 'bg-primary', 'text-white');
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
        <div onclick="openModal(${p.id}, '${p.name}', ${p.price_per_kg})" class="bg-white rounded-[1.5rem] border border-primary/5 shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300 flex flex-col active:scale-95 cursor-pointer">
            <div class="h-32 xs:h-40 relative overflow-hidden bg-surface-container">
                <img src="${p.image_url || 'https://via.placeholder.com/600x400?text=' + encodeURIComponent(p.name)}" 
                     alt="${p.name}" 
                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                <div class="absolute top-2 right-2 bg-primary/90 text-white px-3 py-1 rounded-full text-[8px] font-black shadow-lg">
                    Rp${new Intl.NumberFormat('id-ID').format(p.price_per_kg)} / kg
                </div>
            </div>
            <div class="p-3 flex-grow flex flex-col justify-between">
                <div>
                    <span class="text-[8px] font-black text-secondary uppercase tracking-[0.2em] mb-1 block">${p.parent_name}</span>
                    <h3 class="headline text-xs font-black text-primary mb-1 line-clamp-1 uppercase tracking-tighter">${p.name}</h3>
                </div>
                <div class="mt-4 flex items-center gap-1 text-primary font-black text-[9px] uppercase tracking-widest bg-primary/5 p-2 rounded-lg">
                    <span class="material-symbols-outlined text-[14px]">add_circle</span>
                    Jual Sekarang
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
