<?php
$hide_nav = true; // Hide bottom nav on landing page
include 'includes/header.php';
?>

<div class="bg-white min-h-screen">
    <!-- Top Navigation -->
    <nav class="flex items-center justify-between px-8 py-6 max-w-7xl mx-auto border-b border-primary/5">
        <div class="flex items-center gap-2">
            <div class="w-10 h-10 bg-primary rounded-xl flex items-center justify-center text-white">
                <span class="material-symbols-outlined text-[24px]">recycling</span>
            </div>
            <span class="text-2xl font-black text-primary tracking-tighter headline">Waste.</span>
        </div>
        <div class="hidden md:flex items-center gap-8 text-sm font-bold text-outline">
            <a href="#" class="hover:text-primary transition-colors">Home</a>
            <a href="#" class="hover:text-primary transition-colors">About Us</a>
            <a href="#" class="hover:text-primary transition-colors">Services</a>
            <a href="#" class="hover:text-primary transition-colors">Company</a>
            <a href="#" class="hover:text-primary transition-colors">Blog</a>
            <a href="#" class="hover:text-primary transition-colors">Contact</a>
        </div>
        <div class="flex items-center gap-4">
            <a href="login.php" class="text-primary font-bold text-sm hover:underline">Masuk</a>
            <a href="register.php" class="bg-primary text-white font-bold px-6 py-3 rounded-xl hover:shadow-xl hover:shadow-primary/20 transition-all active:scale-95">Mulai Sekarang</a>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="relative px-8 py-20 max-w-7xl mx-auto overflow-hidden">
        <div class="grid md:grid-cols-2 gap-12 items-center relative z-10">
            <div class="space-y-8">
                <div class="inline-flex items-center gap-2 px-4 py-2 bg-primary/5 border border-primary/10 rounded-full">
                    <span class="w-2 h-2 bg-primary rounded-full animate-pulse"></span>
                    <span class="text-[10px] font-black uppercase tracking-widest text-primary">Solusi Limbah Modern</span>
                </div>
                <h1 class="text-6xl md:text-8xl font-black text-primary leading-[0.9] headline tracking-tighter">
                    Waste Management<br>
                    <span class="text-outline-thin text-transparent" style="-webkit-text-stroke: 1.5px #2D4F1E; opacity: 0.8;">Dumpster Rentals</span><br>
                    Garbage Pickup.
                </h1>
                <p class="text-lg text-on-surface-variant max-w-md leading-relaxed">
                    Ubah sampah menjadi berkah. Platform pengelolaan limbah premium untuk rumah tangga dan bisnis Anda. Dapatkan saldo dari setiap sampah yang Anda daur ulang.
                </p>
                <div class="flex flex-wrap gap-4">
                    <a href="register.php" class="bg-primary text-white font-bold px-8 py-4 rounded-2xl flex items-center gap-2 hover:shadow-2xl hover:shadow-primary/30 transition-all group">
                        Mulai Sekarang
                        <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_forward</span>
                    </a>
                </div>
            </div>
            <div class="relative">
                <div class="aspect-[4/5] rounded-[2rem] overflow-hidden shadow-2xl rotate-3 scale-95 hover:rotate-0 transition-transform duration-700 bg-surface-container-low group">
                    <img src="https://images.unsplash.com/photo-1542601906990-b4d3fb778b09?auto=format&fit=crop&q=80&w=800" 
                         alt="Waste Management" 
                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-1000">
                </div>
                <!-- Stats Overlays -->
                <div class="absolute -bottom-10 -left-10 bg-white p-6 rounded-3xl shadow-2xl border border-primary/5 -rotate-3 hover:rotate-0 transition-all">
                    <p class="text-4xl font-black text-primary headline tracking-tighter">98%</p>
                    <p class="text-[10px] font-bold text-outline uppercase tracking-widest">Daur Ulang Berhasil</p>
                </div>
            </div>
        </div>

        <!-- Background Shapes -->
        <div class="absolute top-0 right-0 w-1/2 h-full bg-primary/5 -z-10 rounded-l-[10rem]"></div>
    </section>

    <!-- Floating Cards -->
    <section class="px-8 -mt-20 relative z-20 max-w-7xl mx-auto">
        <div class="grid md:grid-cols-3 gap-6">
            <div class="bg-white/90 backdrop-blur-xl p-8 rounded-[2rem] shadow-xl border border-primary/5 hover:-translate-y-2 transition-transform">
                <span class="material-symbols-outlined text-4xl text-primary mb-4">delete_sweep</span>
                <h3 class="font-bold text-xl mb-4 headline text-primary leading-none">Dumpster Sizes</h3>
                <p class="text-sm text-outline leading-relaxed">Berbagai ukuran kontainer sesuai kebutuhan volume sampah Anda.</p>
            </div>
            <div class="bg-white/90 backdrop-blur-xl p-8 rounded-[2rem] shadow-xl border border-primary/5 hover:-translate-y-2 transition-transform">
                <span class="material-symbols-outlined text-4xl text-primary mb-4">local_shipping</span>
                <h3 class="font-bold text-xl mb-4 headline text-primary leading-none">Waste Collection</h3>
                <p class="text-sm text-outline leading-relaxed">Penjemputan rutin dan terjadwal secara profesional dan tepat waktu.</p>
            </div>
            <div class="bg-white/90 backdrop-blur-xl p-8 rounded-[2rem] shadow-xl border border-primary/5 hover:-translate-y-2 transition-transform">
                <span class="material-symbols-outlined text-4xl text-primary mb-4">calendar_month</span>
                <h3 class="font-bold text-xl mb-4 headline text-primary leading-none">Pickup Schedule</h3>
                <p class="text-sm text-outline leading-relaxed">Kelola jadwal penjemputan Anda dengan mudah melalui aplikasi.</p>
            </div>
        </div>
    </section>

    <!-- Leader Section -->
    <section class="px-8 py-32 max-w-7xl mx-auto grid md:grid-cols-2 gap-20 items-center">
        <div class="relative order-2 md:order-1">
            <div class="aspect-square rounded-[3rem] overflow-hidden bg-primary/5 relative">
                <img src="https://images.unsplash.com/photo-1595273670150-db0a3bf3cb0c?auto=format&fit=crop&q=80&w=800" 
                     alt="Our Team" 
                     class="w-full h-full object-cover">
            </div>
            <div class="absolute -top-10 -right-10 bg-white p-8 rounded-full shadow-2xl border border-primary/5">
                <span class="material-symbols-outlined text-4xl text-primary">eco</span>
            </div>
        </div>
        <div class="space-y-8 order-1 md:order-2">
            <h2 class="text-5xl font-black text-primary leading-tight headline tracking-tight">We're Leader In Waste Management Services</h2>
            <p class="text-on-surface-variant leading-relaxed">
                Sebagai pemimpin di industri, kami berkomitmen untuk menghadirkan teknologi pengelolaan limbah terbaru guna meminimalkan dampak lingkungan. Kerja keras kami diakui secara global.
            </p>
            <div class="space-y-4">
                <div class="flex justify-between items-center mb-2">
                    <span class="text-sm font-bold text-primary">Recycling Rate</span>
                    <span class="text-sm font-black text-primary">97%</span>
                </div>
                <div class="w-full bg-primary/10 h-3 rounded-full overflow-hidden">
                    <div class="bg-primary h-full w-[97%] rounded-full"></div>
                </div>
            </div>
            <a href="#" class="inline-flex items-center gap-2 group font-bold text-primary">
                Learn More About Us
                <span class="material-symbols-outlined group-hover:translate-x-1 transition-transform">arrow_right_alt</span>
            </a>
        </div>
    </section>

    <!-- Stats Section -->
    <section class="bg-primary py-24 px-8 overflow-hidden relative">
        <div class="max-w-7xl mx-auto grid grid-cols-2 md:grid-cols-4 gap-12 relative z-10">
            <div class="text-center space-y-2">
                <h4 class="text-6xl font-black text-white headline tracking-tight">62K</h4>
                <p class="text-white/60 text-[10px] font-bold uppercase tracking-[0.2em]">Pelanggan Puas</p>
            </div>
            <div class="text-center space-y-2">
                <h4 class="text-6xl font-black text-white headline tracking-tight">150+</h4>
                <p class="text-white/60 text-[10px] font-bold uppercase tracking-[0.2em]">Kemitraan Organisasi</p>
            </div>
            <div class="text-center space-y-2">
                <h4 class="text-6xl font-black text-white headline tracking-tight">130</h4>
                <p class="text-white/60 text-[10px] font-bold uppercase tracking-[0.2em]">Staf Lapangan</p>
            </div>
            <div class="text-center space-y-2">
                <h4 class="text-6xl font-black text-white headline tracking-tight">32+</h4>
                <p class="text-white/60 text-[10px] font-bold uppercase tracking-[0.2em]">Provinsi Tercover</p>
            </div>
        </div>
        <div class="absolute top-0 right-0 w-96 h-96 bg-white/5 blur-[120px] rounded-full"></div>
    </section>

    <!-- FAQ & Reviews -->
    <section class="px-8 py-32 max-w-7xl mx-auto">
        <div class="text-center max-w-2xl mx-auto mb-20 space-y-4">
            <h2 class="text-4xl font-black text-primary headline tracking-tight">Apa Kata Mereka?</h2>
            <p class="text-on-surface-variant">Bergabunglah dengan ribuan orang lainnya yang telah berkontribusi menjaga bumi tetap hijau.</p>
        </div>
        
        <div class="grid md:grid-cols-3 gap-8">
            <!-- Review Card 1 -->
            <div class="bg-white p-10 rounded-[2.5rem] border border-primary/5 shadow-xl relative overflow-hidden group">
                <div class="mb-8 font-medium">
                   <div class="flex gap-1 text-primary mb-4 text-xs">
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[16px]">star</span>
                   </div>
                   <p class="italic text-on-surface-variant leading-relaxed">"Mudah sekali menjual sampah di sini. Saldo langsung masuk dan tim penjemput sangat ramah."</p>
                </div>
                <div class="flex items-center gap-4 border-t border-primary/5 pt-8">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-primary/10">
                        <img src="https://ui-avatars.com/api/?name=Haley+B&background=2D4F1E&color=fff" alt="Haley B">
                    </div>
                    <div>
                        <h5 class="font-bold text-primary headline">Haley B</h5>
                        <p class="text-[10px] text-outline font-bold uppercase">Member Silver</p>
                    </div>
                </div>
            </div>

            <!-- Review Card 2 (Featured) -->
            <div class="bg-primary p-10 rounded-[2.5rem] shadow-2xl relative overflow-hidden group scale-105 border-4 border-white/10">
                <div class="mb-8 font-medium">
                   <div class="flex gap-1 text-white mb-4 text-xs">
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[16px]">star</span>
                   </div>
                   <p class="italic text-white leading-relaxed">"Aplikasi paling inovatif untuk pengelolaan bank sampah. Tampilannya sangat premium dan modern!"</p>
                </div>
                <div class="flex items-center gap-4 border-t border-white/10 pt-8">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-white/20">
                        <img src="https://ui-avatars.com/api/?name=Huzein+Akbar&background=fff&color=2D4F1E" alt="Huzein Akbar">
                    </div>
                    <div>
                        <h5 class="font-bold text-white headline">Huzein Akbar</h5>
                        <p class="text-[10px] text-white/60 font-bold uppercase">Sustainability Advocate</p>
                    </div>
                </div>
            </div>

            <!-- Review Card 3 -->
            <div class="bg-white p-10 rounded-[2.5rem] border border-primary/5 shadow-xl relative overflow-hidden group">
                <div class="mb-8 font-medium">
                   <div class="flex gap-1 text-primary mb-4 text-xs">
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[16px]">star</span>
                        <span class="material-symbols-outlined text-[16px]">star</span>
                   </div>
                   <p class="italic text-on-surface-variant leading-relaxed">"Sangat terbantu untuk mengelola sampah kantor. Proses administrasinya sangat transparan dan akurat."</p>
                </div>
                <div class="flex items-center gap-4 border-t border-primary/5 pt-8">
                    <div class="w-12 h-12 rounded-full overflow-hidden bg-primary/10">
                        <img src="https://ui-avatars.com/api/?name=Abdul+Zein&background=2D4F1E&color=fff" alt="Abdul Zein">
                    </div>
                    <div>
                        <h5 class="font-bold text-primary headline">Abdul Zein</h5>
                        <p class="text-[10px] text-outline font-bold uppercase">Staf Administrasi</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-[#1A2E12] text-white py-20 px-8">
        <div class="max-w-7xl mx-auto text-center">
             <div class="flex items-center justify-center gap-2 mb-8">
                <div class="w-12 h-12 bg-primary rounded-2xl flex items-center justify-center text-white">
                    <span class="material-symbols-outlined text-[32px]">recycling</span>
                </div>
                <span class="text-4xl font-black text-white tracking-tighter headline">Waste.</span>
            </div>
            <p class="max-w-xl mx-auto text-white/50 text-sm mb-12">
                Bergabunglah bersama kami untuk menciptakan lingkungan yang lebih bersih. Waste. adalah jembatan antara sampah yang tak bernilai menjadi manfaat ekonomi bagi Anda.
            </p>
            <div class="flex flex-wrap justify-center gap-8 mb-16 font-bold uppercase tracking-[0.3em] text-[10px]">
                <a href="#" class="hover:text-primary transition-colors">Home</a>
                <a href="#" class="hover:text-primary transition-colors">About Us</a>
                <a href="#" class="hover:text-primary transition-colors">Services</a>
                <a href="#" class="hover:text-primary transition-colors">Contact</a>
            </div>
            <p class="text-white/20 text-[9px] font-black uppercase tracking-widest border-t border-white/5 pt-12">
                © 2026 The Organic Breath. All Rights Reserved. Designed for the Future.
            </p>
        </div>
    </footer>
</div>

<?php 
$hide_nav = true;
include 'includes/footer.php'; 
?>
