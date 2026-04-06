<?php
$current_page = basename($_SERVER['PHP_SELF']);
?>
<aside class="fixed left-0 top-0 h-screen w-64 bg-white border-r border-primary/5 shadow-xl z-[60] flex flex-col">
    <div class="px-8 py-8 flex items-center gap-3 border-b border-primary/5">
        <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white shadow-lg shadow-primary/20">
            <span class="material-symbols-outlined">recycling</span>
        </div>
        <div>
            <h1 class="text-lg font-black text-primary headline tracking-tight leading-none">Organic</h1>
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
