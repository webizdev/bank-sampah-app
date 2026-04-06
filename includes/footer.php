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

    <!-- Global Toast Notification System -->
    <div id="toast-container" class="fixed top-4 left-1/2 -translate-x-1/2 z-[9999] flex flex-col gap-2 w-full max-w-sm px-4 pointer-events-none"></div>

    <script>
    window.showToast = function(message, type = 'success') {
        const container = document.getElementById('toast-container');
        const toast = document.createElement('div');
        
        // Premium styling based on type
        const bgColor = type === 'success' ? 'bg-primary' : (type === 'error' ? 'bg-red-600' : 'bg-surface-container-highest');
        const textColor = type === 'success' ? 'text-white' : (type === 'error' ? 'text-white' : 'text-on-surface');
        const icon = type === 'success' ? 'check_circle' : (type === 'error' ? 'error' : 'info');
        
        toast.className = `flex items-center gap-3 p-4 rounded-2xl shadow-2xl ${bgColor} ${textColor} transform transition-all duration-500 translate-y-[-150%] opacity-0 pointer-events-auto border border-white/10`;
        
        toast.innerHTML = `
            <span class="material-symbols-outlined font-black">${icon}</span>
            <p class="text-[11px] font-bold flex-1 leading-relaxed tracking-wide">${message}</p>
            <button onclick="this.parentElement.remove()" class="w-6 h-6 flex items-center justify-center rounded-full hover:bg-white/20 transition-colors">
                <span class="material-symbols-outlined text-[14px]">close</span>
            </button>
        `;
        
        container.appendChild(toast);
        
        // Animate in
        requestAnimationFrame(() => {
            toast.classList.remove('translate-y-[-150%]', 'opacity-0');
            toast.classList.add('translate-y-0', 'opacity-100');
        });
        
        // Auto remove after 4 seconds
        setTimeout(() => {
            if (toast.parentElement) {
                toast.classList.remove('translate-y-0', 'opacity-100');
                toast.classList.add('translate-y-[-150%]', 'opacity-0');
                setTimeout(() => toast.remove(), 500); // Wait for transition
            }
        }, 4000);
    };

    // Override browser's default alert
    window.alert = function(message) {
        const isError = message.toLowerCase().includes('gagal') || message.includes('❌');
        const cleanMessage = message.replace(/✔|❌/g, '').trim();
        showToast(cleanMessage, isError ? 'error' : 'success');
    };
    </script>

    <script src="<?php echo $path_to_root; ?>js/app.js"></script>
</body>
</html>
