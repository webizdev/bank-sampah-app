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
<section class="mb-12 px-2 animate-slide-up">
    <span class="text-secondary font-black tracking-[0.25em] text-[10px] uppercase mb-3 block headline opacity-70">Eco-System Services</span>
    <h2 class="text-4xl font-black text-on-surface tracking-tighter mb-5 leading-none headline">Solusi <br><span class="text-primary">Berkelanjutan.</span></h2>
    <p class="text-on-surface-variant text-sm font-bold leading-relaxed">Pilih layanan pengelolaan limbah premium yang dirancang untuk mendukung gaya hidup ramah lingkungan Anda.</p>
</section>

<!-- Services Grid -->
<div class="grid grid-cols-1 gap-6 pb-40 px-2 animate-slide-up" style="animation-delay: 0.1s">
    <?php if (empty($services)): ?>
        <div class="col-span-full py-24 text-center bg-white rounded-[2.5rem] border border-primary/5 shadow-xl">
            <span class="material-symbols-outlined text-5xl text-primary/20 mb-4">inventory_2</span>
            <p class="text-outline font-black text-xs uppercase tracking-widest">Layanan belum tersedia.</p>
        </div>
    <?php else: ?>
        <?php foreach ($services as $srv): 
            $style = $icons[$srv['type']] ?? ['icon' => 'category', 'bg' => 'bg-surface-container', 'text' => 'text-outline'];
        ?>
            <div class="bg-white p-8 rounded-[2.5rem] border border-primary/5 shadow-xl hover:shadow-2xl transition-all group flex flex-col relative overflow-hidden">
                <!-- Abstract corner element -->
                <div class="absolute -right-8 -top-8 w-24 h-24 bg-primary/5 rounded-full blur-2xl"></div>

                <div class="flex justify-between items-start mb-8 relative z-10">
                    <div class="w-16 h-16 <?php echo $style['bg']; ?> <?php echo $style['text']; ?> rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110 duration-500">
                        <span class="material-symbols-outlined text-3xl font-bold"><?php echo $style['icon']; ?></span>
                    </div>
                    <span class="px-4 py-1.5 bg-surface-container-highest text-[9px] font-black text-outline rounded-full uppercase tracking-widest"><?php echo $srv['type']; ?></span>
                </div>
                
                <h3 class="text-2xl font-black text-on-surface mb-3 headline tracking-tight leading-tight relative z-10"><?php echo htmlspecialchars($srv['name']); ?></h3>
                <p class="text-on-surface-variant text-sm font-bold leading-relaxed mb-10 flex-grow relative z-10 opacity-80">
                    <?php echo htmlspecialchars($srv['description'] ?: 'Nikmati layanan profesional kami untuk pengelolaan lingkungan yang lebih baik.'); ?>
                </p>

                <div class="pt-8 border-t border-primary/5 mt-auto relative z-10">
                    <?php 
                    $raw_wa = $global_settings['wa_cs_number'] ?? '6281234567890';
                    $clean_wa = preg_replace('/[^0-9]/', '', $raw_wa);
                    ?>
                    <a href="https://wa.me/<?php echo $clean_wa; ?>?text=Halo, saya ingin tanya tentang layanan <?php echo urlencode($srv['name']); ?>" 
                       target="_blank"
                       class="btn-premium w-full no-underline !shadow-none hover:!shadow-lg transition-all">
                        <span class="material-symbols-outlined font-black text-[18px]">chat</span>
                         Hubungi Admin
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>

<?php include '../includes/footer.php'; ?>
