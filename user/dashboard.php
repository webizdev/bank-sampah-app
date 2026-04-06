<?php
// Main Home Page
include '../includes/header.php';
?>

<!-- Hero / User Greeting -->
<section class="mb-8">
    <h2 id="user-greeting" class="headline text-2xl font-bold tracking-tight text-on-surface">Halo, Pengguna!</h2>
    <p class="text-on-surface-variant font-medium">Selamat berkontribusi untuk bumi hari ini.</p>
</section>

<!-- Impact Summary Bento Grid -->
<section id="user-stats" class="grid grid-cols-2 gap-4 mb-10">
    <div class="col-span-2 bg-gradient-to-br from-primary to-primary-container p-6 rounded-xl text-white flex justify-between items-center relative overflow-hidden shadow-lg shadow-primary/20">
        <div class="z-10">
            <p class="text-xs uppercase tracking-widest opacity-80 mb-1">Total Kontribusi</p>
            <p class="headline text-3xl font-extrabold"><span id="stat-total-kg">0.0</span><span class="text-lg font-normal ml-1">kg</span></p>
            <p class="text-sm mt-2 font-medium bg-white/20 inline-block px-3 py-1 rounded-full backdrop-blur-sm">Sangat Bagus!</p>
        </div>
        <div class="z-10 text-right">
            <span class="material-symbols-outlined text-4xl opacity-50" style="font-variation-settings: 'FILL' 1;">eco</span>
        </div>
        <!-- Decorative element -->
        <div class="absolute -right-10 -bottom-10 w-40 h-40 bg-white/5 rounded-full blur-3xl"></div>
    </div>
    <div class="card-container flex flex-col justify-between h-32">
        <span class="material-symbols-outlined text-secondary">database</span>
        <div>
            <p class="headline text-xl font-bold">IDR <span id="stat-balance">0</span></p>
            <p class="text-[11px] uppercase tracking-wider text-on-surface-variant">SALDO</p>
        </div>
    </div>
    <div class="card-container flex flex-col justify-between h-32 font-medium">
        <span class="material-symbols-outlined text-tertiary">workspace_premium</span>
        <div>
            <p id="stat-tier" class="headline text-xl font-bold">...</p>
            <p class="text-[11px] uppercase tracking-wider text-on-surface-variant">Tier Member</p>
        </div>
    </div>
</section>

<!-- Large Slider Section: Agenda & Edukasi -->
<section class="mb-10 -mx-6 overflow-hidden">
    <div class="px-6 flex justify-between items-end mb-4">
        <h3 class="headline text-lg font-bold">Eksplorasi Lingkungan</h3>
        <span class="text-primary font-bold text-xs uppercase tracking-widest cursor-pointer">Lihat Semua</span>
    </div>
    <div class="flex overflow-x-auto hide-scrollbar gap-5 px-6 pb-4">
        <!-- Agenda Card -->
        <div class="min-w-[280px] section-container bg-surface-container-low group cursor-pointer active:scale-95 duration-200">
            <div class="h-44 overflow-hidden relative rounded-xl mb-4">
                <img src="https://images.unsplash.com/photo-1595273670150-db0a3d39074f?auto=format&fit=crop&q=80&w=600" alt="Beach Cleanup" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest text-primary">Agenda</div>
            </div>
            <h4 class="headline font-bold text-lg leading-tight mb-2">Piknik Bersih Pantai Ancol</h4>
            <div class="flex items-center gap-2 text-on-surface-variant text-xs">
                <span class="material-symbols-outlined text-sm">calendar_today</span>
                <span>24 Okt 2026</span>
            </div>
        </div>
        <!-- Edukasi Card -->
        <div class="min-w-[280px] section-container bg-surface-container-low group cursor-pointer active:scale-95 duration-200">
            <div class="h-44 overflow-hidden relative rounded-xl mb-4">
                <img src="https://images.unsplash.com/photo-1532996122724-e3c354a0b15b?auto=format&fit=crop&q=80&w=600" alt="Composting" class="w-full h-full object-cover transition-transform duration-500 group-hover:scale-105">
                <div class="absolute top-4 left-4 bg-white/90 backdrop-blur px-3 py-1 rounded-full text-[10px] font-bold uppercase tracking-widest text-secondary">Kegiatan</div>
            </div>
            <h4 class="headline font-bold text-lg leading-tight mb-2">Workshop Kompos Mandiri</h4>
            <div class="flex items-center gap-2 text-on-surface-variant text-xs">
                <span class="material-symbols-outlined text-sm">location_on</span>
                <span>Balai Kota, Jakarta</span>
            </div>
        </div>
    </div>
</section>

<!-- Quick Actions -->
<section class="mb-10">
    <h3 class="headline text-lg font-bold mb-5">Layanan Tercepat</h3>
    <div class="space-y-4">
        <a href="layanan.php" class="flex items-center p-4 card-container group hover:bg-surface-container-low transition-colors duration-200">
            <div class="w-12 h-12 bg-secondary-container rounded-lg flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined">local_shipping</span>
            </div>
            <div class="ml-4 flex-1">
                <h5 class="headline font-bold text-on-surface">Jemput Sampah</h5>
                <p class="text-xs text-on-surface-variant">Sampah langsung dijemput di rumah</p>
            </div>
            <span class="material-symbols-outlined text-outline-variant group-hover:translate-x-1 transition-transform">chevron_right</span>
        </a>
        <a href="jual.php" class="flex items-center p-4 card-container group hover:bg-surface-container-low transition-colors duration-200">
            <div class="w-12 h-12 bg-primary-container/20 rounded-lg flex items-center justify-center text-primary">
                <span class="material-symbols-outlined">shopping_cart</span>
            </div>
            <div class="ml-4 flex-1">
                <h5 class="headline font-bold text-on-surface">Jual Sampah</h5>
                <p class="text-xs text-on-surface-variant">Tukarkan sampahmu menjadi saldo</p>
            </div>
            <span class="material-symbols-outlined text-outline-variant group-hover:translate-x-1 transition-transform">chevron_right</span>
        </a>
    </div>
</section>


<?php include '../includes/footer.php'; ?>
