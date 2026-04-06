    </div><!-- End of .container-class opened in header.php -->

    <?php if ((!isset($hide_nav) || !$hide_nav) && empty($is_admin)): ?>
    <!-- Premium Bottom Navigation Dock -->
    <nav class="bottom-dock px-3">
        <a href="<?php echo $path_to_root; ?>user/dashboard.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'active' : ''; ?>">
            <span class="material-symbols-outlined">home</span>
            <span class="nav-label">Home</span>
        </a>
        <a href="<?php echo $path_to_root; ?>user/layanan.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'layanan.php' ? 'active' : ''; ?>">
            <span class="material-symbols-outlined">auto_awesome_motion</span>
            <span class="nav-label">Layanan</span>
        </a>
        
        <!-- Central FAB: Craft Catalog -->
        <div class="relative -top-10">
            <a href="<?php echo $path_to_root; ?>user/craft.php" 
               class="w-18 h-18 bg-primary text-white rounded-full flex items-center justify-center shadow-[0_15px_40px_rgba(15,82,56,0.3)] active:scale-90 transition-all border-[6px] border-surface">
                <span class="material-symbols-outlined text-[34px] font-black">palette</span>
            </a>
        </div>

        <a href="<?php echo $path_to_root; ?>user/jual.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'jual.php' ? 'active' : ''; ?>">
            <span class="material-symbols-outlined">shopping_cart</span>
            <span class="nav-label">Jual</span>
        </a>
        <a href="<?php echo $path_to_root; ?>user/profile.php" class="nav-item <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'active' : ''; ?>">
            <span class="material-symbols-outlined">person</span>
            <span class="nav-label">Profil</span>
        </a>
    </nav>
    <style>
        .w-18 { width: 4.5rem; }
        .h-18 { height: 4.5rem; }
    </style>
    <?php endif; ?>

    <?php if (!empty($global_settings['wa_cs_number']) && empty($is_admin) && !empty($hide_nav)): ?>
    <!-- Floating WhatsApp CTA -->
    <a href="https://wa.me/<?php echo urlencode(preg_replace('/[^0-9]/', '', $global_settings['wa_cs_number'])); ?>?text=Halo%20<?php echo urlencode($app_name); ?>%2C%20saya%20ingin%20bertanya..." 
       target="_blank" 
       class="fixed bottom-6 right-6 md:bottom-10 md:right-10 w-14 h-14 bg-green-500 text-white rounded-full flex items-center justify-center shadow-2xl hover:scale-110 active:scale-95 transition-all z-[100] border-2 border-white ring-4 ring-green-500/20">
        <span class="material-symbols-outlined text-[28px]">chat</span>
    </a>
    <?php endif; ?>

    <script src="<?php echo $path_to_root; ?>js/app.js"></script>
</body>
</html>
