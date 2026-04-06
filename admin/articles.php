<?php
$hide_nav = true;
include '../includes/header.php';
include 'sidebar.php';
?>

<div class="md:ml-64 transition-all duration-300 w-full md:w-auto bg-surface min-h-screen pb-20">
    <!-- Header -->
    <header class="bg-white px-4 md:px-8 py-4 md:py-6 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4 border-b border-primary/5 shadow-sm sticky top-0 z-50">
        <div>
            <h1 class="text-lg md:text-xl font-black text-primary headline tracking-tight leading-none">Artikel & Event</h1>
            <p class="text-[9px] md:text-[10px] font-bold text-outline uppercase tracking-widest mt-1">Eksplorasi Lingkungan & Edukasi</p>
        </div>
        <button onclick="openModal()" class="w-full sm:w-auto bg-primary text-white px-4 py-2.5 md:px-6 md:py-3 rounded-xl font-bold text-[11px] md:text-xs flex items-center justify-center sm:justify-start gap-2 shadow-lg shadow-primary/20 hover:scale-105 active:scale-95 transition-all">
            <span class="material-symbols-outlined text-[18px]">add_circle</span>
            Tambah Artikel
        </button>
    </header>

    <main class="max-w-7xl mx-auto px-4 md:px-8 py-6 md:py-10">
        <div id="article-list" class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 md:gap-6">
            <!-- Loaded by JS -->
            <div class="animate-pulse bg-white/50 h-64 rounded-[2rem]"></div>
        </div>
    </main>
</div>

<!-- Modal Form -->
<div id="form-modal" class="fixed inset-0 bg-black/60 backdrop-blur-sm z-[100] hidden flex items-center justify-center p-6">
    <div class="bg-white w-full max-w-lg rounded-[2.5rem] p-10 shadow-2xl overflow-y-auto max-h-[90vh]">
        <h3 id="modal-title" class="text-lg md:text-2xl font-black text-primary headline tracking-tight mb-2">Tambah Artikel</h3>
        <p class="text-sm text-on-surface-variant mb-8 font-medium">Isi detail konten untuk ditampilkan di Eksplorasi Lingkungan.</p>
        
        <form id="article-form" class="space-y-4">
            <input type="hidden" id="article-id" name="id">
            
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Judul Utama</label>
                    <input type="text" id="title" name="title" required 
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary font-bold text-sm">
                </div>
                
                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Subtitle / Ringkasan</label>
                    <input type="text" id="subtitle" name="subtitle" required 
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary font-bold text-sm">
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Kategori</label>
                    <select id="category" name="category" required 
                            class="w-full bg-surface-container border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary font-bold text-sm">
                        <option value="AGENDA">AGENDA</option>
                        <option value="EDUKASI">EDUKASI</option>
                        <option value="KARIR">KARIR</option>
                    </select>
                </div>

                <div>
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Tanggal Event (Opt)</label>
                    <input type="date" id="event_date" name="event_date" 
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary font-bold text-sm">
                </div>

                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Lokasi (Opt)</label>
                    <input type="text" id="location" name="location" 
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary font-bold text-sm" placeholder="Jakarta, Hybrid, dll">
                </div>

                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Isi Artikel</label>
                    <textarea id="content" name="content" rows="4" required
                              class="w-full bg-surface-container border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary font-bold text-sm"></textarea>
                </div>

                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">CTA Link (External Link)</label>
                    <input type="url" id="cta_link" name="cta_link"
                           class="w-full bg-surface-container border-none rounded-xl px-4 py-3 focus:ring-2 focus:ring-primary font-bold text-sm" placeholder="https://...">
                </div>

                <div class="col-span-2">
                    <label class="block text-[10px] font-bold text-outline uppercase tracking-widest mb-2 px-1">Gambar Preview</label>
                    <input type="file" id="image" name="image" accept="image/*" class="w-full text-xs text-outline font-bold file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-[10px] file:font-black file:bg-primary/10 file:text-primary file:uppercase">
                </div>
            </div>

            <div class="flex gap-4 pt-4 border-t border-primary/5">
                <button type="button" onclick="closeModal()" class="flex-1 py-4 font-bold text-outline">Batal</button>
                <button type="submit" class="flex-1 bg-primary text-white py-4 font-bold rounded-2xl shadow-xl shadow-primary/20 transition-all">Simpan Artikel</button>
            </div>
        </form>
    </div>
