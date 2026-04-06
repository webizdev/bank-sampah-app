<?php
require_once __DIR__ . '/db_connect.php';

// Authentication Check
$current_page = basename($_SERVER['PHP_SELF']);
$current_dir = basename(dirname($_SERVER['PHP_SELF']));
$public_pages = ['login.php', 'register.php', 'index.php'];

// Base URL detection for assets
$path_to_root = ($current_dir == 'user' || $current_dir == 'admin') ? '../' : './';

if (!isset($_SESSION['user_id']) && !in_array($current_page, $public_pages)) {
    header('Location: ' . $path_to_root . 'login.php');
    exit;
}

// Role-based protection
if (isset($_SESSION['user_id'])) {
    $role = $_SESSION['user_role'] ?? 'USER';
    if ($current_dir == 'admin' && $role !== 'ADMIN') {
        header('Location: ' . $path_to_root . 'user/dashboard.php');
        exit;
    }
    if ($current_dir == 'user' && $role == 'ADMIN') {
        header('Location: ' . $path_to_root . 'admin/dashboard.php');
        exit;
    }

    // Fetch latest user data (for avatar, etc.)
    try {
        $stmt_u = $pdo->prepare("SELECT name, avatar_url FROM users WHERE id = ?");
        $stmt_u->execute([$_SESSION['user_id']]);
        $user_meta = $stmt_u->fetch();
        if ($user_meta) {
            $_SESSION['user_name'] = $user_meta['name'];
            $_SESSION['user_avatar'] = $user_meta['avatar_url'];
        }
    } catch (Exception $e) {}
}

// Fetch Settings safely
$global_settings = ['app_name' => 'The Organic Breath', 'wa_cs_number' => '6281234567890'];
try {
    $stmt_settings = $pdo->query("SELECT setting_key, setting_value FROM settings");
    if ($stmt_settings) {
        $raw = $stmt_settings->fetchAll(PDO::FETCH_ASSOC);
        foreach ($raw as $s) {
            $global_settings[$s['setting_key']] = $s['setting_value'];
        }
    }
} catch (Exception $e) {}
$app_name = $global_settings['app_name'] ?? 'The Organic Breath';

