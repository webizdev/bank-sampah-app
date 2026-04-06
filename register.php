<?php
// Register Page
$hide_nav = true; // Flag for header to hide standard nav
require_once 'includes/db_connect.php';

// Redirect if already logged in
if (isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

include 'includes/header.php';
?>

<div class="min-h-[80vh] flex flex-col justify-center py-12 px-6">
    <div class="sm:mx-auto sm:w-full sm:max-w-md">
        <div class="flex justify-center mb-8">
            <div class="w-16 h-16 bg-primary text-white rounded-2xl flex items-center justify-center shadow-2xl shadow-primary/20 rotate-3">
                <span class="material-symbols-outlined text-4xl">eco</span>
            </div>
        </div>
        <h2 class="text-center text-3xl font-extrabold text-on-surface headline tracking-tight">Bergabung dengan <br><span class="text-primary italic">The Organic Breath</span></h2>
        <p class="mt-2 text-center text-sm text-on-surface-variant font-medium">Mulailah langkah kecil untuk bumi yang lebih hijau.</p>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-md">
        <form id="register-form" class="space-y-6">
            <div>
                <label for="name" class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-2">Nama Lengkap</label>
                <input id="name" name="name" type="text" required placeholder="Contoh: Aris Setiawan"
                       class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary text-on-surface placeholder:text-outline/50 transition-all">
            </div>

            <div>
                <label for="email" class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-2">Alamat Email</label>
                <input id="email" name="email" type="email" required placeholder="your@email.com"
                       class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary text-on-surface placeholder:text-outline/50 transition-all">
            </div>

            <div>
                <label for="password" class="block text-xs font-bold uppercase tracking-widest text-on-surface-variant mb-2">Password</label>
                <input id="password" name="password" type="password" required placeholder="••••••••"
                       class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary text-on-surface placeholder:text-outline/50 transition-all">
            </div>

            <div>
                <button type="submit" class="w-full btn-primary py-4 font-bold tracking-tight text-lg shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">
                    Daftar Sekarang
                </button>
            </div>
        </form>

        <p class="mt-10 text-center text-sm text-on-surface-variant font-medium">
            Sudah punya akun? 
            <a href="login.php" class="font-bold text-primary border-b border-primary/20 pb-1 hover:border-primary transition-all">Masuk di sini</a>
        </p>
    </div>
</div>

<script>
document.getElementById('register-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());

    try {
        const response = await fetch('api/register.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });

        const result = await response.json();
        if (result.status === 'success') {
            alert('Pendaftaran berhasil! Silakan masuk.');
            window.location.href = 'login.php';
        } else {
            alert(result.message);
        }
    } catch (err) {
        console.error(err);
        alert('Gagal daftar. Coba lagi nanti.');
    }
});
</script>

<?php include 'includes/footer.php'; ?>
