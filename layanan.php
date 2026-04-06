<?php
// Layanan (Services) Page
include 'includes/header.php';
?>

<!-- Hero Section -->
<section class="mb-12">
    <span class="text-secondary font-bold tracking-widest text-[11px] uppercase mb-2 block headline">Our Services</span>
    <h2 class="text-4xl font-extrabold text-on-surface tracking-tight mb-4 leading-tight headline">Solusi Berkelanjutan untuk <br><span class="text-primary">Masa Depan Bumi.</span></h2>
    <p class="text-on-surface-variant max-w-xl text-lg leading-relaxed">Pilih layanan pengelolaan limbah premium yang dirancang khusus untuk kebutuhan gaya hidup modern dan tanggung jawab industri.</p>
</section>

<!-- Services Grid -->
<div class="grid grid-cols-1 md:grid-cols-12 gap-6 pb-12">
    <!-- Pick-up Service -->
    <div class="md:col-span-8 card-container min-h-[320px] relative overflow-hidden group">
        <div class="relative z-10">
            <div class="w-14 h-14 bg-primary-container/20 rounded-xl flex items-center justify-center mb-6 text-primary">
                <span class="material-symbols-outlined text-3xl">local_shipping</span>
            </div>
            <h3 class="text-2xl font-bold text-on-surface mb-3 headline">Pick-up Service</h3>
            <p class="text-on-surface-variant max-w-sm mb-8">Penjemputan sampah rutin langsung dari depan pintu Anda. Kami mengelola logistik, Anda cukup memilah.</p>
            <button class="btn-primary inline-flex items-center gap-2">
                Jadwalkan Sekarang
                <span class="material-symbols-outlined text-sm">arrow_forward</span>
            </button>
        </div>
        <!-- Abstract visual element -->
        <div class="absolute right-[-20px] bottom-[-20px] opacity-5 group-hover:opacity-10 transition-opacity duration-700">
            <span class="material-symbols-outlined text-[200px]">recycling</span>
        </div>
    </div>

    <!-- Recycling Training -->
    <div class="md:col-span-4 bg-secondary-container/20 rounded-xl p-8 flex flex-col group border border-secondary/10">
        <div class="w-12 h-12 bg-secondary rounded-xl flex items-center justify-center mb-6 text-white">
            <span class="material-symbols-outlined">school</span>
        </div>
        <h3 class="text-xl font-bold text-on-surface mb-3 headline">Recycling Training</h3>
        <p class="text-on-surface-variant text-sm leading-relaxed mb-6">Edukasi mendalam tentang cara memproses limbah rumah tangga menjadi nilai ekonomi tinggi.</p>
        <div class="mt-auto">
            <span class="text-secondary font-bold text-sm inline-flex items-center gap-1 cursor-pointer">
                Pelajari Modul <span class="material-symbols-outlined text-xs">chevron_right</span>
            </span>
        </div>
    </div>

    <!-- Industrial Waste Consultation -->
    <div class="md:col-span-6 bg-tertiary/10 rounded-xl p-8 flex flex-col md:flex-row gap-6 items-start border border-tertiary/10">
        <div class="flex-shrink-0">
            <div class="w-14 h-14 bg-tertiary text-white rounded-full flex items-center justify-center shadow-lg shadow-tertiary/20">
                <span class="material-symbols-outlined">business_center</span>
            </div>
        </div>
        <div>
            <h3 class="text-xl font-bold text-on-surface mb-2 headline">Industrial Waste Consultation</h3>
            <p class="text-on-surface-variant text-sm mb-4">Konsultasi ahli untuk perusahaan dalam mencapai target Zero Waste dan kepatuhan regulasi lingkungan.</p>
            <div class="flex gap-2">
                <span class="px-3 py-1 bg-white/60 rounded-full text-[10px] font-bold uppercase tracking-wider text-tertiary">Expertise</span>
                <span class="px-3 py-1 bg-white/60 rounded-full text-[10px] font-bold uppercase tracking-wider text-tertiary">Corporate</span>
            </div>
        </div>
    </div>

    <!-- Composting -->
    <div class="md:col-span-6 card-container relative overflow-hidden group">
        <div class="flex justify-between items-start mb-4">
            <div class="w-14 h-14 bg-secondary-container rounded-2xl flex items-center justify-center text-secondary">
                <span class="material-symbols-outlined">compost</span>
            </div>
            <span class="text-[10px] font-bold text-secondary bg-white px-3 py-1 rounded-full shadow-sm border border-secondary/10">POPULAR</span>
        </div>
        <h3 class="text-xl font-bold text-on-surface mb-2 headline">Composting Solutions</h3>
        <p class="text-on-surface-variant text-sm mb-6">Ubah sampah organik dapur Anda menjadi pupuk nutrisi tinggi dengan sistem bokashi premium kami.</p>
        <div class="flex -space-x-3">
            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden bg-slate-200">
                <img src="https://ui-avatars.com/api/?name=User1&background=random" alt="User">
            </div>
            <div class="w-8 h-8 rounded-full border-2 border-white overflow-hidden bg-slate-200">
                <img src="https://ui-avatars.com/api/?name=User2&background=random" alt="User">
            </div>
            <div class="w-8 h-8 rounded-full border-2 border-white bg-primary-container flex items-center justify-center text-[10px] font-bold text-primary">
                +1k
            </div>
        </div>
    </div>
</div>

<?php include 'includes/footer.php'; ?>