</div>

<script>
let articles = [];

async function fetchArticles() {
    try {
        // Use a simpler, dedicated fetch URL that bypasses complex admin routing
        const res = await fetch(API_BASE + 'get_articles.php?admin=true');
        const text = await res.text();
        
        let result;
        try {
            result = JSON.parse(text);
        } catch (e) {
            console.error('API Error (RAW):', text);
            // If it starts with < it's probably an HTML error page, show only the beginning
            const snippet = text.trim().substring(0, 100);
            throw new Error(`Data format error (Is the session still active?). Raw snippet: ${snippet}`);
        }

        if (result.status === 'success') {
            articles = result.data;
            renderArticles(articles);
        } else {
            const errorHTML = `
                <div class="col-span-full py-20 text-center">
                    <span class="material-symbols-outlined text-lg md:text-2xl md:text-4xl text-red-500 mb-4 animate-bounce">database_alert</span>
                    <p class="text-red-500 font-black mb-2 headline text-xl">Sinkronisasi Database Gagal</p>
                    <p class="text-outline text-xs max-w-lg mx-auto p-4 bg-red-50 rounded-2xl border border-red-100 font-mono shadow-inner">${result.message || 'Unknown error'}</p>
                    <div class="mt-8 p-6 bg-primary/5 rounded-[2rem] border border-primary/10 max-w-md mx-auto">
                        <p class="text-[10px] text-primary uppercase tracking-widest font-black mb-4">Solusi Cepat</p>
                        <p class="text-xs text-outline leading-relaxed mb-4">Pastikan tabel <b>'content'</b> sudah memiliki kolom terbaru (location, cta_link).</p>
                        <a href="../ready_sync.php" target="_blank" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-xl text-[10px] font-black uppercase tracking-widest hover:shadow-lg transition-all">
                            <span class="material-symbols-outlined text-[16px]">sync_alt</span>
                            Jalankan Sync Tool
                        </a>
                    </div>
                </div>`;
            document.getElementById('article-list').innerHTML = errorHTML;
        }
    } catch (err) {
        console.error('Fetch Error:', err);
        document.getElementById('article-list').innerHTML = '<div class="col-span-full py-20 text-center text-red-500 font-bold">Terjadi kesalahan koneksi.</div>';
    }
}

