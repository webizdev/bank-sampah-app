<?php
include '../includes/header.php';
?>

<!-- Header Section -->
<section class="mb-8">
    <h2 class="headline text-2xl font-bold tracking-tight text-on-surface">Katalog Craft</h2>
    <p class="text-on-surface-variant font-medium">Produk kreatif hasil olah daur ulang sampah berkualitas.</p>
</section>

<!-- Craft Catalog Grid -->
<div id="craft-catalog" class="grid grid-cols-2 gap-3 mb-24 lg:grid-cols-3">
    <!-- Will be loaded by JS -->
    <div class="animate-pulse bg-surface-container-low h-48 rounded-[1.5rem]"></div>
    <div class="animate-pulse bg-surface-container-low h-48 rounded-[1.5rem]"></div>
</div>

<script>
async function fetchCrafts() {
    try {
        const res = await fetch('../api/get_crafts.php');
        const result = await res.json();
        
        const container = document.getElementById('craft-catalog');
        
        if (result.status === 'success' && result.data.length > 0) {
            container.innerHTML = result.data.map(item => `
                <div class="bg-white rounded-[1.5rem] border border-primary/5 shadow-lg overflow-hidden group hover:shadow-2xl transition-all duration-300 flex flex-col">
                    <div class="h-32 xs:h-40 relative overflow-hidden">
                        <img src="${item.image_url || 'https://via.placeholder.com/600x400?text=No+Image'}" 
                             alt="${item.title}" 
                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                        <div class="absolute top-2 right-2 bg-primary/90 text-white px-2 py-1 rounded-full text-[8px] font-black shadow-lg">
                            Rp${new Intl.NumberFormat('id-ID').format(item.price)}
                        </div>
                    </div>
                    <div class="p-3 flex-grow flex flex-col justify-between">
                        <div class="mb-3">
                            <h3 class="headline text-xs font-black text-primary mb-1 line-clamp-1 uppercase tracking-tighter">${item.title}</h3>
                            <p class="text-on-surface-variant text-[9px] line-clamp-2 leading-tight font-medium">${item.description}</p>
                        </div>
                        <a href="${item.cta_link}" target="_blank" 
                           class="block w-full text-center py-2 bg-primary/5 text-primary text-[10px] font-black rounded-xl hover:bg-primary hover:text-white transition-all active:scale-95 uppercase tracking-widest">
                           Beli
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
