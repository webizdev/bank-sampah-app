<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'ADMIN') {
    header("Location: ../login.php");
    exit;
}
include '../includes/header.php';
?>

<div class="flex min-h-screen bg-surface">
    <?php include 'sidebar.php'; ?>
    
    <div class="flex-1 md:ml-64 p-4 md:p-8 transition-all duration-300 w-full md:w-auto">
        <header class="mb-4 md:mb-6 md:mb-12">
            <h1 class="text-lg md:text-2xl md:text-4xl font-black text-primary headline tracking-tight mb-2">Pengaturan Organisasi</h1>
            <p class="text-on-surface-variant font-medium">Atur profil Bank Sampah Anda, level poin nasabah, dan sistem utama.</p>
        </header>
        
        <div class="max-w-3xl space-y-8">
            <!-- Organization Settings -->
            <section class="bg-white p-4 md:p-8 rounded-2xl md:rounded-[2rem] shadow-xl shadow-primary/5 border border-primary/10">
                <h2 class="text-sm md:text-lg lg:text-xl font-bold !leading-tight headline mb-4 md:mb-6 text-primary flex items-center gap-2">
                    <span class="material-symbols-outlined">business</span> Profil & Kontak
                </h2>
                <form id="settings-form" class="space-y-6">
                    <div>
                        <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Nama Aplikasi / Organisasi</label>
                        <input type="text" id="app_name" name="app_name" required
                               class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Nomor WhatsApp CS (Tanpa 0 atau +)</label>
                        <input type="number" id="wa_cs_number" name="wa_cs_number" required placeholder="6281234567890"
                               class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                    </div>
                    <div>
                        <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Alamat Fisik</label>
                        <textarea id="address" name="address" rows="3" required
                                  class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-medium"></textarea>
                    </div>

                    <h2 class="text-lg font-bold headline mb-4 text-primary flex items-center gap-2 mt-6">
                        <span class="material-symbols-outlined">share</span> Link Media Sosial
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-3 md:gap-6">
                        <div>
                            <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Instagram (URL)</label>
                            <input type="url" id="social_instagram" name="social_instagram" placeholder="https://instagram.com/..."
                                   class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold text-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Facebook (URL)</label>
                            <input type="url" id="social_facebook" name="social_facebook" placeholder="https://facebook.com/..."
                                   class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold text-sm">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Twitter / X (URL)</label>
                            <input type="url" id="social_twitter" name="social_twitter" placeholder="https://twitter.com/..."
                                   class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold text-sm">
                        </div>
                    </div>

                    <hr class="border-outline/10 my-6">

                    <h2 class="text-sm md:text-lg lg:text-xl font-bold !leading-tight headline mb-4 md:mb-6 text-primary flex items-center gap-2">
                        <span class="material-symbols-outlined">military_tech</span> Konfigurasi Peringkat (Tier)
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Bronze (Min. kg)</label>
                            <input type="number" id="tier_bronze_min" name="tier_bronze_min" required value="0" readonly
                                   class="w-full bg-surface-container/50 border-none rounded-xl px-4 py-4 font-bold text-outline cursor-not-allowed">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Silver (Min. kg)</label>
                            <input type="number" id="tier_silver_min" name="tier_silver_min" required step="0.1"
                                   class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                        </div>
                        <div>
                            <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2">Gold (Min. kg)</label>
                            <input type="number" id="tier_gold_min" name="tier_gold_min" required step="0.1"
                                   class="w-full bg-surface-container border-none rounded-xl px-4 py-4 focus:ring-2 focus:ring-primary font-bold">
                        </div>
                    </div>

                    <div class="pt-4 flex justify-end">
                        <button type="submit" class="bg-primary text-white px-4 md:px-8 py-3 md:py-4 text-xs md:text-sm whitespace-nowrap md:whitespace-normal font-bold rounded-2xl shadow-xl shadow-primary/20 hover:scale-[1.02] active:scale-[0.98] transition-all">Simpan Pengaturan</button>
                    </div>
                </form>
            </section>

            <!-- Danger Zone -->
            <section class="bg-red-50 p-4 md:p-8 rounded-2xl md:rounded-[2rem] border border-red-200">
                <h2 class="text-sm md:text-lg lg:text-xl font-bold !leading-tight headline mb-2 text-red-600 flex items-center gap-2">
                    <span class="material-symbols-outlined">warning</span> Danger Zone
                </h2>
                <p class="text-sm font-medium text-red-500 mb-4 md:mb-6">Aksi di bawah ini tidak dapat dibatalkan. Pastikan Anda berhati-hati.</p>
                
                <div class="flex flex-col md:flex-row md:items-center justify-between p-4 md:p-6 bg-white rounded-2xl border border-red-100 gap-4">
                    <div>
                        <h3 class="font-bold text-on-surface">Reset Inventori & Transaksi</h3>
                        <p class="text-[12px] text-on-surface-variant max-w-sm mt-1">Menghapus semua qty produk (kosongkan stok), menghapus riwayat transaksi, menghapus riwayat penjualan. <strong>Data nama dan whatsapp member tetap aman.</strong> Saldo member jadi 0.</p>
                    </div>
                    <button onclick="promptReset()" class="bg-red-100 text-red-600 px-6 py-3 font-bold rounded-xl hover:bg-red-600 hover:text-white transition-all">
                        Reset Total Sistem
                    </button>
                </div>
            </section>
        </div>
    </div>
</div>

<script>
async function loadSettings() {
    try {
        const res = await fetch('../api/get_settings.php');
        const result = await res.json();
        if (result.status === 'success') {
            const s = result.data;
            document.getElementById('app_name').value = s.app_name || '';
            document.getElementById('wa_cs_number').value = s.wa_cs_number || '';
            document.getElementById('address').value = s.address || '';
            document.getElementById('tier_bronze_min').value = s.tier_bronze_min || 0;
            document.getElementById('tier_silver_min').value = s.tier_silver_min || 50;
            document.getElementById('tier_gold_min').value = s.tier_gold_min || 200;
            
            if (document.getElementById('social_instagram')) document.getElementById('social_instagram').value = s.social_instagram || '';
            if (document.getElementById('social_facebook')) document.getElementById('social_facebook').value = s.social_facebook || '';
            if (document.getElementById('social_twitter')) document.getElementById('social_twitter').value = s.social_twitter || '';
        }
    } catch (e) {
        console.error("Gagal load settings:", e);
    }
}

document.getElementById('settings-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    data.entity = 'settings';
    data.action = 'update';

    try {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await res.json();
        if (result.status === 'success') {
            alert("Pengaturan Organisasi berhasil disimpan!");
            location.reload();
        } else {
            alert("Error: " + result.message);
        }
    } catch (e) {
        alert("Gagal menghubungi server.");
    }
});

async function promptReset() {
    let confirm1 = confirm("⚠️ PERINGATAN KERAS ⚠️\nApakah Anda yakin ingin MELENYAPKAN seluruh stok inventori dan riwayat transaksi?");
    if (!confirm1) return;
    
    let pass = prompt("Untuk melanjutkan, ketik kata sandi Administrator Anda:");
    if (!pass) return;

    try {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ entity: 'system', action: 'reset', password: pass })
        });
        const result = await res.json();
        if (result.status === 'success') {
            alert("✅ Reset Sistem Berhasil! Tabel transaksi dikosongkan dan saldo member menjadi 0.");
            location.reload();
        } else {
            alert("Gagal: " + result.message);
        }
    } catch(e) {
         alert("Gagal menghubungi server.");
    }
}

document.addEventListener('DOMContentLoaded', loadSettings);
</script>

<?php include '../includes/footer.php'; ?>
