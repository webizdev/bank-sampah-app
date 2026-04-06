    </div> <!-- End of max-w-md -->

    <?php if (!isset($hide_nav) || !$hide_nav): ?>
    <!-- Premium Bottom Navigation -->
    <nav class="fixed bottom-0 left-1/2 -translate-x-1/2 w-full max-w-md bg-white/80 backdrop-blur-xl border-t border-primary/5 flex justify-around items-center h-20 px-4 z-50 rounded-t-3xl shadow-2xl shadow-black/10">
        <a href="index.php" class="flex flex-col items-center gap-1 group">
            <span class="material-symbols-outlined text-[24px] <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'text-primary' : 'text-outline'; ?> group-active:scale-90 transition-transform">home</span>
            <span class="text-[9px] font-black uppercase tracking-widest <?php echo basename($_SERVER['PHP_SELF']) == 'index.php' ? 'text-primary' : 'text-outline'; ?>">Home</span>
        </a>
        <a href="jual.php" class="flex flex-col items-center gap-1 group">
            <span class="material-symbols-outlined text-[24px] <?php echo basename($_SERVER['PHP_SELF']) == 'jual.php' ? 'text-primary' : 'text-outline'; ?> group-active:scale-90 transition-transform">storefront</span>
            <span class="text-[9px] font-black uppercase tracking-widest <?php echo basename($_SERVER['PHP_SELF']) == 'jual.php' ? 'text-primary' : 'text-outline'; ?>">Beli</span>
        </a>
        
        <!-- FAB: Quick Sell -->
        <div class="relative -top-10">
            <a href="jual.php" class="w-16 h-16 bg-primary text-white rounded-full flex items-center justify-center shadow-2xl shadow-primary/40 active:scale-90 transition-all border-4 border-white">
                <span class="material-symbols-outlined text-[32px]">add</span>
            </a>
        </div>

        <a href="layanan.php" class="flex flex-col items-center gap-1 group">
            <span class="material-symbols-outlined text-[24px] <?php echo basename($_SERVER['PHP_SELF']) == 'layanan.php' ? 'text-primary' : 'text-outline'; ?> group-active:scale-90 transition-transform">eco</span>
            <span class="text-[9px] font-black uppercase tracking-widest <?php echo basename($_SERVER['PHP_SELF']) == 'layanan.php' ? 'text-primary' : 'text-outline'; ?>">Layanan</span>
        </a>
        <a href="profile.php" class="flex flex-col items-center gap-1 group">
            <span class="material-symbols-outlined text-[24px] <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'text-primary' : 'text-outline'; ?> group-active:scale-90 transition-transform">person</span>
            <span class="text-[9px] font-black uppercase tracking-widest <?php echo basename($_SERVER['PHP_SELF']) == 'profile.php' ? 'text-primary' : 'text-outline'; ?>">Profil</span>
        </a>
    </nav>
    <?php endif; ?>

</body>
</html>
