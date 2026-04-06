    <?php if ((!isset($hide_nav) || !$hide_nav) && empty($is_admin)): ?>
    <!-- Premium Bottom Navigation -->
    <nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-md bg-white/80 backdrop-blur-xl border-t border-primary/5 flex justify-around items-center h-20 px-4 z-50 rounded-t-3xl shadow-2xl shadow-black/10">
        <a href="<?php echo $path_to_root; ?>user/dashboard.php" class="flex flex-col items-center gap-1 group">
            <span class="material-symbols-outlined text-[24px] <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'text-primary' : 'text-outline'; ?> group-active:scale-90 transition-transform">home</span>
            <span class="text-[9px] font-black uppercase tracking-widest <?php echo basename($_SERVER['PHP_SELF']) == 'dashboard.php' ? 'text-primary' : 'text-outline'; ?>">Home</span>
        </a>
        <a href="<?php echo $path_to_root; ?>user/jual.php" class="flex flex-col items-center gap-1 group">
            <span class="material-symbols-outlined text-[24px] <?php echo basename($_SERVER['PHP_SELF']) == 'jual.php' ? 'text-primary' : 'text-outline'; ?> group-active:scale-90 transition-transform">recycling</span>
            <span class="text-[9px] font-black uppercase tracking-widest <?php echo basename($_SERVER['PHP_SELF']) == 'jual.php' ? 'text-primary' : 'text-outline'; ?>">Jual</span>
        </a>
        
        <!-- FAB: Craft Catalog -->
        <div class="relative -top-10">
            <a href="<?php echo $path_to_root; ?>user/craft.php" class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center shadow-2xl shadow-primary/40 active:scale-90 transition-all border-4 border-white">
                <span class="material-symbols-outlined text-[32px]">palette</span>
            </a>
        </div>

        <a href="<?php echo $path_to_root; ?>user/layanan.php" class="flex flex-col items-center gap-1 group">
            <span class="material-symbols-outlined text-[24px] <?php echo basename($_SERVER['PHP_SELF']) == 'layanan.php' ? 'text-primary' : 'text-outline'; ?> group-active:scale-90 transition-transform">volunteer_activism</span>
            <span class="text-[9px] font-black uppercase tracking-widest <?php echo basename($_SERVER['PHP_SELF']) == 'layanan.php' ? 'text-primary' : 'text-outline'; ?>">Layanan</span>
        </a>
        <a href="<?php echo $path_to_root; ?>user/profile.php" class="flex flex-col items-center gap-1 group">
            <span class="material-symbols-outlined text-[24px] <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'text-primary' : 'text-outline'; ?> group-active:scale-90 transition-transform">person</span>
            <span class="text-[9px] font-black uppercase tracking-widest <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'text-primary' : 'text-outline'; ?>">Profil</span>
        </a>
    </nav>
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

</body>
</html>
