<?php
$hide_nav = true; // Hide bottom nav on landing page
include 'includes/header.php';
?>

<div class="bg-white min-h-screen">
    <!-- Top Navigation -->
    <nav class="flex items-center justify-between px-6 md:px-8 py-4 md:py-6 max-w-7xl mx-auto border-b border-primary/5">
        <div class="flex items-center gap-2">
            <div class="w-8 h-8 md:w-10 md:h-10 bg-primary rounded-xl flex items-center justify-center text-white">
                <span class="material-symbols-outlined text-[20px] md:text-[24px]">recycling</span>
            </div>
            <span class="text-xl md:text-2xl font-black text-primary tracking-tighter headline"><?php echo htmlspecialchars($app_name); ?>.</span>
        </div>
        <div class="hidden md:flex items-center gap-10 text-sm font-bold text-outline">
            <a href="#beranda" class="hover:text-primary transition-all hover:scale-105 active:scale-95">Beranda</a>
            <a href="#tentang-kami" class="hover:text-primary transition-all hover:scale-105 active:scale-95">Tentang Kami</a>
            <a href="#layanan" class="hover:text-primary transition-all hover:scale-105 active:scale-95">Layanan</a>
            <a href="#kontak" class="hover:text-primary transition-all hover:scale-105 active:scale-95">Kontak</a>
        </div>
        <div class="flex items-center gap-3 md:gap-4">
            <a href="login.php" class="text-primary font-bold text-xs md:text-sm hover:underline">Masuk</a>
            <a href="register.php"
                class="bg-primary text-white font-bold px-4 py-2 md:px-6 md:py-3 text-xs md:text-sm rounded-xl hover:shadow-xl hover:shadow-primary/20 transition-all active:scale-95">Mulai
                Sekarang</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="beranda" class="relative px-6 md:px-8 py-12 md:py-20 max-w-7xl mx-auto overflow-hidden">
        <div class="grid md:grid-cols-2 gap-10 md:gap-12 items-center relative z-10">
            <div class="space-y-6 md:space-y-8">
                <div
                    class="inline-flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-2 bg-primary/5 border border-primary/10 rounded-full">
                    <span class="w-1.5 h-1.5 md:w-2 md:h-2 bg-primary rounded-full animate-pulse"></span>
                    <span class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-primary">Solusi Limbah
                        Modern</span>
                </div>
                <h1
                    class="text-4xl md:text-6xl lg:text-[7rem] font-black text-primary leading-[0.9] md:leading-[0.85] headline tracking-tighter animate-slide-up">
                    Waste Management<br>
                    <span class="text-outline-thin text-transparent"
                        style="-webkit-text-stroke: 2px #2D4F1E; opacity: 0.6;">Dumpster Rentals</span><br>
                    Garbage Pickup.
                </h1>
                <p class="text-base md:text-lg text-on-surface-variant max-w-md leading-relaxed">
                    Ubah sampah menjadi berkah. Platform pengelolaan limbah premium untuk rumah tangga dan bisnis Anda.
                    Dapatkan saldo dari setiap sampah yang Anda daur ulang.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="register.php"
                        class="bg-primary text-white font-bold px-6 py-3 md:px-8 md:py-4 text-sm md:text-base rounded-2xl flex items-center gap-2 hover:shadow-2xl hover:shadow-primary/30 transition-all group">
                        Mulai Sekarang
                        <span
                            class="material-symbols-outlined text-[18px] md:text-[24px] group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>
            <div class="relative">
                <div
                    class="aspect-[4/5] rounded-[2rem] overflow-hidden shadow-2xl rotate-3 scale-95 hover:rotate-0 transition-transform duration-700 bg-surface-container-low group">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&q=80&w=800"
                        alt="Waste Management"
                        class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                </div>
                <!-- Stats Overlays -->
                <div
                    class="absolute -bottom-10 -left-6 md:-left-10 bg-white p-4 md:p-6 rounded-3xl shadow-2xl border border-primary/5 -rotate-3 hover:rotate-0 transition-all">
                    <p class="text-3xl md:text-4xl font-black text-primary headline tracking-tighter">98%</p>
                    <p class="text-[8px] md:text-[10px] font-bold text-outline uppercase tracking-widest">Daur Ulang Berhasil</p>
                </div>
            </div>
        </div>

        <!-- Background Shapes -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-primary/5 -z-10 rounded-l-[10rem]"></div>
    </section>

    <!-- Floating Cards -->
    <section class="px-6 md:px-8 -mt-6 md:-mt-20 relative z-20 max-w-7xl mx-auto">
        <div class="grid md:grid-cols-3 gap-4 md:gap-6">
            <div
                class="bg-white/90 backdrop-blur-xl p-6 md:p-8 rounded-[1.5rem] md:rounded-[2rem] shadow-xl border border-primary/5 hover:-translate-y-2 transition-transform">
                <span class="material-symbols-outlined text-3xl md:text-4xl text-primary mb-3 md:mb-4">delete_sweep</span>
                <h3 class="font-bold text-lg md:text-xl mb-2 md:mb-4 headline text-primary leading-tight">Dumpster Sizes</h3>
                <p class="text-xs md:text-sm text-outline leading-relaxed">Berbagai ukuran kontainer sesuai kebutuhan volume sampah
                    Anda.</p>
            </div>
            <div
                class="bg-white/90 backdrop-blur-xl p-6 md:p-8 rounded-[1.5rem] md:rounded-[2rem] shadow-xl border border-primary/5 hover:-translate-y-2 transition-transform">
                <span class="material-symbols-outlined text-3xl md:text-4xl text-primary mb-3 md:mb-4">local_shipping</span>
                <h3 class="font-bold text-lg md:text-xl mb-2 md:mb-4 headline text-primary leading-tight">Waste Collection</h3>
                <p class="text-xs md:text-sm text-outline leading-relaxed">Penjemputan rutin dan terjadwal secara profesional dan
                    tepat waktu.</p>
            </div>
            <div
                class="bg-white/90 backdrop-blur-xl p-6 md:p-8 rounded-[1.5rem] md:rounded-[2rem] shadow-xl border border-primary/5 hover:-translate-y-2 transition-transform">
                <span class="material-symbols-outlined text-3xl md:text-4xl text-primary mb-3 md:mb-4">calendar_month</span>
                <h3 class="font-bold text-lg md:text-xl mb-2 md:mb-4 headline text-primary leading-tight">Pickup Schedule</h3>
                <p class="text-xs md:text-sm text-outline leading-relaxed">Kelola jadwal penjemputan Anda dengan mudah melalui
                    aplikasi.</p>
            </div>
        </div>
    </section>

    <!-- App Mockup Section -->
    <style>
        .hide-scrollbar::-webkit-scrollbar { display: none; }
        .hide-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
    </style>
    <style>
        html {
            scroll-behavior: smooth;
            scroll-padding-top: 80px;
        }
    </style>
    <section id="layanan" class="py-20 md:py-32 overflow-hidden bg-surface-container-low mt-12 md:mt-20 border-y border-primary/5 shadow-inner relative">
        <div class="text-center max-w-2xl mx-auto mb-10 md:mb-16 space-y-4 px-6 md:px-8">
            <div class="inline-flex items-center gap-2 px-3 py-1.5 md:px-4 md:py-2 bg-primary/10 border border-primary/20 rounded-full mb-2 md:mb-4">
                <span class="material-symbols-outlined text-[14px] md:text-[16px] text-primary">smartphone</span>
                <span class="text-[9px] md:text-[10px] font-black uppercase tracking-widest text-primary">Aplikasi User</span>
            </div>
            <h2 class="text-3xl md:text-5xl font-black text-primary headline tracking-tight">Eksplorasi Fitur Kami</h2>
            <p class="text-sm md:text-base text-on-surface-variant leading-relaxed">Pantau history, cek saldo, dan atur penjemputan sampah dengan mudah melalui antarmuka genggaman yang modern dan interaktif.</p>
        </div>
        
        <style>
            @keyframes marquee {
                0% { transform: translateX(0); }
                100% { transform: translateX(calc(-50% - 0.75rem)); } /* gap-6 is 1.5rem, half is 0.75rem */
            }
            .animate-marquee {
                animation: marquee 25s linear infinite;
                display: flex;
                width: max-content;
            }
            .pause-marquee:hover .animate-marquee {
                animation-play-state: paused;
            }
        </style>
        
        <div class="relative w-full overflow-hidden pause-marquee pb-16 pt-4">
            <!-- Fade Edges -->
            <div class="absolute inset-y-0 left-0 w-16 md:w-40 bg-gradient-to-r from-surface-container-low to-transparent z-20 pointer-events-none"></div>
            <div class="absolute inset-y-0 right-0 w-16 md:w-40 bg-gradient-to-l from-surface-container-low to-transparent z-20 pointer-events-none"></div>

            <div class="animate-marquee gap-6 items-center">
                <?php 
                $mockups = [
                    ['src' => 'assets/app%20home.png', 'alt' => 'App Home'],
                    ['src' => 'assets/app%20layanan.png', 'alt' => 'App Layanan'],
                    ['src' => 'assets/app%20beli.png', 'alt' => 'App Transaksi'],
                    ['src' => 'assets/app%20profil%201.png', 'alt' => 'App Profil 1'],
                    ['src' => 'assets/app%20profil%202.png', 'alt' => 'App Profil 2']
                ];
                
                // Duplicate the array to create a seamless infinite loop
                for($i = 0; $i < 2; $i++):
                    foreach($mockups as $index => $m):
                ?>
                    <div class="shrink-0 w-[180px] sm:w-[220px] md:w-[320px] hover:-translate-y-4 transition-transform duration-500 group relative">
                        <div class="absolute inset-0 bg-primary/30 blur-3xl rounded-full scale-90 -z-10 opacity-0 group-hover:opacity-100 transition-opacity duration-500"></div>
                        <div class="bg-[#1a1a1a] rounded-[2.5rem] shadow-[0_20px_50px_-15px_rgba(0,0,0,0.3)] p-[10px] md:p-[14px] relative z-10 transition-shadow group-hover:shadow-[0_30px_60px_-15px_rgba(0,0,0,0.5)]">
                            <div class="absolute top-0 left-1/2 -translate-x-1/2 w-1/3 h-5 bg-[#1a1a1a] rounded-b-[1rem] z-20"></div> <!-- Notch -->
                            <div class="bg-white rounded-[1.8rem] overflow-hidden relative border border-outline-variant/20">
                                <img src="<?php echo $m['src']; ?>" alt="<?php echo $m['alt']; ?>" class="w-full h-auto object-contain pointer-events-none block pt-2">
                            </div>
                        </div>
                    </div>
                <?php 
                    endforeach;
                endfor; 
                ?>
            </div>
        </div>
    </section>

    <!-- Tentang Kami Section (Leader) -->
    <section id="tentang-kami" class="px-6 md:px-8 py-20 md:py-32 max-w-7xl mx-auto grid md:grid-cols-2 gap-12 md:gap-20 items-center">
        <div class="relative order-2 md:order-1 px-4 md:px-0">
            <div class="aspect-square rounded-[2rem] md:rounded-[3rem] overflow-hidden bg-primary/5 relative">
                <img src="https://awsimages.detik.net.id/community/media/visual/2025/08/07/bank-sampah-pemprov-dki-1754538072437.jpeg?w=600&q=90?auto=format&fit=crop&q=80&w=800"
                    alt="Our Team" class="w-full h-full object-cover">
            </div>
            <div class="absolute -top-6 -right-6 md:-top-10 md:-right-10 bg-white p-4 md:p-8 rounded-full shadow-2xl border border-primary/5">
                <span class="material-symbols-outlined text-2xl md:text-4xl text-primary">eco</span>
            </div>
        </div>
        <div class="space-y-6 md:space-y-8 order-1 md:order-2">
            <h2 class="text-3xl md:text-5xl font-black text-primary leading-tight headline tracking-tight">Tentang Kami</h2>
            <h3 class="text-lg md:text-2xl font-bold text-on-surface-variant">We're Leader In Waste Management Services</h3>
            <p class="text-sm md:text-base text-on-surface-variant leading-relaxed">
                Sebagai pemimpin di industri, kami berkomitmen untuk menghadirkan teknologi pengelolaan limbah terbaru
                guna meminimalkan dampak lingkungan. Kerja keras kami diakui secara global.
            </p>
            <div class="space-y-3 md:space-y-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-xs md:text-sm font-bold text-primary">Recycling Rate</span>
                    <span class="text-xs md:text-sm font-black text-primary">97%</span>
                </div>
                <div class="w-full bg-primary/10 h-2 md:h-3 rounded-full overflow-hidden">
                    <div class="bg-primary h-full w-[97%] rounded-full"></div>
                </div>
            </div>
            <a href="#" class="inline-flex items-center gap-2 group font-bold text-sm md:text-base text-primary">
                Learn More About Us
                <span
                    class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_right_alt</span>
            </a>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-primary py-16 md:py-24 px-6 md:px-8 overflow-hidden relative">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-8 md:gap-12 relative z-10">
            <div class="text-center space-y-1 md:space-y-2">
                <h4 class="text-3xl sm:text-4xl md:text-6xl font-black text-white headline tracking-tight">62K</h4>
                <p class="text-white/60 text-[8px] md:text-[10px] font-bold uppercase tracking-[0.2em]">Pelanggan Puas</p>
            </div>
            <div class="text-center space-y-1 md:space-y-2">
                <h4 class="text-3xl sm:text-4xl md:text-6xl font-black text-white headline tracking-tight">150+</h4>
                <p class="text-white/60 text-[8px] md:text-[10px] font-bold uppercase tracking-[0.2em]">Kemitraan Organisasi</p>
            </div>
            <div class="text-center space-y-1 md:space-y-2">
                <h4 class="text-3xl sm:text-4xl md:text-6xl font-black text-white headline tracking-tight">130</h4>
                <p class="text-white/60 text-[8px] md:text-[10px] font-bold uppercase tracking-[0.2em]">Staf Lapangan</p>
            </div>
            <div class="text-center space-y-1 md:space-y-2">
                <h4 class="text-3xl sm:text-4xl md:text-6xl font-black text-white headline tracking-tight">32+</h4>
                <p class="text-white/60 text-[8px] md:text-[10px] font-bold uppercase tracking-[0.2em]">Provinsi Tercover</p>
            </div>
        </div>
        <div class="absolute top-0 right-0 w-64 md:w-96 h-64 md:h-96 bg-white/5 blur-[80px] md:blur-[120px] rounded-full"></div>
    </section>

    <!-- FAQ & Reviews -->
    <section class="px-8 py-32 max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-20 space-y-4">
            <h2 class="text-3xl md:text-4xl font-black text-primary headline tracking-tight">Apa Kata Mereka?</h2>
            <p class="text-on-surface-variant">Bergabunglah dengan ribuan orang lainnya yang telah berkontribusi menjaga
                bumi tetap hijau.</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <!-- Review Card 1 -->
            <div
                class="bg-white p-6 md:p-10 rounded-[2rem] md:rounded-[2.5rem] border border-primary/5 shadow-xl relative overflow-hidden group">
                <div class="mb-6 md:mb-8 font-medium">
                    <div class="flex gap-1 text-primary mb-4 text-xs">
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                    </div>
                    <p class="italic text-on-surface-variant text-sm md:text-base leading-relaxed">"Mudah sekali menjual sampah di sini.
                        Saldo langsung masuk dan tim penjemput sangat ramah."</p>
                </div>
                <div class="flex items-center gap-4 border-t border-primary/5 pt-6 md:pt-8">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-full overflow-hidden bg-primary/10">
                        <img src="https://ui-avatars.com/api/?name=Haley+B&background=2D4F1E&color=fff" alt="Haley B">
                    </div>
                    <div>
                        <h5 class="font-bold text-primary headline text-sm md:text-base">Haley B</h5>
                        <p class="text-[9px] md:text-[10px] text-outline font-bold uppercase">Member Silver</p>
                    </div>
                </div>
            </div>

            <!-- Review Card 2 (Featured) -->
            <div
                class="bg-primary p-6 md:p-10 rounded-[2rem] md:rounded-[2.5rem] shadow-2xl relative overflow-hidden group scale-100 md:scale-105 border-4 border-white/10 my-4 md:my-0">
                <div class="mb-6 md:mb-8 font-medium">
                    <div class="flex gap-1 text-white mb-4 text-xs">
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                    </div>
                    <p class="italic text-white text-sm md:text-base leading-relaxed">"Aplikasi paling inovatif untuk pengelolaan bank
                        sampah. Tampilannya sangat premium dan modern!"</p>
                </div>
                <div class="flex items-center gap-4 border-t border-white/10 pt-6 md:pt-8">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-full overflow-hidden bg-white/20">
                        <img src="https://ui-avatars.com/api/?name=Huzein+Akbar&background=fff&color=2D4F1E"
                            alt="Huzein Akbar">
                    </div>
                    <div>
                        <h5 class="font-bold text-white headline text-sm md:text-base">Huzein Akbar</h5>
                        <p class="text-[9px] md:text-[10px] text-white/60 font-bold uppercase">Sustainability Advocate</p>
                    </div>
                </div>
            </div>

            <!-- Review Card 3 -->
            <div
                class="bg-white p-6 md:p-10 rounded-[2rem] md:rounded-[2.5rem] border border-primary/5 shadow-xl relative overflow-hidden group">
                <div class="mb-6 md:mb-8 font-medium">
                    <div class="flex gap-1 text-primary mb-4 text-xs">
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[14px] md:text-[16px]">star</span>
                    </div>
                    <p class="italic text-on-surface-variant text-sm md:text-base leading-relaxed">"Sangat terbantu untuk mengelola sampah
                        kantor. Proses administrasinya sangat transparan dan akurat."</p>
                </div>
                <div class="flex items-center gap-4 border-t border-primary/5 pt-6 md:pt-8">
                    <div class="w-10 h-10 md:w-12 md:h-12 rounded-full overflow-hidden bg-primary/10">
                        <img src="https://ui-avatars.com/api/?name=Abdul+Zein&background=2D4F1E&color=fff"
                            alt="Abdul Zein">
                    </div>
                    <div>
                        <h5 class="font-bold text-primary headline text-sm md:text-base">Abdul Zein</h5>
                        <p class="text-[9px] md:text-[10px] text-outline font-bold uppercase">Staf Administrasi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="bg-[#1A2E12] text-white py-12 md:py-20 px-6 md:px-8 mt-12 md:mt-20">
        <div class="max-w-7xl mx-auto text-center">
            <div class="flex items-center justify-center gap-2 mb-6 md:mb-8">
                <div class="w-10 h-10 md:w-12 md:h-12 bg-primary rounded-xl md:rounded-2xl flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-[24px] md:text-[32px]">recycling</span>
                </div>
                <span class="text-2xl md:text-4xl font-black text-white tracking-tighter headline"><?php echo htmlspecialchars($app_name); ?>.</span>
            </div>
            <p class="max-w-xl mx-auto text-white/50 text-xs md:text-sm mb-10 md:mb-12">
                Bergabunglah bersama kami untuk menciptakan lingkungan yang lebih bersih. <?php echo htmlspecialchars($app_name); ?> adalah jembatan antara
                sampah yang tak bernilai menjadi manfaat ekonomi bagi Anda.
            </p>
            <div class="flex flex-col md:flex-row justify-center gap-8 mb-12 text-white/80 text-sm">
                <?php if(!empty($global_settings['wa_cs_number'])): ?>
                <div class="flex items-center justify-center gap-2">
                    <span class="material-symbols-outlined text-[20px] text-primary">call</span>
                    <span>+<?php echo htmlspecialchars($global_settings['wa_cs_number']); ?></span>
                </div>
                <?php endif; ?>
                <?php if(!empty($global_settings['address'])): ?>
                <div class="flex items-center justify-center gap-2 max-w-sm text-left">
                    <span class="material-symbols-outlined text-[20px] text-primary">location_on</span>
                    <span><?php echo htmlspecialchars($global_settings['address']); ?></span>
                </div>
                <?php endif; ?>
            </div>

            <!-- Social Media -->
            <div class="flex justify-center gap-6 mb-12">
                <?php if(!empty($global_settings['social_instagram'])): ?>
                <a href="<?php echo htmlspecialchars($global_settings['social_instagram']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-colors">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.071zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z"/></svg>
                </a>
                <?php endif; ?>
                <?php if(!empty($global_settings['social_facebook'])): ?>
                <a href="<?php echo htmlspecialchars($global_settings['social_facebook']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-colors">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M22.675 0h-21.35c-.732 0-1.325.593-1.325 1.325v21.351c0 .731.593 1.324 1.325 1.324h11.495v-9.294h-3.128v-3.622h3.128v-2.671c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12v9.293h6.116c.73 0 1.323-.593 1.323-1.325v-21.35c0-.732-.593-1.325-1.325-1.325z"/></svg>
                </a>
                <?php endif; ?>
                <?php if(!empty($global_settings['social_twitter'])): ?>
                <a href="<?php echo htmlspecialchars($global_settings['social_twitter']); ?>" target="_blank" class="w-10 h-10 rounded-full bg-white/5 flex items-center justify-center hover:bg-primary transition-colors">
                    <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.188 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                </a>
                <?php endif; ?>
            </div>

            <div class="flex flex-wrap justify-center gap-4 md:gap-8 mb-12 md:mb-16 font-bold uppercase tracking-widest md:tracking-[0.3em] text-[9px] md:text-[10px]">
                <a href="#beranda" class="hover:text-primary transition-colors">Beranda</a>
                <a href="#tentang-kami" class="hover:text-primary transition-colors">Tentang Kami</a>
                <a href="#layanan" class="hover:text-primary transition-colors">Layanan</a>
                <a href="#kontak" class="hover:text-primary transition-colors">Kontak</a>
            </div>
            <p class="text-white/20 text-[9px] font-black uppercase tracking-widest border-t border-white/5 pt-12">
                © <?php echo date('Y'); ?> <?php echo htmlspecialchars($app_name); ?>. All Rights Reserved. Designed for the Future.
            </p>
        </div>
    </footer>
</div>

<?php
$hide_nav = true;
include 'includes/footer.php';
?>