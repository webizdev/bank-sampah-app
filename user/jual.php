<?php
// Jual Sampah (Marketplace Catalog)
include '../includes/header.php';
?>

<!-- Header / Search -->
<section class="mb-10">
    <div class="flex flex-col md:flex-row md:items-end justify-between gap-6">
        <div class="max-w-md">
            <span class="text-secondary font-bold text-xs uppercase tracking-[0.2em] mb-2 block">Katalog Marketplace</span>
            <h2 class="headline text-4xl font-extrabold tracking-tight text-on-surface">Beli Sampah</h2>
            <p class="text-on-surface-variant mt-2 text-sm md:text-base">Tukarkan sampah anorganik Anda menjadi saldo digital dengan nilai ekonomi tinggi.</p>
        </div>
        <div class="w-full md:w-72">
            <div class="section-container px-4 py-3 flex items-center gap-3">
                <span class="material-symbols-outlined text-outline">search</span>
                <input type="text" placeholder="Cari jenis sampah..." class="bg-transparent border-none focus:ring-0 text-sm w-full p-0">
            </div>
        </div>
    </div>
</section>

<!-- Category Horizontal Filter -->
<section class="mb-12">
    <div class="flex gap-4 overflow-x-auto pb-4 hide-scrollbar">
        <button class="flex-none btn-primary text-sm px-8">Semua</button>
        <button class="flex-none section-container py-3 px-8 text-sm font-bold text-on-surface-variant hover:bg-surface-container-high transition-colors">Plastik</button>
        <button class="flex-none section-container py-3 px-8 text-sm font-bold text-on-surface-variant hover:bg-surface-container-high transition-colors">Kertas</button>
        <button class="flex-none section-container py-3 px-8 text-sm font-bold text-on-surface-variant hover:bg-surface-container-high transition-colors">Logam</button>
        <button class="flex-none section-container py-3 px-8 text-sm font-bold text-on-surface-variant hover:bg-surface-container-high transition-colors">Lainnya</button>
    </div>
</section>

<!-- Product Bento Grid -->
<section id="catalog-grid" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
    <!-- Skeleton cards will be replaced by app.js -->
    <div class="card-container animate-pulse h-64 bg-surface-container-low"></div>
    <div class="card-container animate-pulse h-64 bg-surface-container-low"></div>
    <div class="card-container animate-pulse h-64 bg-surface-container-low"></div>
</section>


<?php include '../includes/footer.php'; ?>
