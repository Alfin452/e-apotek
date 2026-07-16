<!DOCTYPE html>
<html lang="id" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>E-Apotek | Sistem Manajemen Apotek Terpercaya</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />
    
    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #ffffff;
            color: #334155;
        }

        /* Clean CSS Animations */
        @keyframes slideInLeft {
            0% { opacity: 0; transform: translateX(-50px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        @keyframes slideInRight {
            0% { opacity: 0; transform: translateX(50px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        @keyframes fadeInDown {
            0% { opacity: 0; transform: translateY(-20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(20px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        /* Animation Classes */
        .animate-slide-left {
            animation: slideInLeft 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .animate-slide-right {
            animation: slideInRight 0.8s cubic-bezier(0.16, 1, 0.3, 1) forwards;
            opacity: 0;
        }

        .animate-fade-down {
            animation: fadeInDown 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .animate-fade-up {
            animation: fadeInUp 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
        }

        .delay-100 { animation-delay: 100ms; }
        .delay-200 { animation-delay: 200ms; }
        .delay-300 { animation-delay: 300ms; }

        /* Clean Background Pattern */
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#cbd5e1 1px, transparent 1px);
            background-size: 32px 32px;
        }
    </style>
</head>
<body class="antialiased overflow-x-hidden">

    <!-- Navigation (Clean & Light) -->
    <nav class="fixed w-full z-50 bg-white/90 backdrop-blur-md border-b border-slate-200 shadow-sm animate-fade-down">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-20">
                <!-- Logo -->
                <a href="#" class="flex items-center gap-3">
                    <img src="{{ asset('build/icon/logo.png') }}" alt="Logo" class="w-10 h-10 object-contain">
                    <span class="text-2xl font-extrabold text-brand-blue tracking-tight">E-Apotek</span>
                </a>
                
                <!-- Center Links -->
                <div class="hidden md:flex space-x-8">
                    <a href="#fitur" class="text-sm font-semibold text-slate-600 hover:text-brand-blue transition-colors">Fitur Utama</a>
                    <a href="#manfaat" class="text-sm font-semibold text-slate-600 hover:text-brand-blue transition-colors">Manfaat</a>
                    <a href="#kontak" class="text-sm font-semibold text-slate-600 hover:text-brand-blue transition-colors">Hubungi Kami</a>
                </div>

                <!-- Right Action -->
                <div class="flex items-center space-x-4">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('superadmin.dashboard') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-brand-blue text-white font-bold text-sm rounded-lg hover:bg-blue-800 transition-colors shadow-sm">
                                Masuk Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-5 py-2.5 bg-brand-blue text-white font-bold text-sm rounded-lg hover:bg-blue-800 transition-colors shadow-sm">
                                Login
                            </a>
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section (Light & Professional) -->
    <section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 bg-pattern">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                
                <!-- Text Content -->
                <div class="w-full lg:w-1/2 text-center lg:text-left">
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-black text-slate-900 leading-tight mb-6 animate-fade-up">
                        Manajemen Apotek <span class="text-brand-blue">Lebih Profesional dan Akurat.</span>
                    </h1>
                    <p class="text-lg text-slate-600 mb-8 max-w-xl mx-auto lg:mx-0 animate-fade-up delay-100">
                        Platform Point of Sale (POS) dan manajemen inventaris yang dirancang khusus untuk mempermudah operasional apotek modern. Kelola penjualan, stok obat, hingga laporan tanpa repot.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 justify-center lg:justify-start animate-fade-up delay-200">
                        @auth
                            <a href="{{ route('superadmin.dashboard') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-brand-yellow text-slate-900 font-bold text-lg rounded-xl hover:bg-yellow-400 transition-colors shadow-sm">
                                Akses Sistem
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="inline-flex items-center justify-center px-8 py-3.5 bg-brand-yellow text-slate-900 font-bold text-lg rounded-xl hover:bg-yellow-400 transition-colors shadow-sm">
                                Mulai Gunakan
                            </a>
                        @endauth
                        <a href="#fitur" class="inline-flex items-center justify-center px-8 py-3.5 bg-white border border-slate-300 text-slate-700 font-bold text-lg rounded-xl hover:bg-slate-50 transition-colors">
                            Lihat Fitur
                        </a>
                    </div>
                </div>

                <!-- Hero Image/Illustration (Clean UI Mockup representation) -->
                <div class="w-full lg:w-1/2 animate-slide-right delay-200">
                    <div class="bg-white p-2 rounded-2xl shadow-xl border border-slate-200">
                        <div class="bg-slate-50 rounded-xl p-4 border border-slate-100">
                            <!-- Mockup Header -->
                            <div class="flex justify-between items-center mb-6 pb-4 border-b border-slate-200">
                                <div class="w-32 h-6 bg-slate-200 rounded"></div>
                                <div class="w-10 h-10 bg-brand-blue rounded-full"></div>
                            </div>
                            <!-- Mockup Stats -->
                            <div class="grid grid-cols-2 gap-4 mb-6">
                                <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-100">
                                    <div class="w-16 h-4 bg-slate-200 rounded mb-2"></div>
                                    <div class="w-24 h-8 bg-slate-800 rounded"></div>
                                </div>
                                <div class="bg-white p-4 rounded-lg shadow-sm border border-slate-100">
                                    <div class="w-16 h-4 bg-slate-200 rounded mb-2"></div>
                                    <div class="w-24 h-8 bg-brand-blue rounded"></div>
                                </div>
                            </div>
                            <!-- Mockup Table -->
                            <div class="bg-white rounded-lg shadow-sm border border-slate-100 p-4 space-y-3">
                                <div class="w-full h-8 bg-slate-100 rounded"></div>
                                <div class="w-full h-8 bg-slate-50 rounded"></div>
                                <div class="w-full h-8 bg-slate-50 rounded"></div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </section>

    <!-- Fitur Section -->
    <section id="fitur" class="py-24 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center max-w-3xl mx-auto mb-16">
                <h2 class="text-brand-blue font-bold tracking-wider uppercase text-sm mb-2">Fitur Utama</h2>
                <h3 class="text-3xl font-black text-slate-900">Sistem Lengkap Untuk Apotek Anda</h3>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <!-- Feature 1 (Slide Left) -->
                <div class="bg-slate-50 border border-slate-200 p-8 rounded-2xl hover:shadow-lg transition-shadow animate-slide-left">
                    <div class="w-12 h-12 bg-brand-blue rounded-lg flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 7h6m0 10v-3m-3 3h.01M9 17h.01M9 14h.01M12 14h.01M15 11h.01M12 11h.01M9 11h.01M7 21h10a2 2 0 002-2V5a2 2 0 00-2-2H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Kasir POS Dinamis</h4>
                    <p class="text-slate-600">Lakukan transaksi penjualan obat dengan cepat. Dilengkapi perhitungan otomatis uang tunai dan kembalian, serta struk pembayaran yang siap dicetak.</p>
                </div>

                <!-- Feature 2 (Fade Up) -->
                <div class="bg-slate-50 border border-slate-200 p-8 rounded-2xl hover:shadow-lg transition-shadow animate-fade-up delay-100">
                    <div class="w-12 h-12 bg-brand-yellow rounded-lg flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-slate-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Manajemen Stok Terpusat</h4>
                    <p class="text-slate-600">Kontrol ketersediaan obat secara akurat. Tambah persediaan melalui form restock pembelian dan kurangi otomatis saat ada penjualan harian.</p>
                </div>

                <!-- Feature 3 (Slide Right) -->
                <div class="bg-slate-50 border border-slate-200 p-8 rounded-2xl hover:shadow-lg transition-shadow animate-slide-right delay-200">
                    <div class="w-12 h-12 bg-red-500 rounded-lg flex items-center justify-center mb-6">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                    <h4 class="text-xl font-bold text-slate-900 mb-3">Monitoring Kadaluarsa</h4>
                    <p class="text-slate-600">Sistem pintar yang akan memberikan informasi obat apa saja yang akan segera kadaluarsa (expired) atau yang stoknya mulai menipis (habis).</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Manfaat Section -->
    <section id="manfaat" class="py-24 bg-slate-50 border-y border-slate-200">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col lg:flex-row items-center gap-16">
                <div class="lg:w-1/2 animate-slide-left">
                    <img src="https://images.unsplash.com/photo-1585435557343-3b092031a831?ixlib=rb-4.0.3&auto=format&fit=crop&w=800&q=80" alt="Farmasi" class="rounded-2xl shadow-lg border border-slate-200">
                </div>
                <div class="lg:w-1/2 animate-slide-right">
                    <h2 class="text-brand-blue font-bold tracking-wider uppercase text-sm mb-2">Mengapa E-Apotek?</h2>
                    <h3 class="text-3xl font-black text-slate-900 mb-6">Transformasi Digital untuk Kepuasan Pelanggan</h3>
                    
                    <div class="space-y-6 mt-8">
                        <div class="flex gap-4">
                            <div class="shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Efisiensi Waktu</h4>
                                <p class="text-slate-600 mt-1">Laporan harian, bulanan, dan stok dicetak otomatis tanpa perlu rekap manual di buku besar.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Keamanan Data</h4>
                                <p class="text-slate-600 mt-1">Pembatasan akses dengan sistem Multi-Role. Kasir hanya bisa melayani, sementara hak kelola master data ada di Apoteker dan Superadmin.</p>
                            </div>
                        </div>
                        <div class="flex gap-4">
                            <div class="shrink-0 w-10 h-10 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                            </div>
                            <div>
                                <h4 class="text-lg font-bold text-slate-900">Minimalkan Kesalahan</h4>
                                <p class="text-slate-600 mt-1">Hindari kehilangan stok atau salah harga berkat basis data inventaris yang saling terhubung di seluruh sistem.</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Kontak Section -->
    <section id="kontak" class="py-24 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center animate-fade-up">
            <h2 class="text-3xl font-black text-slate-900 mb-6">Butuh Bantuan Teknis?</h2>
            <p class="text-lg text-slate-600 mb-10">Tim dukungan kami siap membantu apotek Anda berkembang dan menyelesaikan masalah yang Anda hadapi 24/7.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-left">
                <div class="bg-slate-50 border border-slate-200 p-6 rounded-xl flex items-start gap-4">
                    <div class="w-10 h-10 bg-brand-blue/10 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900">Email Dukungan</h4>
                        <p class="text-slate-600 mt-1">support@e-apotek.com</p>
                    </div>
                </div>
                <div class="bg-slate-50 border border-slate-200 p-6 rounded-xl flex items-start gap-4">
                    <div class="w-10 h-10 bg-brand-blue/10 rounded-lg flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z"></path></svg>
                    </div>
                    <div>
                        <h4 class="font-bold text-slate-900">Layanan Pelanggan</h4>
                        <p class="text-slate-600 mt-1">+62 811 2345 6789</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-slate-900 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 flex flex-col md:flex-row justify-between items-center text-slate-400 text-sm">
            <div class="flex items-center gap-2 mb-4 md:mb-0">
                <span class="text-white font-extrabold text-lg">E-Apotek</span>
                <span>&copy; 2026. Hak Cipta Dilindungi.</span>
            </div>
            <div class="flex space-x-6">
                <a href="#" class="hover:text-white transition-colors">Kebijakan Privasi</a>
                <a href="#" class="hover:text-white transition-colors">Syarat Ketentuan</a>
            </div>
        </div>
    </footer>

    <!-- Animation Trigger on Scroll -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const observerOptions = {
                root: null,
                rootMargin: '0px',
                threshold: 0.1
            };

            const observer = new IntersectionObserver((entries, observer) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        entry.target.style.animationPlayState = 'running';
                        observer.unobserve(entry.target);
                    }
                });
            }, observerOptions);

            const animatedElements = document.querySelectorAll('.animate-slide-left, .animate-slide-right, .animate-fade-up, .animate-fade-down');
            
            animatedElements.forEach(el => {
                el.style.animationPlayState = 'paused';
                observer.observe(el);
            });
        });
    </script>
</body>
</html>
