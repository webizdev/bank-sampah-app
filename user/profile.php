<?php
include '../includes/header.php';

// Fetch current user data
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$_SESSION['user_id']]);
$u = $stmt->fetch();

if (!$u) {
    echo "User not found.";
    exit;
}

// Calculate Pending Balance
$stmt_pending = $pdo->prepare("SELECT SUM(total_payout) as pending_balance FROM transactions WHERE user_id = ? AND status = 'PENDING'");
$stmt_pending->execute([$_SESSION['user_id']]);
$pending_data = $stmt_pending->fetch();
$saldo_pending = $pending_data['pending_balance'] ?: 0;

// Map Default Coordinates (Jakarta if NULL)
$lat = $u['latitude'] ?: -6.1754;
$lng = $u['longitude'] ?: 106.8272;
?>

<!-- Leaflet CSS -->
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
<!-- Leaflet JS -->
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>

<style>
    #map { height: 250px; border-radius: 1.5rem; z-index: 1; }
    .profile-avatar-wrapper { position: relative; cursor: pointer; }
    .profile-avatar-wrapper:hover .overlay { opacity: 1; }
    .profile-avatar-wrapper .overlay {
        position: absolute; inset: 0; background: rgba(0,0,0,0.4);
        display: flex; items-center; justify-center; opacity: 0;
        transition: opacity 0.3s; border-radius: 9999px;
    }
</style>

<!-- Profile Header -->
<section class="mb-10 flex flex-col items-center text-center relative px-2 animate-fade-in">
    <form id="avatar-form" enctype="multipart/form-data" class="relative">
        <label for="avatar-input" class="profile-avatar-wrapper group block w-32 h-32 rounded-full border-4 border-white shadow-2xl overflow-hidden mb-6 bg-surface-container-highest">
            <img id="avatar-preview" src="<?php echo $u['avatar_url'] ?: 'https://ui-avatars.com/api/?name='.urlencode($u['name']).'&background=0f5238&color=fff&size=128'; ?>" 
                 alt="Profile" class="w-full h-full object-cover">
            <div class="overlay">
                <span class="material-symbols-outlined text-white text-3xl">photo_camera</span>
            </div>
            <input type="file" id="avatar-input" name="avatar" class="hidden" accept="image/*" onchange="uploadAvatar()">
        </label>
    </form>
    
    <div class="space-y-2">
        <h2 class="headline text-2xl font-black text-on-surface tracking-tight leading-none"><?php echo htmlspecialchars($u['name']); ?></h2>
        <div class="flex items-center justify-center gap-2">
            <span class="bg-primary/10 text-primary px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest"><?php echo $u['tier']; ?> Member</span>
            <?php if ($u['organization']): ?>
                <span class="bg-secondary text-white px-3 py-1 rounded-full text-[10px] font-black uppercase tracking-widest shadow-lg shadow-secondary/20"><?php echo htmlspecialchars($u['organization']); ?></span>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- Premium Balance Card -->
<section class="mb-10 animate-slide-up" style="animation-delay: 0.1s">
    <div class="bg-primary rounded-[2.5rem] p-9 shadow-2xl shadow-primary/30 relative overflow-hidden text-white">
        <!-- Abstract Background -->
        <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-16 -mt-16 blur-3xl"></div>
        <div class="absolute bottom-0 left-0 w-32 h-32 bg-secondary/20 rounded-full -ml-16 -mb-16 blur-2xl"></div>
        
        <div class="relative z-10 space-y-8">
            <div class="flex justify-between items-start">
                <div>
                    <span class="text-[10px] font-black uppercase tracking-[0.25em] opacity-60">Saldo Terverifikasi</span>
                    <h3 class="headline text-4xl font-black tracking-tighter mt-2">Rp <?php echo number_format($u['balance'], 0, ',', '.'); ?></h3>
                </div>
                <div class="w-14 h-14 rounded-[1.25rem] bg-white/15 backdrop-blur-lg border border-white/10 flex items-center justify-center">
                    <span class="material-symbols-outlined text-2xl">account_balance_wallet</span>
                </div>
            </div>
            
            <div class="pt-8 border-t border-white/10 grid grid-cols-2 gap-4">
                <div>
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] opacity-60 mb-1 block">Saldo Pending</span>
                    <p class="font-bold text-xl tracking-tight">Rp <?php echo number_format($saldo_pending, 0, ',', '.'); ?></p>
                </div>
                <div class="text-right border-l border-white/10 pl-4">
                    <span class="text-[9px] font-black uppercase tracking-[0.2em] opacity-60 mb-1 block">Kontribusi</span>
                    <p class="font-bold text-xl tracking-tight"><?php echo number_format($u['total_kg'], 1); ?> <span class="text-xs opacity-50 font-normal">kg</span></p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Action Buttons -->
