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
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    
    <!-- Tailwind CSS (CDN for Dev) -->
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="<?php echo $path_to_root; ?>css/style.css">
    
    <script>
        tailwind.config = {
          theme: {
            extend: {
              colors: {
                primary: '#0f5238',
                'primary-container': '#d3e8d3',
                secondary: '#426456',
                'secondary-container': '#c4eada',
                tertiary: '#3b6470',
                error: '#ba1a1a',
                surface: '#f7fbf2',
                'on-surface': '#191d19',
                'on-surface-variant': '#414941',
                outline: '#717970',
                'surface-container-low': '#f0f5ec',
                'surface-container': '#ecf0e7',
                'surface-container-high': '#e6eade',
              },
              fontFamily: {
                sans: ['"Plus Jakarta Sans"', 'sans-serif'],
                headline: ['Manrope', 'sans-serif'],
              },
            }
          }
        }
        const API_BASE = '<?php echo $path_to_root; ?>api/';
    </script>
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
