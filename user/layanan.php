<?php
include '../includes/header.php';

// Fetch active services
$stmt = $pdo->query("SELECT * FROM services WHERE is_active = 1 ORDER BY name ASC");
$services = $stmt->fetchAll();

// Icon Mapping
$icons = [
    'PICKUP' => ['icon' => 'local_shipping', 'bg' => 'bg-primary/10', 'text' => 'text-primary'],
    'CONSULT' => ['icon' => 'contact_support', 'bg' => 'bg-secondary/10', 'text' => 'text-secondary'],
    'TRAINING' => ['icon' => 'school', 'bg' => 'bg-tertiary/10', 'text' => 'text-tertiary'],
    'COMPOST' => ['icon' => 'eco', 'bg' => 'bg-green-100', 'text' => 'text-green-600'],
];
?>

<!-- Hero Section -->
<section class="mb-8 px-2 animate-slide-up">
    <span class="text-secondary font-black tracking-[0.25em] text-[9px] uppercase mb-2 block headline opacity-70">Eco-System Services</span>
    <h2 class="text-3xl font-black text-on-surface tracking-tighter mb-4 leading-none headline">Solusi <br><span class="text-primary">Berkelanjutan.</span></h2>
    <p class="text-on-surface-variant text-xs font-bold leading-relaxed">Layanan pengelolaan limbah premium untuk gaya hidup ramah lingkungan.</p>
</section>

<!-- Services Grid -->
    <div class="grid grid-cols-1 gap-4 pb-32 px-2 animate-slide-up" style="animation-delay: 0.1s">
    <?php if (empty($services)): ?>
        <div class="col-span-full py-24 text-center bg-white rounded-[2.5rem] border border-primary/5 shadow-xl">
            <span class="material-symbols-outlined text-5xl text-primary/20 mb-4">inventory_2</span>
            <p class="text-outline font-black text-xs uppercase tracking-widest">Layanan belum tersedia.</p>
        </div>
    <?php else: ?>
        <?php foreach ($services as $srv): 
            $style = $icons[$srv['type']] ?? ['icon' => 'category', 'bg' => 'bg-surface-container', 'text' => 'text-outline'];
        ?>
            <div class="bg-white p-4 rounded-[1.5rem] border border-primary/5 shadow-[0_8px_30px_rgb(0,0,0,0.04)] hover:shadow-xl transition-all group relative overflow-hidden">
                <!-- Abstract corner element -->
                <div class="absolute -right-8 -top-8 w-20 h-20 bg-primary/5 rounded-full blur-2xl"></div>

                <div class="flex justify-between items-center mb-3 relative z-10">
                    <div class="w-10 h-10 <?php echo $style['bg']; ?> <?php echo $style['text']; ?> rounded-xl flex items-center justify-center transition-transform group-hover:scale-110 duration-500">
                        <span class="material-symbols-outlined text-xl font-bold"><?php echo $style['icon']; ?></span>
                    </div>
                    <span class="px-2.5 py-1 bg-surface-container-highest text-[8px] font-black text-outline rounded-full uppercase tracking-widest"><?php echo $srv['type']; ?></span>
                </div>
                
                <h3 class="text-base font-black text-on-surface mb-1 headline tracking-tight leading-tight relative z-10"><?php echo htmlspecialchars($srv['name']); ?></h3>
                <p class="text-on-surface-variant text-[10px] font-bold leading-relaxed mb-4 relative z-10 opacity-80 line-clamp-2">
                    <?php echo htmlspecialchars($srv['description'] ?: 'Layanan profesional untuk lingkungan yang lebih baik.'); ?>
                </p>

                <div class="relative z-10">
                    <?php 
                    $raw_wa = $global_settings['wa_cs_number'] ?? '6281234567890';
                    $clean_wa = preg_replace('/[^0-9]/', '', $raw_wa);
                    ?>
                    <a href="https://wa.me/<?php echo $clean_wa; ?>?text=Halo, saya ingin tanya tentang layanan <?php echo urlencode($srv['name']); ?>" 
                       target="_blank"
                       class="btn-premium w-full no-underline !shadow-none hover:!shadow-lg transition-all !h-10 !text-[11px] flex justify-center py-2.5">
                        <span class="material-symbols-outlined font-black text-[14px]">chat</span>
                         Hubungi Admin
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