<div class="grid grid-cols-2 gap-4 animate-slide-up" style="animation-delay: 0.2s">
    <button onclick="shareApp()" class="flex flex-col items-center justify-center gap-3 bg-white p-6 rounded-[2rem] border border-primary/5 shadow-lg shadow-black/5 active:scale-95 transition-all">
        <div class="w-12 h-12 bg-primary/10 rounded-2xl flex items-center justify-center text-primary">
            <span class="material-symbols-outlined font-bold">share</span>
        </div>
        <span class="text-[10px] font-black uppercase tracking-widest text-outline">Bagikan</span>
    </button>
    <a href="../logout.php" class="flex flex-col items-center justify-center gap-3 bg-red-50 p-6 rounded-[2rem] border border-red-100 shadow-lg shadow-red-500/5 active:scale-95 transition-all no-underline">
        <div class="w-12 h-12 bg-red-500/10 rounded-2xl flex items-center justify-center text-red-500">
            <span class="material-symbols-outlined font-bold">logout</span>
        </div>
        <span class="text-[10px] font-black uppercase tracking-widest text-red-500/60">Keluar</span>
    </a>
</div>

<!-- Account Settings Section -->
<section class="mt-12 animate-slide-up" style="animation-delay: 0.3s">
    <div class="flex items-center justify-between mb-6 px-2">
        <h3 class="headline text-lg font-black text-primary">Informasi Akun</h3>
        <span class="material-symbols-outlined text-outline">settings</span>
    </div>
    
    <div class="space-y-4">
        <!-- Redundant buttons removed to prioritize the premium action cards above -->
    </div>
</section>

<!-- Profile Form -->
<form id="profile-form" class="space-y-8 pb-32">
    <div class="grid grid-cols-1 gap-6">
        <!-- Identitas Warga -->
        <div class="section-container bg-surface-container-lowest">
            <h3 class="headline font-black text-sm uppercase tracking-widest text-outline mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">person</span>
                Identitas Warga
            </h3>
            <div class="space-y-4">
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Nama Rekening Bank (Nama User)</label>
                    <input type="text" name="name" value="<?php echo htmlspecialchars($u['name']); ?>" required 
                           class="w-full bg-surface-container border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-primary font-bold transition-all" placeholder="Masukkan nama sesuai di buku tabungan">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Nomor WhatsApp</label>
                    <input type="text" name="whatsapp" value="<?php echo htmlspecialchars($u['whatsapp']); ?>" readonly 
                           class="w-full bg-outline/5 border-none rounded-2xl px-5 py-4 font-bold text-outline cursor-not-allowed">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Organisasi / Komunitas</label>
                    <input type="text" name="organization" value="<?php echo htmlspecialchars($u['organization']); ?>" 
                           class="w-full bg-surface-container border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-primary font-bold transition-all" placeholder="Dapur/Komunitas/Individu">
                </div>
            </div>
        </div>

        <!-- Rekening Bank -->
        <div class="section-container bg-surface-container-lowest">
            <h3 class="headline font-black text-sm uppercase tracking-widest text-outline mb-6 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">account_balance</span>
                Info Pencairan Dana
            </h3>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Nama Bank</label>
                    <input type="text" name="bank_name" value="<?php echo htmlspecialchars($u['bank_name']); ?>" 
                           class="w-full bg-surface-container border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-primary font-bold transition-all" placeholder="Contoh: BCA, BNI, Mandiri">
                </div>
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Nomor Rekening</label>
                    <input type="text" name="account_number" value="<?php echo htmlspecialchars($u['account_number']); ?>" 
                           class="w-full bg-surface-container border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-primary font-bold transition-all" placeholder="123-456-7890">
                </div>
            </div>
        </div>

        <!-- Lokasi Jemput -->
        <div class="section-container bg-surface-container-lowest overflow-hidden">
            <div class="flex justify-between items-center mb-6">
                <h3 class="headline font-black text-sm uppercase tracking-widest text-outline flex items-center gap-2">
                    <span class="material-symbols-outlined text-[18px]">map</span>
                    Titik Jemput Akurat
                </h3>
                <button type="button" onclick="detectLocation()" class="text-primary text-[10px] font-black uppercase tracking-widest flex items-center gap-1 hover:underline group">
                    <span class="material-symbols-outlined text-[16px] group-active:animate-ping">my_location</span>
                    Deteksi Lokasi
                </button>
            </div>
            <div id="map" class="mb-4 shadow-inner"></div>
            <input type="hidden" id="latitude" name="latitude" value="<?php echo $lat; ?>">
            <input type="hidden" id="longitude" name="longitude" value="<?php echo $lng; ?>">
            
            <div class="space-y-4">
                <p class="text-[10px] text-outline italic px-1">* Geser pin pada peta untuk menetapkan titik jemput yang akurat.</p>
                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Alamat Lengkap</label>
                    <textarea name="address" rows="3" 
                              class="w-full bg-surface-container border-none rounded-2xl px-5 py-4 focus:ring-2 focus:ring-primary font-bold transition-all" 
                              placeholder="Masukkan detail alamat, nomor rumah, rt/rw..."><?php echo htmlspecialchars($u['address']); ?></textarea>
                </div>
            </div>
        </div>
    </div>

    <!-- Submit Button -->
    <button type="submit" class="w-full bg-primary text-white py-5 rounded-[2rem] font-black headline text-lg shadow-2xl shadow-primary/30 active:scale-95 transition-all flex items-center justify-center gap-3">
        <span class="material-symbols-outlined">save</span>
        Simpan Profil
    </button>
