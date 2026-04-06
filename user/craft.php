<?php
include '../includes/header.php';
?>

<!-- Header Section -->
<section class="mb-8">
    <h2 class="headline text-2xl font-bold tracking-tight text-on-surface">Katalog Craft</h2>
    <p class="text-on-surface-variant font-medium">Produk kreatif hasil olah daur ulang sampah berkualitas.</p>
</section>

<!-- Craft Catalog Grid -->
<div id="craft-catalog" class="grid grid-cols-1 sm:grid-cols-2 gap-6 mb-24">
    <!-- Will be loaded by JS -->
    <div class="animate-pulse bg-surface-container-low h-64 rounded-[2rem]"></div>
    <div class="animate-pulse bg-surface-container-low h-64 rounded-[2rem]"></div>
</div>

<script>
async function fetchCrafts() {
    try {
        const res = await fetch('../api/get_crafts.php');
        const result = await res.json();
        
        const container = document.getElementById('craft-catalog');
        
        if (result.status === 'success' && result.data.length > 0) {
            container.innerHTML = result.data.map(item => `
                <div class="bg-white rounded-[2rem] border border-primary/5 shadow-xl overflow-hidden group hover:shadow-2xl transition-all duration-300">
                    <div class="h-56 relative overflow-hidden">
                        <img src="${item.image_url || 'https://via.placeholder.com/600x400?text=No+Image'}" 
                             alt="${item.title}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-4 right-4 bg-primary text-white px-4 py-2 rounded-full text-xs font-black shadow-lg">
                            IDR ${new Intl.NumberFormat('id-ID').format(item.price)}
                        </div>
                    </div>
                    <div class="p-6">
                        <h3 class="headline text-lg font-bold text-primary mb-2">${item.title}</h3>
                        <p class="text-on-surface-variant text-sm mb-6 line-clamp-2">${item.description}</p>
                        <a href="${item.cta_link}" target="_blank" 
                           class="block w-full text-center py-4 bg-surface-container-low text-primary font-black rounded-2xl hover:bg-primary hover:text-white transition-all active:scale-95">
                           Beli Sekarang
                        </a>
                    </div>
                </div>
            `).join('');
        } else {
            container.innerHTML = '<div class="col-span-full py-20 text-center text-outline italic font-bold">Belum ada produk craft tersedia.</div>';
        }
    } catch (err) {
        console.error(err);
        document.getElementById('craft-catalog').innerHTML = '<div class="col-span-full py-20 text-center text-red-400 font-bold">Gagal memuat katalog.</div>';
    }
}

document.addEventListener('DOMContentLoaded', fetchCrafts);
</script>

<?php include '../includes/footer.php'; ?>
