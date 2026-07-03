<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'E-Apotek') }} - Superadmin</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    
    <!-- Flatpickr CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    
    <!-- Tom Select CSS for Premium Dropdowns -->
    <link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
    <style>
        /* Custom Premium Styles for Tom Select to match Tailwind */
        .ts-wrapper {
            padding: 0 !important;
            border: none !important;
            background: transparent !important;
            box-shadow: none !important;
            border-radius: 0 !important;
        }
        .ts-wrapper .ts-control {
            border-radius: 0.75rem !important; /* rounded-xl */
            padding: 0.75rem 1rem !important; /* py-3 px-4 */
            border: 1px solid #e2e8f0 !important; /* border-slate-200 */
            background-color: #f8fafc !important; /* bg-slate-50 */
            box-shadow: none !important;
            font-size: 0.875rem !important; /* text-sm */
            font-weight: 500 !important; /* font-medium */
            color: #0f172a !important; /* text-slate-900 */
            transition: all 0.2s ease-in-out !important;
        }
        .ts-wrapper.focus .ts-control {
            background-color: #ffffff !important;
            border-color: #cbd5e1 !important; /* border-slate-300 */
            box-shadow: 0 0 0 2px #e2e8f0 !important; /* ring-slate-200 */
        }
        .ts-dropdown {
            border-radius: 0.75rem !important;
            border: 1px solid #e2e8f0 !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1) !important;
            padding: 0.5rem !important;
            margin-top: 0.25rem !important;
        }
        .ts-dropdown .option {
            border-radius: 0.5rem !important;
            padding: 0.5rem 0.75rem !important;
            font-size: 0.875rem !important;
            color: #475569 !important;
        }
        .ts-dropdown .option.active, .ts-dropdown .option:hover {
            background-color: #f1f5f9 !important; /* bg-slate-100 */
            color: #1e293b !important;
            font-weight: 600 !important;
        }

        /* Slim Toast Notification */
        .slim-toast {
            padding: 0.75rem 1.25rem !important;
            border-radius: 1rem !important; /* rounded-2xl */
            width: auto !important;
            min-width: 320px !important;
            max-width: 500px !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1), 0 4px 6px -2px rgba(0, 0, 0, 0.05) !important;
            display: flex !important;
            align-items: center !important;
            border: 1px solid #e2e8f0 !important;
            overflow: hidden !important;
        }
        .slim-toast .swal2-title {
            font-size: 0.875rem !important;
            font-weight: 600 !important;
            margin: 0 !important;
            padding: 0 !important;
            color: #0f172a !important;
        }
        .slim-toast .swal2-icon {
            width: 1.5rem !important;
            height: 1.5rem !important;
            margin: 0 0.75rem 0 0 !important;
            border: none !important;
            display: flex !important;
        }
        .slim-toast .swal2-timer-progress-bar {
            height: 3px !important;
            background-color: #22c55e !important;
        }
    </style>

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-[#F8FAFC] text-slate-800 selection:bg-brand-yellow selection:text-brand-blue">
    <div class="h-screen flex overflow-hidden">

        <!-- Premium Sleek Sidebar (w-56) -->
        <aside class="w-56 h-full shrink-0 bg-brand-blue border-r border-slate-800/50 flex flex-col transition-all duration-300 shadow-2xl z-40">
            
            <!-- Logo Section -->
            <div class="h-20 flex items-center justify-center border-b border-white/10 relative overflow-hidden">
                <!-- Subtle gradient glow -->
                <div class="absolute inset-0 bg-gradient-to-br from-brand-yellow/10 to-transparent opacity-50"></div>
                <div class="flex items-center gap-3 relative z-10">
                    <!-- Image Logo -->
                    <img src="{{ asset('build/icon/logo.png') }}" alt="E-Apotek Logo" class="w-9 h-9 object-contain drop-shadow-[0_0_8px_rgba(251,252,9,0.3)]">
                    <span class="text-lg font-extrabold tracking-tight text-white">E-Apotek</span>
                </div>
            </div>
            
            <!-- Navigation -->
            <nav class="flex-1 px-3 py-6 space-y-1 overflow-y-auto custom-scrollbar">
                
                <a href="{{ route('superadmin.dashboard') }}" class="flex items-center gap-3 px-3 py-2.5 rounded-lg {{ request()->routeIs('superadmin.dashboard') ? 'bg-white/10 text-brand-yellow font-semibold shadow-inner border border-white/5' : 'text-slate-400 font-medium hover:bg-white/5 hover:text-white' }} transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('superadmin.dashboard') ? '' : 'opacity-80' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" /></svg>
                    <span class="text-sm tracking-wide">Beranda</span>
                </a>
                
                <div class="pt-4 pb-2">
                    <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Manajemen</p>
                </div>

                <div x-data="{ open: {{ request()->routeIs('superadmin.medicines.*') ? 'true' : 'false' }} }">
                    <button @click="open = !open" class="w-full flex items-center justify-between px-3 py-2.5 rounded-lg {{ request()->routeIs('superadmin.medicines.*') ? 'bg-white/10 text-brand-yellow font-semibold shadow-inner border border-white/5' : 'text-slate-400 font-medium hover:bg-white/5 hover:text-white' }} transition-all">
                        <div class="flex items-center gap-3">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 {{ request()->routeIs('superadmin.medicines.*') ? '' : 'opacity-80' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" /></svg>
                            <span class="text-sm tracking-wide">Obat</span>
                        </div>
                        <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                    </button>
                    
                    <div x-show="open" x-transition.opacity.duration.200ms class="mt-1 space-y-1 pl-11">
                        <a href="{{ route('superadmin.medicines.index') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('superadmin.medicines.index') || request()->routeIs('superadmin.medicines.create') || request()->routeIs('superadmin.medicines.edit') ? 'text-brand-yellow font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }} transition-colors">
                            Data Obat
                        </a>
                        <a href="{{ route('superadmin.medicines.expired') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('superadmin.medicines.expired') ? 'text-brand-yellow font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }} transition-colors">
                            Kadaluarsa Obat
                        </a>
                        <a href="{{ route('superadmin.medicines.out_of_stock') }}" class="block px-3 py-2 rounded-lg text-sm {{ request()->routeIs('superadmin.medicines.out_of_stock') ? 'text-brand-yellow font-medium' : 'text-slate-400 hover:text-white hover:bg-white/5' }} transition-colors">
                            Obat Habis
                        </a>
                    </div>
                </div>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 font-medium hover:bg-white/5 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" /></svg>
                    <span class="text-sm tracking-wide">Kategori & Unit</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 font-medium hover:bg-white/5 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" /></svg>
                    <span class="text-sm tracking-wide">Pemasok</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Transaksi</p>
                </div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 font-medium hover:bg-white/5 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    <span class="text-sm tracking-wide">Penjualan</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 font-medium hover:bg-white/5 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" /></svg>
                    <span class="text-sm tracking-wide">Pembelian</span>
                </a>

                <div class="pt-4 pb-2">
                    <p class="px-3 text-xs font-semibold text-slate-500 uppercase tracking-wider">Sistem</p>
                </div>

                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 font-medium hover:bg-white/5 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                    <span class="text-sm tracking-wide">Manajemen User</span>
                </a>
                <a href="#" class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-400 font-medium hover:bg-white/5 hover:text-white transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                    <span class="text-sm tracking-wide">Laporan</span>
                </a>
            </nav>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col min-w-0 h-full bg-[#F8FAFC] relative">
            
            <!-- Sleek Top Navigation -->
            <header class="h-20 bg-white/70 backdrop-blur-xl border-b border-slate-200/60 flex items-center justify-between px-10 sticky top-0 z-30 shadow-sm">
                <div>
                    <h2 class="text-2xl font-bold text-slate-900 tracking-tight">Dashboard</h2>
                </div>
                <div class="flex items-center gap-6">
                    
                    <!-- Notification Bell -->
                    <button class="relative p-2.5 text-slate-400 hover:text-brand-blue transition-colors rounded-full hover:bg-slate-100 focus:outline-none focus:ring-2 focus:ring-brand-blue/20">
                        <span class="absolute top-2 right-2 w-2.5 h-2.5 bg-red-500 rounded-full border-2 border-white animate-pulse"></span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                        </svg>
                    </button>

                    <div class="h-8 w-px bg-slate-200"></div>

                    <!-- User Menu -->
                    <div class="flex items-center gap-4 cursor-pointer group">
                        <div class="flex flex-col text-right">
                            <span class="text-sm font-bold text-slate-900 group-hover:text-brand-blue transition-colors">{{ Auth::user()->name }}</span>
                            <span class="text-xs font-semibold text-brand-blue/60 uppercase tracking-wider">{{ Auth::user()->role }}</span>
                        </div>
                        <div class="w-11 h-11 rounded-full bg-gradient-to-tr from-brand-blue to-brand-blue/80 flex items-center justify-center text-brand-yellow font-bold text-lg shadow-md shadow-brand-blue/20 border-2 border-white ring-2 ring-transparent group-hover:ring-brand-yellow transition-all">
                            {{ substr(Auth::user()->name, 0, 1) }}
                        </div>
                        
                        <form method="POST" action="{{ route('logout') }}" class="ml-2" id="logout-form">
                            @csrf
                            <button type="button" onclick="confirmLogout()" class="p-2 text-slate-300 hover:text-red-500 transition-colors rounded-full hover:bg-red-50 focus:outline-none" title="Log Out">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <!-- Page Content -->
            <main class="p-10 flex-1 overflow-y-auto">
                <div class="max-w-7xl mx-auto">
                    {{ $slot }}
                </div>
            </main>
        </div>

    </div>

    <!-- Flatpickr JS -->
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://npmcdn.com/flatpickr/dist/l10n/id.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const datepickers = flatpickr(".datepicker", {
                dateFormat: "Y-m-d",
                allowInput: true,
                altInput: true,
                altFormat: "d F Y",
                locale: "id"
            });
            
            // Tutup kalender saat main content di-scroll agar tidak tertinggal / terpisah
            const mainContainer = document.querySelector('main');
            if (mainContainer) {
                mainContainer.addEventListener('scroll', function() {
                    if (Array.isArray(datepickers)) {
                        datepickers.forEach(fp => fp.close());
                    } else if (datepickers) {
                        datepickers.close();
                    }
                });
            }
        });
    </script>

    <!-- Tom Select JS -->
    <script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelectorAll('select').forEach((el) => {
                // Abaikan select bawaan dari Flatpickr agar tidak rusak
                if (el.classList.contains('flatpickr-monthDropdown-months')) return;

                new TomSelect(el, {
                    create: false,
                    sortField: {
                        field: "text",
                        direction: "asc"
                    }
                });
            });
        });
    </script>

    <!-- SweetAlert2 Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        @if(session('success'))
        document.addEventListener('DOMContentLoaded', function() {
            Swal.fire({
                toast: true,
                position: 'top',
                icon: 'success',
                title: "{{ session('success') }}",
                showConfirmButton: false,
                timer: 3000,
                timerProgressBar: true,
                background: '#ffffff',
                customClass: {
                    popup: 'slim-toast mt-4'
                }
            });
        });
        @endif

        // Global Logout Confirmation
        function confirmLogout() {
            Swal.fire({
                title: 'Keluar dari Aplikasi?',
                text: "Anda akan mengakhiri sesi ini.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#122837', // Uniform Blue
                cancelButtonColor: '#ef4444',
                confirmButtonText: 'Ya, Keluar!',
                cancelButtonText: 'Batal',
                background: '#ffffff',
                color: '#0F172A',
                customClass: {
                    confirmButton: 'shadow-lg shadow-brand-blue/30 rounded-lg',
                    cancelButton: 'rounded-lg'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    document.getElementById('logout-form').submit();
                }
            })
        }

        // Global Form Confirmation (tambahkan class "confirm-form" di form mana saja untuk memanggil swal otomatis)
        document.addEventListener('DOMContentLoaded', function () {
            const confirmForms = document.querySelectorAll('.confirm-form');
            confirmForms.forEach(form => {
                form.addEventListener('submit', function (e) {
                    e.preventDefault();
                    const actionName = form.dataset.action || 'melanjutkan tindakan ini';
                    Swal.fire({
                        title: 'Konfirmasi',
                        text: `Apakah Anda yakin ingin ${actionName}?`,
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonColor: '#122837',
                        cancelButtonColor: '#ef4444',
                        confirmButtonText: 'Ya, Lanjutkan',
                        cancelButtonText: 'Batal',
                        customClass: {
                            confirmButton: 'shadow-lg shadow-brand-blue/30 rounded-lg',
                            cancelButton: 'rounded-lg'
                        }
                    }).then((result) => {
                        if (result.isConfirmed) {
                            form.submit();
                        }
                    })
                });
            });
        });
    </script>
</body>
</html>