</form>

<script>
// Leaflet Map Initialization
const map = L.map('map').setView([<?php echo $lat; ?>, <?php echo $lng; ?>], 15);
L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
    attribution: '© OpenStreetMap'
}).addTo(map);

const marker = L.marker([<?php echo $lat; ?>, <?php echo $lng; ?>], {
    draggable: true
}).addTo(map);

marker.on('dragend', function (e) {
    const latlng = marker.getLatLng();
    document.getElementById('latitude').value = latlng.lat.toFixed(8);
    document.getElementById('longitude').value = latlng.lng.toFixed(8);
});

// Detect Location via GPS
async function detectLocation() {
    if (!navigator.geolocation) {
        alert("Geolocation tidak didukung oleh browser Anda.");
        return;
    }

    const btn = event.currentTarget;
    const originalText = btn.innerHTML;
    btn.innerHTML = '<span class="material-symbols-outlined text-[16px] animate-spin">sync</span> Mendeteksi...';
    btn.disabled = true;

    navigator.geolocation.getCurrentPosition(async (position) => {
        const { latitude, longitude } = position.coords;
        const latlng = [latitude, longitude];
        
        map.setView(latlng, 17);
        marker.setLatLng(latlng);
        
        document.getElementById('latitude').value = latitude.toFixed(8);
        document.getElementById('longitude').value = longitude.toFixed(8);
        
        // Reverse Geocode via Nominatim
        try {
            const res = await fetch(`https://nominatim.openstreetmap.org/reverse?format=json&lat=${latitude}&lon=${longitude}`);
            const data = await res.json();
            if (data.display_name) {
                document.getElementsByName('address')[0].value = data.display_name;
            }
        } catch (err) {
            console.error("Gagal mendapatkan alamat:", err);
        } finally {
            btn.innerHTML = originalText;
            btn.disabled = false;
        }
    }, (error) => {
        alert("Gagal mendeteksi lokasi. Pastikan izin lokasi diberikan.");
        btn.innerHTML = originalText;
        btn.disabled = false;
    }, { enableHighAccuracy: true });
}

// Share App Link
function shareApp() {
    const link = window.location.origin + window.location.pathname.replace('user/profile.php', '');
    navigator.clipboard.writeText(link).then(() => {
        alert('✔ Link aplikasi berhasil disalin ke clipboard!');
    }).catch(err => {
        console.error('Kagal menyalin: ', err);
    });
}

// Avatar Upload
async function uploadAvatar() {
    const fileInput = document.getElementById('avatar-input');
    if (!fileInput.files[0]) return;

    const formData = new FormData();
    formData.append('avatar', fileInput.files[0]);
    formData.append('action', 'avatar_upload');

    try {
        const res = await fetch('../api/manage_user.php', {
            method: 'POST',
            body: formData
        });
        const result = await res.json();
        if (result.status === 'success') {
            document.getElementById('avatar-preview').src = result.url;
            alert('✔ Foto profil berhasil diperbarui!');
        } else {
            alert('❌ ' + result.message);
        }
    } catch (err) {
        console.error(err);
        alert('Gagal mengunggah foto.');
    }
}

// Profile Save
document.getElementById('profile-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const formData = new FormData(e.target);
    const data = Object.fromEntries(formData.entries());
    data.action = 'update_profile';

    try {
        const res = await fetch('../api/manage_user.php', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(data)
        });
        const result = await res.json();
        if (result.status === 'success') {
            alert('✔ Profil berhasil disimpan!');
            location.reload();
        } else {
            alert('❌ ' + result.message);
        }
    } catch (err) {
        console.error(err);
        alert('Kesalahan saat menyimpan profil.');
    }
});
</script>

<?php include '../includes/footer.php'; ?>
