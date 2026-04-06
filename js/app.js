document.addEventListener('DOMContentLoaded', () => {
    // Page detection
    const catalogGrid = document.getElementById('catalog-grid');
    const userStats = document.getElementById('user-stats');
    const transactionHistory = document.getElementById('transaction-history');

    if (catalogGrid) fetchCategories();
    if (userStats || transactionHistory) fetchUserData();
});

async function fetchUserData() {
    try {
        const response = await fetch(API_BASE + 'get_user_data.php');
        const result = await response.json();

        if (result.status === 'success') {
            if (document.getElementById('user-stats')) renderUserStats(result.user);
            if (document.getElementById('transaction-history')) renderHistory(result.history);
        }
    } catch (error) {
        console.error('Error fetching user data:', error);
    }
}

function renderUserStats(user) {
    const statsContainer = document.getElementById('user-stats');
    if (!statsContainer) return;

    // Mapping values to UI (Assuming IDs exist in index.php)
    const totalKg = document.getElementById('stat-total-kg');
    const balance = document.getElementById('stat-balance');
    const tier = document.getElementById('stat-tier');
    const greeting = document.getElementById('user-greeting');

    if (totalKg) totalKg.innerText = user.total_kg;
    if (balance) balance.innerText = new Intl.NumberFormat('id-ID').format(user.balance);
    if (tier) tier.innerText = user.tier;
    if (greeting) greeting.innerText = `Halo, ${user.name.split(' ')[0]}!`;
}

function renderHistory(history) {
    const historyContainer = document.getElementById('transaction-history');
    if (!historyContainer) return;

    if (history.length === 0) {
        historyContainer.innerHTML = '<p class="text-center text-on-surface-variant py-8">Belum ada transaksi.</p>';
        return;
    }

    historyContainer.innerHTML = history.map(item => `
        <div class="flex items-center p-4 card-container ${item.status === 'PENDING' ? 'opacity-70' : ''}">
            <div class="w-10 h-10 bg-primary/10 rounded-full flex items-center justify-center text-primary">
                <span class="material-symbols-outlined text-[20px]">${item.category_icon || 'shopping_bag'}</span>
            </div>
            <div class="ml-4 flex-1">
                <h5 class="headline font-bold text-sm text-on-surface">${item.category_name}</h5>
                <p class="text-[11px] text-on-surface-variant">${new Date(item.created_at).toLocaleDateString('id-ID', {day:'2-digit', month:'short', year:'numeric'})} • ${item.weight_est} kg</p>
            </div>
            <div class="text-right">
                <p class="font-bold text-sm text-primary">+IDR ${new Intl.NumberFormat('id-ID').format(item.total_payout)}</p>
                <span class="text-[9px] font-black uppercase ${item.status === 'VERIFIED' ? 'text-secondary' : 'text-outline'}">${item.status}</span>
            </div>
        </div>
    `).join('');
}

function renderCatalog(categories) {
    const catalogGrid = document.getElementById('catalog-grid');
    catalogGrid.innerHTML = ''; // Clear skeleton/mock

    categories.forEach(item => {
        const card = `
            <div class="card-container group transition-all duration-500 hover:shadow-2xl hover:shadow-primary/5">
                <div class="h-48 overflow-hidden relative rounded-xl mb-6 bg-surface-container-low">
                    <img src="${item.image_url || 'https://images.unsplash.com/photo-1532094349884-543bc11b234d?auto=format&fit=crop&q=80&w=600'}" 
                         alt="${item.name}" 
                         class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                    ${item.is_popular ? '<div class="absolute top-4 right-4 bg-white/90 backdrop-blur-md px-3 py-1 rounded-full text-[10px] font-bold text-primary uppercase tracking-wider">Populer</div>' : ''}
                </div>
                <div class="flex justify-between items-start mb-6">
                    <div>
                        <h3 class="font-bold text-lg text-on-surface headline">${item.name}</h3>
                        <span class="text-xs text-outline font-medium">Kategori: ${item.category}</span>
                    </div>
                    <div class="text-right">
                        <p class="text-primary font-extrabold text-lg headline">IDR ${new Intl.NumberFormat('id-ID').format(item.price_per_kg)}</p>
                        <p class="text-[10px] text-outline font-bold uppercase tracking-widest leading-none">Per Kilogram</p>
                    </div>
                </div>
                <button onclick="openSellModal(${item.id}, '${item.name}', ${item.price_per_kg})" 
                        class="w-full section-container py-3 font-bold text-primary flex items-center justify-center gap-2 hover:bg-primary hover:text-white transition-all duration-300">
                    <span class="material-symbols-outlined text-[18px]">add_shopping_cart</span> Jual
                </button>
            </div>
        `;
        catalogGrid.innerHTML += card;
    });
}

async function openSellModal(id, name, price) {
    const weight = prompt(`Berapa kg ${name} yang ingin Anda jual?`, "1.0");
    if (weight && !isNaN(weight)) {
        try {
            const response = await fetch(API_BASE + 'submit_transaction.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({
                    category_id: id,
                    weight_est: parseFloat(weight)
                })
            });

            const result = await response.json();

            if (result.status === 'success') {
                const total = weight * price;
                alert(`Request Berhasil!\nID Transaksi: ${result.data.transaction_id}\nEstimasi Saldo: IDR ${new Intl.NumberFormat('id-ID').format(total)}\n\nTim kami akan menjemput sampah Anda.`);
                // Ideally refresh the dashboard or redirect
                location.reload(); 
            } else {
                alert('Error: ' + result.message);
            }
        } catch (error) {
            console.error('Error submitting transaction:', error);
            alert('Gagal mengirim permintaan. Periksa koneksi Anda.');
        }
    }
}
