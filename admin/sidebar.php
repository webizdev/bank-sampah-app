<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<!-- Mobile Overlay -->
<div id="admin-overlay" class="fixed inset-0 bg-black/50 backdrop-blur-sm z-[55] hidden md:hidden transition-opacity opacity-0" onclick="toggleSidebar()"></div>

<aside id="admin-sidebar" class="fixed left-0 top-0 h-screen w-64 bg-white border-r border-primary/5 shadow-2xl z-[60] flex flex-col transform -translate-x-full md:translate-x-0 transition-transform duration-300">
    <div class="px-8 py-8 flex items-center gap-3 border-b border-primary/5">
        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/20">
            <span class="material-symbols-outlined">recycling</span>
        </div>
        <div>
            <h1 class="text-lg font-black text-primary headline tracking-tight leading-none"><?php echo htmlspecialchars($app_name); ?></h1>
            <p class="text-[9px] font-bold text-outline uppercase tracking-widest mt-1">Admin Panel</p>
        </div>
    </div>

    <nav class="flex-1 px-4 py-8 space-y-2 overflow-y-auto">
        <a href="dashboard.php" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all <?php echo $current_page == 'dashboard.php' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-outline hover:bg-primary/5 hover:text-primary'; ?>">
            <span class="material-symbols-outlined">dashboard</span>
            <span class="text-sm font-bold">Verification</span>
        </a>
        <a href="categories.php" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all <?php echo $current_page == 'categories.php' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-outline hover:bg-primary/5 hover:text-primary'; ?>">
            <span class="material-symbols-outlined">category</span>
            <span class="text-sm font-bold">Produk</span>
        </a>
        <a href="crafts.php" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all <?php echo $current_page == 'crafts.php' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-outline hover:bg-primary/5 hover:text-primary'; ?>">
            <span class="material-symbols-outlined">palette</span>
            <span class="text-sm font-bold">Katalog Craft</span>
        </a>
        <a href="inventory.php" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all <?php echo $current_page == 'inventory.php' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-outline hover:bg-primary/5 hover:text-primary'; ?>">
            <span class="material-symbols-outlined">inventory_2</span>
            <span class="text-sm font-bold">Inventori</span>
        </a>
        <a href="sales.php" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all <?php echo $current_page == 'sales.php' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-outline hover:bg-primary/5 hover:text-primary'; ?>">
            <span class="material-symbols-outlined">point_of_sale</span>
            <span class="text-sm font-bold">Penjualan</span>
        </a>
        <a href="articles.php" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all <?php echo $current_page == 'articles.php' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-outline hover:bg-primary/5 hover:text-primary'; ?>">
            <span class="material-symbols-outlined">newspaper</span>
            <span class="text-sm font-bold">Artikel & Event</span>
        </a>
        <a href="services.php" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all <?php echo $current_page == 'services.php' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-outline hover:bg-primary/5 hover:text-primary'; ?>">
            <span class="material-symbols-outlined">volunteer_activism</span>
            <span class="text-sm font-bold">Services</span>
        </a>
        <a href="users.php" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all <?php echo $current_page == 'users.php' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-outline hover:bg-primary/5 hover:text-primary'; ?>">
            <span class="material-symbols-outlined">group</span>
            <span class="text-sm font-bold">User Data</span>
        </a>
        <a href="transactions.php" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all <?php echo $current_page == 'transactions.php' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-outline hover:bg-primary/5 hover:text-primary'; ?>">
            <span class="material-symbols-outlined">receipt_long</span>
            <span class="text-sm font-bold">History & Reports</span>
        </a>
        <a href="settings.php" class="flex items-center gap-4 px-4 py-4 rounded-2xl transition-all <?php echo $current_page == 'settings.php' ? 'bg-primary text-white shadow-lg shadow-primary/20' : 'text-outline hover:bg-primary/5 hover:text-primary'; ?>">
            <span class="material-symbols-outlined">settings</span>
            <span class="text-sm font-bold">Organisasi</span>
        </a>
    </nav>

    <div class="p-4 border-t border-primary/5">
        <div class="px-4 py-4 bg-surface-container-low rounded-2xl flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-[10px] font-black text-primary">
                <?php echo strtoupper(substr($_SESSION['user_name'], 0, 1)); ?>
            </div>
            <div class="flex-1 overflow-hidden">
                <p class="text-[10px] font-black text-on-surface truncate"><?php echo $_SESSION['user_name']; ?></p>
                <p class="text-[8px] font-bold text-outline uppercase">Administrator</p>
            </div>
            <a href="../logout.php" class="text-outline hover:text-red-500 transition-colors">
                <span class="material-symbols-outlined text-[18px]">logout</span>
            </a>
        </div>
    </div>
</aside>

<script>
function toggleSidebar() {
    const sidebar = document.getElementById('admin-sidebar');
    const overlay = document.getElementById('admin-overlay');
    
    if (sidebar.classList.contains('-translate-x-full')) {
        // Show
        sidebar.classList.remove('-translate-x-full');
        overlay.classList.remove('hidden');
        // Small delay to allow display:block to apply before opacity transition
        setTimeout(() => overlay.classList.remove('opacity-0'), 10);
    } else {
        // Hide
        sidebar.classList.add('-translate-x-full');
        overlay.classList.add('opacity-0');
        setTimeout(() => overlay.classList.add('hidden'), 300);
    }
}

document.addEventListener('DOMContentLoaded', () => {
    // Inject Hamburger Menu
    const headers = document.querySelectorAll('header');
    headers.forEach(header => {
        let wrapper = header.querySelector('div');
        
        // If there's no wrapper div, but there is an h1 directly inside header (like inventory.php or sales.php)
        if (!wrapper && header.querySelector('h1')) {
            wrapper = document.createElement('div');
            // Move title inside
            const h1 = header.querySelector('h1');
            header.insertBefore(wrapper, h1);
            wrapper.appendChild(h1);
            
            // Also append paragraph if exists
            const p = header.querySelector('p');
            if (p) wrapper.appendChild(p);
        }

        if (wrapper && !document.querySelector('.admin-hamburger')) {
            wrapper.classList.add('flex', 'items-start', 'md:items-center', 'gap-3');
            
            const btn = document.createElement('button');
            btn.innerHTML = '<span class="material-symbols-outlined shrink-0 text-[1.25rem]">menu</span>';
            btn.className = 'admin-hamburger md:hidden p-2 -ml-2 bg-primary/5 text-primary rounded-xl flex items-center justify-center hover:bg-primary/10 transition-colors shadow-sm shrink-0 leading-none h-fit';
            btn.onclick = toggleSidebar;
            
            // Create a sub wrapper for the text
            const textWrapperInner = document.createElement('div');
            while (wrapper.firstChild) {
                textWrapperInner.appendChild(wrapper.firstChild);
            }
            wrapper.appendChild(btn);
            wrapper.appendChild(textWrapperInner);
        }
    });
});
</script>
