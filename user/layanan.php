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
<section class="mb-12">
    <span class="text-secondary font-black tracking-[0.2em] text-[10px] uppercase mb-3 block headline">Eco-System Services</span>
    <h2 class="text-4xl font-black text-on-surface tracking-tight mb-4 leading-tight headline">Solusi Berkelanjutan untuk <br><span class="text-primary">Masa Depan Bumi.</span></h2>
    <p class="text-on-surface-variant max-w-xl text-lg font-medium leading-relaxed">Pilih layanan pengelolaan limbah premium yang dirancang untuk mendukung gaya hidup ramah lingkungan Anda.</p>
</section>

<!-- Services Grid -->
<div class="grid grid-cols-1 md:grid-cols-2 gap-6 pb-32">
    <?php if (empty($services)): ?>
        <div class="col-span-full py-20 text-center bg-surface-container rounded-[2rem] border border-dashed border-outline/20">
            <span class="material-symbols-outlined text-4xl text-outline mb-4">inventory_2</span>
            <p class="text-outline font-bold italic">Layanan belum tersedia saat ini.</p>
        </div>
    <?php else: ?>
        <?php foreach ($services as $srv): 
            $style = $icons[$srv['type']] ?? ['icon' => 'category', 'bg' => 'bg-surface-container', 'text' => 'text-outline'];
        ?>
            <div class="bg-white p-8 rounded-[2rem] border border-primary/5 shadow-xl hover:shadow-2xl transition-all group flex flex-col">
                <div class="flex justify-between items-start mb-8">
                    <div class="w-16 h-16 <?php echo $style['bg']; ?> <?php echo $style['text']; ?> rounded-2xl flex items-center justify-center transition-transform group-hover:scale-110 duration-500">
                        <span class="material-symbols-outlined text-3xl"><?php echo $style['icon']; ?></span>
                    </div>
                    <span class="px-4 py-1.5 bg-surface-container text-[9px] font-black text-outline rounded-full uppercase tracking-widest"><?php echo $srv['type']; ?></span>
                </div>
                
                <h3 class="text-2xl font-black text-on-surface mb-3 headline"><?php echo htmlspecialchars($srv['name']); ?></h3>
                <p class="text-on-surface-variant text-sm font-medium leading-relaxed mb-8 flex-grow">
                    <?php echo htmlspecialchars($srv['description'] ?: 'Nikmati layanan profesional kami untuk pengelolaan lingkungan yang lebih baik.'); ?>
                </p>

                <div class="pt-6 border-t border-primary/5">
                    <?php 
                    $raw_wa = $global_settings['wa_cs_number'] ?? '6281234567890';
                    $clean_wa = preg_replace('/[^0-9]/', '', $raw_wa);
                    ?>
                    <a href="https://wa.me/<?php echo $clean_wa; ?>?text=Halo, saya ingin tanya tentang layanan <?php echo urlencode($srv['name']); ?>" 
                       target="_blank"
                       class="inline-flex items-center gap-2 text-primary font-black text-xs uppercase tracking-widest group-hover:gap-4 transition-all">
                        Hubungi Admin
                        <span class="material-symbols-outlined text-[18px]">arrow_right_alt</span>
                    </a>
                </div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<?php include '../includes/footer.php'; ?>