// Variables for layout
$is_authenticated = isset($_SESSION['user_id']);
?>
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo htmlspecialchars($app_name); ?></title>
    
    <!-- PWA & Mobile Optimization -->
    <link rel="manifest" href="<?php echo $path_to_root; ?>manifest.json">
    <meta name="theme-color" content="#0f5238">
    <link rel="apple-touch-icon" href="<?php echo $path_to_root; ?>assets/pwa-icon-192.png">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <!-- Compiled Tailwind CSS (Production) -->
    <link rel="stylesheet" href="<?php echo $path_to_root; ?>css/output.css">
    <link rel="stylesheet" href="<?php echo $path_to_root; ?>css/style.css">
    
    <script>
        const API_BASE = '<?php echo $path_to_root; ?>api/';

        // Service Worker Registration
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('<?php echo $path_to_root; ?>sw.js')
                    .then(reg => console.log('SW Registered'))
                    .catch(err => console.log('SW Error: ', err));
            });
        }

        // PWA Install Logic
        let deferredPrompt;
        window.addEventListener('beforeinstallprompt', (e) => {
            e.preventDefault();
            deferredPrompt = e;
            
            // Check if we should show the prompt (flag set after registration)
            if (localStorage.getItem('show_pwa_prompt') === 'true') {
                showPwaInstallPrompt();
            }
        });

        function showPwaInstallPrompt() {
            const prompt = document.getElementById('pwa-install-prompt');
            if (prompt) {
                prompt.classList.remove('hidden');
                setTimeout(() => {
                    prompt.classList.add('translate-y-0');
                    prompt.classList.remove('translate-y-full');
                }, 100);
            }
        }

        function handlePwaChoice(choice) {
            const prompt = document.getElementById('pwa-install-prompt');
            if (choice === 'install' && deferredPrompt) {
                deferredPrompt.prompt();
                deferredPrompt.userChoice.then((choiceResult) => {
                    if (choiceResult.outcome === 'accepted') {
                        console.log('User accepted the install prompt');
                    }
                    deferredPrompt = null;
                });
            }
            
            // Hide and clear flag
            if (prompt) {
                prompt.classList.add('translate-y-full');
                prompt.classList.remove('translate-y-0');
                setTimeout(() => prompt.classList.add('hidden'), 500);
            }
            localStorage.removeItem('show_pwa_prompt');
        }
    </script>
    
    <!-- Elegant PWA Install Prompt -->
    <div id="pwa-install-prompt" class="fixed bottom-6 left-4 right-4 z-[9999] hidden transform translate-y-full transition-transform duration-500 ease-out">
        <div class="bg-white/80 backdrop-blur-xl border border-white/20 rounded-2xl shadow-2xl p-5 flex flex-col md:flex-row items-center gap-4 max-w-md mx-auto">
            <div class="w-12 h-12 bg-primary rounded-xl flex items-center justify-center flex-shrink-0 shadow-lg">
                <span class="material-symbols-outlined text-white text-2xl">install_mobile</span>
            </div>
            <div class="flex-1 text-center md:text-left">
                <h4 class="text-sm font-bold text-on-surface">Install Aplikasi Sekarang</h4>
                <p class="text-xs text-on-surface-variant mt-1 leading-relaxed">
                    Nikmati pengalaman terbaik mengelola sampah dengan aplikasi Bank Sampah.
                </p>
            </div>
            <div class="flex items-center gap-2 w-full md:w-auto mt-2 md:mt-0">
                <button onclick="handlePwaChoice('cancel')" class="flex-1 md:flex-none px-4 py-2 text-xs font-medium text-on-surface-variant hover:bg-black/5 rounded-lg transition-colors">
                    Nanti
                </button>
                <button onclick="handlePwaChoice('install')" class="flex-2 md:flex-none px-5 py-2 text-xs font-bold text-white bg-primary hover:bg-primary/90 rounded-lg shadow-lg shadow-primary/20 transition-all hover:scale-105 active:scale-95 pulse-slow">
                    Ya, Pasang
                </button>
            </div>
        </div>
    </div>
    
    <style>
        .pulse-slow {
            animation: pulse-ring 3s cubic-bezier(0.4, 0, 0.6, 1) infinite;
        }
        @keyframes pulse-ring {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.9; transform: scale(1.02); }
        }
    </style>
</head>
<body class="bg-surface selection:bg-primary-container selection:text-primary font-sans text-on-surface">

<?php
// Layout Configuration
$is_user_app = ($current_dir == 'user');
$is_admin = ($current_dir == 'admin');
$is_onboarding = ($current_page == 'index.php' && $current_dir !== 'user' && $current_dir !== 'admin');

if ($is_user_app) {
    $container_class = "max-w-md mx-auto bg-surface min-h-screen relative shadow-2xl shadow-black/5 flex flex-col pt-8 px-6 pb-32";
} else {
    $container_class = "w-full bg-surface min-h-screen relative flex flex-col";
}
?>
<div class="<?php echo $container_class; ?>">
    
    <?php if ($is_user_app && (!isset($hide_nav) || !$hide_nav)): ?>
    <!-- Premium Compact Header (User App Only) -->
    <header class="flex justify-between items-center mb-6 w-full animate-fade-in px-2 pt-2">
        <div class="flex flex-col">
            <h1 class="headline text-lg font-extrabold tracking-tighter leading-none flex items-center gap-2">
                <span class="w-1.5 h-1.5 bg-primary rounded-full"></span>
                <?php echo htmlspecialchars($app_name); ?>
            </h1>
            <span class="text-[8px] font-black tracking-[0.2em] text-outline uppercase mt-1 opacity-70">Empowering Ecology</span>
        </div>
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-full bg-white border border-primary/5 shadow-sm p-0.5 flex items-center justify-center overflow-hidden">
                 <?php 
                 $avatar_path = $_SESSION['user_avatar'] ?? '';
                 // Normalize existing paths and handle directories
                 $display_avatar = ($avatar_path) ? $path_to_root . str_replace('../', '', $avatar_path) : "https://ui-avatars.com/api/?name=".urlencode($_SESSION['user_name'] ?? 'U')."&background=0f5238&color=fff";
                 ?>
                 <img src="<?php echo $display_avatar; ?>" alt="User" class="w-full h-full rounded-full object-cover">
            </div>
        </div>
    </header>

    <?php endif; ?>
