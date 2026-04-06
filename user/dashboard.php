<?php
// Main Home Page
include '../includes/header.php';
?>

<!-- Hero / User Greeting -->
<section class="mb-10 px-2 animate-slide-up">
    <h2 id="user-greeting" class="headline text-2xl font-black tracking-tight text-on-surface">Halo, Pengguna!</h2>
    <p class="text-on-surface-variant font-bold text-sm">Selamat berkontribusi untuk bumi hari ini.</p>
</section>

<!-- Impact Summary Bento Grid -->
<section id="user-stats" class="grid grid-cols-2 gap-4 mb-12 animate-slide-up" style="animation-delay: 0.1s">
    <div class="col-span-2 bg-primary p-7 rounded-[2.5rem] text-white flex justify-between items-center relative overflow-hidden shadow-2xl shadow-primary/20">
        <div class="z-10">
            <p class="text-[10px] font-black uppercase tracking-[0.2em] opacity-60 mb-2">Total Kontribusi</p>
            <p class="headline text-4xl font-black tracking-tighter"><span id="stat-total-kg">0.0</span><span class="text-lg font-bold ml-1 opacity-60">kg</span></p>
        </div>
        <div class="z-10 text-right">
            <div class="w-14 h-14 bg-white/10 rounded-2xl flex items-center justify-center backdrop-blur-md">
                <span class="material-symbols-outlined text-3xl opacity-80" style="font-variation-settings: 'FILL' 1;">eco</span>
            </div>
        </div>
        <!-- Decorative abstract blobs -->
        <div class="absolute -right-10 -bottom-10 w-48 h-48 bg-secondary/10 rounded-full blur-3xl"></div>
        <div class="absolute -left-10 -top-10 w-32 h-32 bg-white/5 rounded-full blur-2xl"></div>
    </div>
    
    <div class="card-container flex flex-col justify-between h-40">
        <div class="w-10 h-10 bg-secondary/10 rounded-xl flex items-center justify-center text-secondary">
            <span class="material-symbols-outlined font-bold">database</span>
        </div>
        <div>
            <p class="headline text-xl font-black tracking-tight">Rp <span id="stat-balance">0</span></p>
            <p class="text-[10px] font-black uppercase tracking-[0.15em] text-outline mt-1">SALDO</p>
        </div>
    </div>
    
    <div class="card-container flex flex-col justify-between h-40">
        <div class="w-10 h-10 bg-primary/10 rounded-xl flex items-center justify-center text-primary">
            <span class="material-symbols-outlined font-bold">workspace_premium</span>
        </div>
        <div>
            <p id="stat-tier" class="headline text-xl font-black tracking-tight uppercase">...</p>
            <p class="text-[10px] font-black uppercase tracking-[0.15em] text-outline mt-1">STATUS</p>
        </div>
    </div>
</section>

<!-- Large Slider Section: Agenda & Edukasi -->
<section class="mb-12 -mx-6 overflow-hidden animate-slide-up" style="animation-delay: 0.2s">
    <div class="px-8 flex justify-between items-end mb-6">
        <div>
            <h3 class="headline text-xl font-black tracking-tight text-primary">Eksplorasi Lingkungan</h3>
            <p class="text-[10px] font-bold text-outline uppercase tracking-widest mt-1">Update & Edukasi Terkini</p>
        </div>
        <span class="text-primary font-black text-[10px] uppercase tracking-widest cursor-pointer pb-1 border-b-2 border-primary/20 hover:border-primary transition-all">Lihat Semua</span>
    </div>
    <div id="article-grid" class="flex overflow-x-auto hide-scrollbar gap-5 px-8 pb-6">
        <!-- Articles loaded by JS -->
        <div class="min-w-[280px] bg-white h-72 rounded-[2rem] border border-primary/5 animate-pulse"></div>
        <div class="min-w-[280px] bg-white h-72 rounded-[2rem] border border-primary/5 animate-pulse"></div>
    </div>
</section>

<!-- Premium Quick Call to Action -->
<section class="mb-8 animate-slide-up" style="animation-delay: 0.3s">
    <div class="bg-surface-container-highest/50 p-8 rounded-[2.5rem] border border-outline/10 text-center">
        <h4 class="headline text-lg font-black text-on-surface mb-2">Mau Menjual Sampah?</h4>
        <p class="text-xs text-on-surface-variant font-bold mb-6">Dapatkan saldo langsung ke dompet digitalmu.</p>
        <a href="jual.php" class="btn-premium w-full shadow-lg shadow-primary/20">Mulai Jual Sekarang</a>
    </div>
</section>


<script>
async function fetchArticles() {
    try {
        const res = await fetch('../api/get_articles.php?limit=5');
        const text = await res.text();
        let result;
        try {
            result = JSON.parse(text);
        } catch (e) {
            console.error('API Parse Error:', text);
            throw new Error('Data format error');
        }

        if (result.status === 'success') {
            renderArticles(result.data);
        }
    } catch (err) { 
        console.error('Sync Error:', err);
        const errorMsg = err.message || 'Gagal memuat data terbaru.';
        document.getElementById('article-grid').innerHTML = `
            <div class="px-6 py-10 w-full">
                <div class="bg-red-50 border border-red-100 rounded-2xl p-6 text-center shadow-sm">
                    <span class="material-symbols-outlined text-red-400 text-3xl mb-2">database_off</span>
                    <p class="text-red-600 font-bold text-sm mb-1">Koneksi Artikel Bermasalah</p>
                    <p class="text-red-400 text-[10px] italic font-mono mb-4">${errorMsg}</p>
                    <p class="text-outline text-[10px] leading-relaxed">Admin sedang melakukan sinkronisasi data. Silakan muat ulang halaman dalam beberapa saat.</p>
                </div>
            </div>`;
    }
}

function renderArticles(data) {
    const grid = document.getElementById('article-grid');
    if (data.length === 0) {
        grid.innerHTML = '<div class="px-6 py-10 text-outline text-xs italic font-medium">Belum ada agenda atau artikel terbaru.</div>';
        return;
    }

    grid.innerHTML = data.map(a => `
        <a href="${a.cta_link || '#'}" target="_blank" class="min-w-[280px] section-container bg-surface-container-low group cursor-pointer active:scale-95 duration-200 flex flex-col no-underline text-inherit">
            <div class="h-44 overflow-hidden relative rounded-xl mb-4 bg-surface-container">
                <img src="${a.image_url || 'https://via.placeholder.com/600x400?text=No+Image'}" 
                     alt="${a.title}" 
                     class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest ${a.category === 'AGENDA' ? 'text-primary' : 'text-secondary'}">
                    ${a.category}
                </div>
            </div>
            <h4 class="headline font-black text-lg leading-tight mb-2 text-primary group-hover:text-primary-variant transition-colors line-clamp-2">${a.title}</h4>
            <div class="flex flex-col gap-1.5">
                ${a.event_date ? `
                    <div class="flex items-center gap-2 text-on-surface-variant text-[10px] font-bold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                        <span>${new Date(a.event_date).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'})}</span>
                    </div>
                ` : ''}
                ${a.location ? `
                    <div class="flex items-center gap-2 text-on-surface-variant text-[10px] font-bold uppercase tracking-wider">
                        <span class="material-symbols-outlined text-[14px]">location_on</span>
                        <span>${a.location}</span>
                    </div>
                ` : ''}
            </div>
        </a>
    `).join('');
}

document.addEventListener('DOMContentLoaded', fetchArticles);
</script>

<?php include '../includes/footer.php'; ?>