function renderArticles(data) {
    const container = document.getElementById('article-list');
    if (data.length === 0) {
        container.innerHTML = '<div class="col-span-full py-20 text-center text-outline italic">Belum ada artikel.</div>';
        return;
    }

    container.innerHTML = data.map(a => `
        <div class="bg-white rounded-2xl md:rounded-[2rem] border border-primary/5 shadow-xl overflow-hidden group flex flex-col">
            <div class="h-32 md:h-44 relative overflow-hidden bg-surface-container shrink-0">
                <img src="${a.image_url || 'https://via.placeholder.com/600x400?text=No+Preview'}" 
                     class="w-full h-full object-cover">
                <div class="absolute top-2 left-2 md:top-4 md:left-4 bg-primary/90 text-white px-2 py-0.5 md:px-3 md:py-1 rounded-full text-[6px] md:text-[8px] font-black uppercase tracking-widest">
                    ${a.category}
                </div>
                <div class="absolute top-2 right-2 md:top-4 md:right-4 flex gap-1 md:gap-2">
                    <button onclick="editArticle(${a.id})" class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-white/90 shadow-lg text-primary flex items-center justify-center hover:bg-primary hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[14px] md:text-[18px]">edit</span>
                    </button>
                    <button onclick="deleteArticle(${a.id})" class="w-6 h-6 md:w-8 md:h-8 rounded-full bg-white/90 shadow-lg text-red-500 flex items-center justify-center hover:bg-red-500 hover:text-white transition-all">
                        <span class="material-symbols-outlined text-[14px] md:text-[18px]">delete</span>
                    </button>
                </div>
            </div>
            <div class="p-3 md:p-6 flex flex-col grow">
                <h4 class="text-xs md:text-base headline font-black text-primary mb-1 md:mb-2 line-clamp-2 md:line-clamp-1 leading-tight">${a.title}</h4>
                <p class="text-[8px] md:text-[11px] text-outline font-bold leading-relaxed line-clamp-2 mb-2 md:mb-4">${a.subtitle}</p>
                <div class="flex flex-col gap-1 md:gap-2 mt-auto">
                    ${a.location ? `
                    <div class="flex items-center gap-2 text-on-surface-variant text-[10px] font-bold uppercase tracking-widest">
                        <span class="material-symbols-outlined text-[14px]">location_on</span>
                        ${a.location}
                    </div>` : ''}
                    ${a.event_date ? `
                    <div class="flex items-center gap-2 text-on-surface-variant text-[10px] font-bold uppercase tracking-widest">
                        <span class="material-symbols-outlined text-[14px]">calendar_today</span>
                        ${new Date(a.event_date).toLocaleDateString('id-ID', {day: 'numeric', month: 'short', year: 'numeric'})}
                    </div>` : ''}
                </div>
            </div>
        </div>
    `).join('');
}

function openModal() {
    document.getElementById('modal-title').innerText = 'Tambah Artikel';
    document.getElementById('article-form').reset();
    document.getElementById('article-id').value = '';
    document.getElementById('form-modal').classList.remove('hidden');
}

function closeModal() {
    document.getElementById('form-modal').classList.add('hidden');
}

function editArticle(id) {
    const a = articles.find(item => item.id == id);
    if (!a) return;
    
    document.getElementById('modal-title').innerText = 'Edit Artikel';
    document.getElementById('article-id').value = a.id;
    document.getElementById('title').value = a.title;
    document.getElementById('subtitle').value = a.subtitle;
    document.getElementById('content').value = a.content;
    document.getElementById('category').value = a.category;
    document.getElementById('event_date').value = a.event_date;
    document.getElementById('location').value = a.location;
    document.getElementById('cta_link').value = a.cta_link;
    
    document.getElementById('form-modal').classList.remove('hidden');
}

async function deleteArticle(id) {
    if (!confirm('Hapus artikel ini?')) return;
    
    try {
        const formData = new FormData();
        formData.append('entity', 'articles');
        formData.append('action', 'delete');
        formData.append('id', id);

        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            body: formData
        });
        const result = await res.json();
        if (result.status === 'success') {
            fetchArticles();
        } else {
            alert('Gagal menghapus: ' + result.message);
        }
    } catch (err) { console.error(err); }
}

document.getElementById('article-form').addEventListener('submit', async (e) => {
    e.preventDefault();
    const saveBtn = e.target.querySelector('button[type="submit"]');
    const originalText = saveBtn.innerText;
    
    saveBtn.innerText = 'Menyimpan...';
    saveBtn.disabled = true;

    const formData = new FormData(e.target);
    formData.append('entity', 'articles');

    try {
        const res = await fetch('../api/manage_admin.php', {
            method: 'POST',
            body: formData
        });
        const result = await res.json();
        if (result.status === 'success') {
            closeModal();
            fetchArticles();
        } else {
            alert('Error: ' + result.message);
        }
    } catch (err) { 
        console.error(err);
        alert('Terjadi kesalahan sistem saat menyimpan.');
    } finally {
        saveBtn.innerText = originalText;
        saveBtn.disabled = false;
    }
});

document.addEventListener('DOMContentLoaded', fetchArticles);
</script>

<?php include '../includes/footer.php'; ?>
