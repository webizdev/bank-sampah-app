<?php
// Profile & History Page
include '../includes/header.php';
?>

<!-- Profile Header -->
<section class="mb-10 flex flex-col items-center text-center">
    <div class="w-24 h-24 rounded-full bg-primary-container flex items-center justify-center overflow-hidden border-4 border-white shadow-xl mb-4">
        <img src="https://ui-avatars.com/api/?name=Aris&background=0f5238&color=fff&size=128" alt="Profile" class="w-full h-full object-cover">
    </div>
    <h2 class="headline text-2xl font-bold text-on-surface">Aris Setiawan</h2>
    <p class="text-on-surface-variant font-medium">Bumi-Warrior • Sejak Jan 2026</p>
    
    <div class="mt-6 flex gap-4">
        <button class="section-container py-2 px-6 text-xs font-bold uppercase tracking-widest text-primary border border-primary/10">Edit Profil</button>
        <a href="../logout.php" class="section-container py-2 px-6 text-xs font-bold uppercase tracking-widest text-error border border-error/10">Keluar</a>
    </div>
</section>

<!-- Impact Metrics -->
<section id="user-stats" class="grid grid-cols-2 gap-4 mb-10">
    <div class="card-container text-center">
        <p class="text-[10px] uppercase font-bold tracking-widest text-on-surface-variant mb-1">Total Setoran</p>
        <p class="headline text-2xl font-black text-primary"><span id="stat-total-kg">0.0</span><span class="text-xs font-medium ml-1">kg</span></p>
    </div>
    <div class="card-container text-center text-on-surface">
        <p class="text-[10px] uppercase font-bold tracking-widest text-on-surface-variant mb-1">Pohon Diselamatkan</p>
        <p class="headline text-2xl font-black text-secondary">1.2<span class="text-xs font-medium ml-1">batang</span></p>
    </div>
</section>

<!-- Transaction History -->
<section class="mb-10">
    <h3 class="headline text-lg font-bold mb-6">Riwayat Transaksi</h3>
    <div id="transaction-history" class="space-y-4">
        <!-- Will be loaded by app.js -->
        <div class="animate-pulse h-16 bg-surface-container-low rounded-xl"></div>
        <div class="animate-pulse h-16 bg-surface-container-low rounded-xl"></div>
    </div>
</section>


<?php include '../includes/footer.php'; ?>
