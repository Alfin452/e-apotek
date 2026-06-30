<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'E-Apotek') }} - Login</title>
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .eye-ball { transition: height 0.15s, transform 0.7s ease-in-out; }
        .pupil { transition: transform 0.1s ease-out; }
        .char-body { transition: transform 0.7s ease-in-out, height 0.7s ease-in-out; }
    </style>
</head>
<body class="font-sans antialiased text-slate-900 bg-white">
    <div class="min-h-screen grid lg:grid-cols-2">
        
        <!-- Left Content Section (Animated Characters) -->
        <div class="relative hidden lg:flex flex-col justify-between bg-white p-12 text-slate-900 overflow-hidden">
            <div class="relative z-20">
                <div class="flex items-center gap-2 text-lg font-semibold text-[#128837]">
                    <span>E-Apotek</span>
                </div>
            </div>

            <div class="relative z-20 flex items-end justify-center h-[500px]">
                <!-- Cartoon Characters Container -->
                <div class="relative w-[550px] h-[400px]" id="characters-container">
                    
                    <!-- Purple tall rectangle character - Back layer (Now Red Scrub) -->
                    <div id="purple-char" class="absolute bottom-0 char-body origin-bottom" style="left: 70px; width: 180px; height: 400px; background-color: #be123c; border-radius: 10px 10px 0 0; z-index: 1;">
                        
                        <!-- Nurse Hat Accessory -->
                        <div class="absolute top-[-25px] left-1/2 -translate-x-1/2 w-20 h-10 bg-slate-50 border border-slate-200 rounded-t-lg shadow-sm flex items-center justify-center">
                            <div class="w-10 h-3 bg-red-500 rounded-sm absolute"></div>
                            <div class="w-3 h-10 bg-red-500 rounded-sm absolute"></div>
                        </div>

                        <div id="purple-eyes-container" class="absolute flex gap-8 transition-all duration-700 ease-in-out" style="left: 45px; top: 40px;">
                            <div class="rounded-full flex items-center justify-center bg-white overflow-hidden eye-ball purple-eye" style="width: 18px; height: 18px;">
                                <div class="rounded-full pupil" style="width: 7px; height: 7px; background-color: #2D2D2D;"></div>
                            </div>
                            <div class="rounded-full flex items-center justify-center bg-white overflow-hidden eye-ball purple-eye" style="width: 18px; height: 18px;">
                                <div class="rounded-full pupil" style="width: 7px; height: 7px; background-color: #2D2D2D;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Black tall rectangle character - Middle layer -->
                    <div id="black-char" class="absolute bottom-0 char-body origin-bottom" style="left: 240px; width: 120px; height: 310px; background-color: #2D2D2D; border-radius: 8px 8px 0 0; z-index: 2;">
                        
                        <!-- Doctor's Head Mirror Accessory -->
                        <div class="absolute top-[-20px] left-1/2 -translate-x-1/2">
                            <div class="w-16 h-3 bg-slate-300 rounded-t-full relative">
                                <div class="absolute top-[-15px] left-1/2 -translate-x-1/2 w-10 h-10 rounded-full border-4 border-slate-300 bg-slate-100 flex items-center justify-center">
                                    <div class="w-3 h-3 bg-slate-400 rounded-full"></div>
                                </div>
                            </div>
                        </div>

                        <div id="black-eyes-container" class="absolute flex gap-6 transition-all duration-700 ease-in-out" style="left: 26px; top: 32px;">
                            <div class="rounded-full flex items-center justify-center bg-white overflow-hidden eye-ball black-eye" style="width: 16px; height: 16px;">
                                <div class="rounded-full pupil" style="width: 6px; height: 6px; background-color: #2D2D2D;"></div>
                            </div>
                            <div class="rounded-full flex items-center justify-center bg-white overflow-hidden eye-ball black-eye" style="width: 16px; height: 16px;">
                                <div class="rounded-full pupil" style="width: 6px; height: 6px; background-color: #2D2D2D;"></div>
                            </div>
                        </div>
                    </div>

                    <!-- Orange semi-circle character - Front left -->
                    <div id="orange-char" class="absolute bottom-0 char-body origin-bottom" style="left: 0px; width: 240px; height: 200px; z-index: 3; background-color: #FF9B6B; border-radius: 120px 120px 0 0;">
                        
                        <!-- Band-aid Accessory -->
                        <div class="absolute top-[30px] left-1/2 -translate-x-1/2 w-16 h-5 bg-amber-200 rounded-full -rotate-12 flex items-center justify-center border border-amber-300/50 shadow-inner">
                            <div class="w-4 h-5 bg-amber-300 border-x border-amber-400/50 flex flex-col items-center justify-center gap-[2px]">
                                <div class="w-1 h-1 bg-amber-500 rounded-full"></div>
                                <div class="w-1 h-1 bg-amber-500 rounded-full"></div>
                            </div>
                        </div>

                        <div id="orange-eyes-container" class="absolute flex gap-8 transition-all duration-200 ease-out" style="left: 82px; top: 90px;">
                            <div class="rounded-full pupil" style="width: 12px; height: 12px; background-color: #2D2D2D;"></div>
                            <div class="rounded-full pupil" style="width: 12px; height: 12px; background-color: #2D2D2D;"></div>
                        </div>
                    </div>

                    <!-- Yellow tall rectangle character - Front right -->
                    <div id="yellow-char" class="absolute bottom-0 char-body origin-bottom" style="left: 310px; width: 140px; height: 230px; background-color: #FBFC09; border-radius: 70px 70px 0 0; z-index: 4;">
                        
                        <!-- Doctor's Reflector Headband -->
                        <div class="absolute top-[25px] left-0 w-full h-4 bg-slate-100 border-y border-slate-300 shadow-sm flex items-center justify-center">
                            <div class="w-7 h-7 bg-white rounded-full border-[3px] border-slate-300 shadow-sm flex items-center justify-center absolute">
                                <div class="w-2 h-2 bg-slate-200 rounded-full"></div>
                            </div>
                        </div>

                        <div id="yellow-eyes-container" class="absolute flex gap-6 transition-all duration-200 ease-out" style="left: 52px; top: 40px;">
                            <div class="rounded-full pupil" style="width: 12px; height: 12px; background-color: #2D2D2D;"></div>
                            <div class="rounded-full pupil" style="width: 12px; height: 12px; background-color: #2D2D2D;"></div>
                        </div>
                        <div id="yellow-mouth" class="absolute w-20 h-[4px] bg-[#2D2D2D] rounded-full transition-all duration-200 ease-out" style="left: 40px; top: 88px;"></div>
                    </div>

                </div>
            </div>

            <div class="relative z-20 flex items-center gap-8 text-sm text-slate-400">
                <button type="button" id="btn-privacy" class="hover:text-slate-900 transition-colors">Kebijakan Privasi</button>
                <button type="button" id="btn-terms" class="hover:text-slate-900 transition-colors">Syarat Ketentuan</button>
                <button type="button" id="btn-contact" class="hover:text-slate-900 transition-colors">Kontak</button>
            </div>

            <!-- Decorative elements -->
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+CjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0ibm9uZSI+PC9yZWN0Pgo8Y2lyY2xlIGN4PSIyIiBjeT0iMiIgcj0iMSIgZmlsbD0icmdiYSgwLCAwLCAwLCAwLjAzKSI+PC9jaXJjbGU+Cjwvc3ZnPg==')] z-0"></div>
            <div class="absolute top-1/4 right-1/4 w-64 h-64 bg-slate-100 rounded-full blur-3xl z-0 pointer-events-none"></div>
            <div class="absolute bottom-1/4 left-1/4 w-96 h-96 bg-slate-50 rounded-full blur-3xl z-0 pointer-events-none"></div>
        </div>

        <!-- Right Login Section -->
        <div class="flex items-center justify-center p-8 bg-slate-950 relative z-10 text-white border-l border-slate-900">
            <div class="w-full max-w-[420px]">
                
                <!-- Mobile Logo -->
                <div class="lg:hidden flex items-center justify-center gap-2 text-lg font-semibold mb-12 text-[#128837]">
                    <span>E-Apotek</span>
                </div>

                <div class="text-center mb-10">
                    <h1 class="text-3xl font-bold tracking-tight mb-2 text-white">Selamat datang kembali!</h1>
                    <p class="text-slate-400 text-sm">Silakan masukkan detail akun Anda</p>
                </div>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf
                    
                    <div class="space-y-2">
                        <label for="email" class="text-sm font-medium text-slate-200">Email</label>
                        <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username" placeholder="anda@apotek.com"
                            class="flex h-12 w-full rounded-md border border-slate-800 bg-slate-900 px-3 py-2 text-sm text-white ring-offset-slate-950 file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#128837] focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-colors"
                        >
                        <x-input-error :messages="$errors->get('email')" class="mt-2 text-sm text-red-400" />
                    </div>

                    <div class="space-y-2">
                        <label for="password" class="text-sm font-medium text-slate-200">Kata Sandi</label>
                        <div class="relative">
                            <input id="password" type="password" name="password" required autocomplete="current-password" placeholder="••••••••"
                                class="flex h-12 w-full rounded-md border border-slate-800 bg-slate-900 px-3 py-2 pr-10 text-sm text-white ring-offset-slate-950 file:border-0 file:bg-transparent file:text-sm file:font-medium placeholder:text-slate-500 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#128837] focus-visible:ring-offset-2 disabled:cursor-not-allowed disabled:opacity-50 transition-colors"
                            >
                            <button type="button" id="toggle-password" class="absolute right-3 top-1/2 -translate-y-1/2 text-slate-500 hover:text-slate-300 transition-colors">
                                <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                            </button>
                        </div>
                        <x-input-error :messages="$errors->get('password')" class="mt-2 text-sm text-red-400" />
                    </div>

                    <div class="flex items-center justify-between">
                        <div class="flex items-center space-x-2">
                            <input id="remember_me" type="checkbox" name="remember" class="peer h-4 w-4 shrink-0 rounded-sm border border-slate-700 bg-slate-900 text-[#128837] focus:ring-[#128837] ring-offset-slate-950">
                            <label for="remember_me" class="text-sm font-normal cursor-pointer text-slate-400">Ingat saya selama 30 hari</label>
                        </div>
                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm text-[#128837] hover:text-[#128837]/80 hover:underline font-medium transition-colors">Lupa kata sandi?</a>
                        @endif
                    </div>

                    <button type="submit" class="inline-flex items-center justify-center whitespace-nowrap rounded-md text-base font-bold ring-offset-slate-950 transition-colors focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-[#128837] focus-visible:ring-offset-2 disabled:pointer-events-none disabled:opacity-50 bg-[#128837] text-white hover:bg-[#128837]/90 h-12 px-8 w-full shadow-lg shadow-[#128837]/20 mt-2">
                        Masuk
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modals Container -->
    <div id="modal-overlay" class="fixed inset-0 z-50 bg-slate-950/40 backdrop-blur-sm hidden flex items-center justify-center p-4 transition-opacity duration-300 opacity-0">
        
        <!-- Privacy Modal -->
        <div id="modal-privacy" class="modal-content hidden bg-white rounded-2xl p-8 max-w-lg w-full shadow-2xl transform scale-95 transition-transform duration-300">
            <h2 class="text-2xl font-bold text-slate-900 mb-4">Kebijakan Privasi</h2>
            <div class="text-slate-600 text-sm space-y-4 max-h-[60vh] overflow-y-auto pr-2">
                <p>Selamat datang di <strong>Sistem Informasi E-Apotek Berbasis Web</strong>. Privasi dan keamanan data Anda adalah prioritas utama kami.</p>
                <p>1. <strong>Pengumpulan Data:</strong> Kami mengumpulkan informasi yang Anda berikan secara langsung saat menggunakan sistem kami, seperti nama pegawai, peran (role), riwayat transaksi, dan rekam data pasien/obat.</p>
                <p>2. <strong>Penggunaan Data:</strong> Data yang terkumpul digunakan semata-mata untuk keperluan operasional apotek, manajemen stok, dan pelaporan internal.</p>
                <p>3. <strong>Keamanan Data:</strong> Kami berkomitmen untuk melindungi data pribadi dan medis Anda dengan enkripsi dan sistem keamanan berstandar industri demi mencegah akses yang tidak sah.</p>
            </div>
            <div class="mt-8 flex justify-end">
                <button type="button" class="close-modal-btn px-6 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition-colors focus:ring-2 focus:ring-slate-300 focus:outline-none">Tutup</button>
            </div>
        </div>

        <!-- Terms Modal -->
        <div id="modal-terms" class="modal-content hidden bg-white rounded-2xl p-8 max-w-lg w-full shadow-2xl transform scale-95 transition-transform duration-300">
            <h2 class="text-2xl font-bold text-slate-900 mb-4">Syarat & Ketentuan</h2>
            <div class="text-slate-600 text-sm space-y-4 max-h-[60vh] overflow-y-auto pr-2">
                <p>Dengan mengakses <strong>Sistem Informasi E-Apotek</strong>, Anda menyetujui seluruh syarat dan ketentuan berikut:</p>
                <p>1. <strong>Penggunaan Sistem:</strong> Sistem ini secara eksklusif ditujukan untuk manajemen internal apotek termasuk interaksi antara Superadmin, Pegawai, dan data Pasien.</p>
                <p>2. <strong>Akurasi Data:</strong> Pengguna (khususnya pegawai) wajib memastikan seluruh data yang di-input (pemasok, pembelian, penjualan, obat) adalah valid dan akurat.</p>
                <p>3. <strong>Pelanggaran & Sanksi:</strong> Setiap bentuk penyalahgunaan akses, pencurian data pasien, atau manipulasi laporan keuangan akan ditindaklanjuti secara hukum.</p>
            </div>
            <div class="mt-8 flex justify-end">
                <button type="button" class="close-modal-btn px-6 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition-colors focus:ring-2 focus:ring-slate-300 focus:outline-none">Tutup</button>
            </div>
        </div>

        <!-- Contact Modal -->
        <div id="modal-contact" class="modal-content hidden bg-white rounded-2xl p-8 max-w-md w-full shadow-2xl transform scale-95 transition-transform duration-300">
            <h2 class="text-2xl font-bold text-slate-900 mb-4">Kontak Kami</h2>
            <div class="text-slate-600 text-sm space-y-5">
                <p>Jika Anda mengalami kendala saat mengakses <strong>E-Apotek</strong> atau menemukan *bug*, silakan hubungi tim IT Support melalui:</p>
                <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div class="bg-[#128837]/10 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#128837]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" /></svg>
                    </div>
                    <span class="font-medium text-slate-700">support@e-apotek.com</span>
                </div>
                <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div class="bg-[#128837]/10 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#128837]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                    </div>
                    <span class="font-medium text-slate-700">+62 812 3456 7890</span>
                </div>
                <div class="flex items-center gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                    <div class="bg-[#128837]/10 p-2 rounded-lg">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-[#128837]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                    </div>
                    <span class="font-medium text-slate-700">APOTEK ANJIR PASAR KM 18</span>
                </div>
            </div>
            <div class="mt-8 flex justify-end">
                <button type="button" class="close-modal-btn px-6 py-2.5 bg-slate-100 text-slate-700 rounded-xl font-semibold hover:bg-slate-200 transition-colors focus:ring-2 focus:ring-slate-300 focus:outline-none">Tutup</button>
            </div>
        </div>
    </div>

    <!-- Animation Script (Vanilla JS Port of React Component) -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const emailInput = document.getElementById('email');
            const passwordInput = document.getElementById('password');
            const togglePasswordBtn = document.getElementById('toggle-password');
            const eyeIcon = document.getElementById('eye-icon');
            
            const chars = {
                purple: { body: document.getElementById('purple-char'), eyesC: document.getElementById('purple-eyes-container'), eyes: document.querySelectorAll('.purple-eye'), pupils: document.querySelectorAll('.purple-eye .pupil') },
                black: { body: document.getElementById('black-char'), eyesC: document.getElementById('black-eyes-container'), eyes: document.querySelectorAll('.black-eye'), pupils: document.querySelectorAll('.black-eye .pupil') },
                orange: { body: document.getElementById('orange-char'), eyesC: document.getElementById('orange-eyes-container'), pupils: document.querySelectorAll('#orange-eyes-container .pupil') },
                yellow: { body: document.getElementById('yellow-char'), eyesC: document.getElementById('yellow-eyes-container'), mouth: document.getElementById('yellow-mouth'), pupils: document.querySelectorAll('#yellow-eyes-container .pupil') }
            };

            let state = {
                mouseX: 0, mouseY: 0, isTyping: false, showPassword: false, passwordLength: 0,
                isLookingAtEachOther: false, isPurplePeeking: false
            };

            // Mouse tracking
            window.addEventListener('mousemove', (e) => {
                state.mouseX = e.clientX;
                state.mouseY = e.clientY;
                updateEyes();
                if(!state.isLookingAtEachOther && !state.showPassword) {
                    updateBodies();
                }
            });

            // Input handlers
            emailInput.addEventListener('focus', () => { state.isTyping = true; triggerLookAtEachOther(); });
            emailInput.addEventListener('blur', () => { state.isTyping = false; });
            passwordInput.addEventListener('input', (e) => { state.passwordLength = e.target.value.length; updateBodies(); updateEyes(); triggerPeek(); });

            // Password Toggle
            togglePasswordBtn.addEventListener('click', () => {
                state.showPassword = !state.showPassword;
                passwordInput.type = state.showPassword ? 'text' : 'password';
                eyeIcon.innerHTML = state.showPassword 
                    ? '<path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />'
                    : '<path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />';
                updateBodies();
                updateEyes();
            });

            // Timers
            function triggerLookAtEachOther() {
                state.isLookingAtEachOther = true;
                updateBodies(); updateEyes();
                setTimeout(() => { state.isLookingAtEachOther = false; updateBodies(); updateEyes(); }, 800);
            }

            let peekTimeout;
            function triggerPeek() {
                if (state.passwordLength > 0 && state.showPassword) {
                    clearTimeout(peekTimeout);
                    peekTimeout = setTimeout(() => {
                        state.isPurplePeeking = true;
                        updateEyes();
                        setTimeout(() => { state.isPurplePeeking = false; updateEyes(); }, 800);
                    }, Math.random() * 3000 + 2000);
                } else {
                    state.isPurplePeeking = false;
                }
            }

            // Blinking logic
            function blink(charKey) {
                const char = chars[charKey];
                if (!char.eyes) return;
                char.eyes.forEach(eye => {
                    eye.style.height = '2px';
                    Array.from(eye.children).forEach(c => c.style.display = 'none');
                });
                setTimeout(() => {
                    char.eyes.forEach(eye => {
                        eye.style.height = charKey === 'purple' ? '18px' : '16px';
                        Array.from(eye.children).forEach(c => c.style.display = 'block');
                    });
                    setTimeout(() => blink(charKey), Math.random() * 4000 + 3000);
                }, 150);
            }
            setTimeout(() => blink('purple'), 3000);
            setTimeout(() => blink('black'), 4000);

            // Calculation and Application
            function calculatePos(rect, isTall = true) {
                if(!rect) return { faceX: 0, faceY: 0, bodySkew: 0 };
                const centerX = rect.left + rect.width / 2;
                const centerY = rect.top + rect.height / 3;
                const deltaX = state.mouseX - centerX;
                const deltaY = state.mouseY - centerY;
                const faceX = Math.max(-15, Math.min(15, deltaX / 20));
                const faceY = Math.max(-10, Math.min(10, deltaY / 30));
                const bodySkew = Math.max(-6, Math.min(6, -deltaX / 120));
                return { faceX, faceY, bodySkew };
            }

            function getPupilPos(rect, forceX, forceY, maxDistance) {
                if(forceX !== undefined && forceY !== undefined) return {x: forceX, y: forceY};
                if(!rect) return {x:0, y:0};
                const cx = rect.left + rect.width / 2;
                const cy = rect.top + rect.height / 2;
                const dx = state.mouseX - cx;
                const dy = state.mouseY - cy;
                const dist = Math.min(Math.sqrt(dx*dx + dy*dy), maxDistance);
                const angle = Math.atan2(dy, dx);
                return { x: Math.cos(angle) * dist, y: Math.sin(angle) * dist };
            }

            function updateBodies() {
                const pRect = chars.purple.body.getBoundingClientRect();
                const pPos = calculatePos(pRect);
                const isHiding = state.passwordLength > 0 && !state.showPassword;
                const isExposed = state.passwordLength > 0 && state.showPassword;

                if (isExposed) {
                    chars.purple.body.style.transform = `skewX(0deg)`;
                    chars.purple.body.style.height = '400px';
                    chars.black.body.style.transform = `skewX(0deg)`;
                    chars.orange.body.style.transform = `skewX(0deg)`;
                    chars.yellow.body.style.transform = `skewX(0deg)`;
                } else if (state.isLookingAtEachOther) {
                    chars.purple.body.style.transform = `skewX(${pPos.bodySkew}deg)`;
                    chars.black.body.style.transform = `skewX(${calculatePos(chars.black.body.getBoundingClientRect()).bodySkew * 1.5 + 10}deg) translateX(20px)`;
                } else if (state.isTyping || isHiding) {
                    chars.purple.body.style.transform = `skewX(${pPos.bodySkew - 12}deg) translateX(40px)`;
                    chars.purple.body.style.height = '440px';
                    chars.black.body.style.transform = `skewX(${calculatePos(chars.black.body.getBoundingClientRect()).bodySkew * 1.5}deg)`;
                } else {
                    chars.purple.body.style.transform = `skewX(${pPos.bodySkew}deg)`;
                    chars.purple.body.style.height = '400px';
                    chars.black.body.style.transform = `skewX(${calculatePos(chars.black.body.getBoundingClientRect()).bodySkew}deg)`;
                    chars.orange.body.style.transform = `skewX(${calculatePos(chars.orange.body.getBoundingClientRect()).bodySkew}deg)`;
                    chars.yellow.body.style.transform = `skewX(${calculatePos(chars.yellow.body.getBoundingClientRect()).bodySkew}deg)`;
                }
            }

            function updateEyes() {
                const isExposed = state.passwordLength > 0 && state.showPassword;
                
                // Positions
                const pPos = calculatePos(chars.purple.body.getBoundingClientRect());
                const bPos = calculatePos(chars.black.body.getBoundingClientRect());
                const oPos = calculatePos(chars.orange.body.getBoundingClientRect());
                const yPos = calculatePos(chars.yellow.body.getBoundingClientRect());

                // Purple Eyes container
                chars.purple.eyesC.style.left = isExposed ? '20px' : (state.isLookingAtEachOther ? '55px' : `${45 + pPos.faceX}px`);
                chars.purple.eyesC.style.top = isExposed ? '35px' : (state.isLookingAtEachOther ? '65px' : `${40 + pPos.faceY}px`);
                
                // Purple Pupils
                let pForceX, pForceY;
                if(isExposed) { pForceX = state.isPurplePeeking ? 4 : -4; pForceY = state.isPurplePeeking ? 5 : -4; }
                else if(state.isLookingAtEachOther) { pForceX = 3; pForceY = 4; }
                
                chars.purple.pupils.forEach(p => {
                    const r = p.getBoundingClientRect();
                    const pos = getPupilPos(r, pForceX, pForceY, 5);
                    p.style.transform = `translate(${pos.x}px, ${pos.y}px)`;
                });

                // Black Eyes container
                chars.black.eyesC.style.left = isExposed ? '10px' : (state.isLookingAtEachOther ? '32px' : `${26 + bPos.faceX}px`);
                chars.black.eyesC.style.top = isExposed ? '28px' : (state.isLookingAtEachOther ? '12px' : `${32 + bPos.faceY}px`);

                // Black Pupils
                let bForceX, bForceY;
                if(isExposed) { bForceX = -4; bForceY = -4; }
                else if(state.isLookingAtEachOther) { bForceX = 0; bForceY = -4; }
                
                chars.black.pupils.forEach(p => {
                    const r = p.getBoundingClientRect();
                    const pos = getPupilPos(r, bForceX, bForceY, 4);
                    p.style.transform = `translate(${pos.x}px, ${pos.y}px)`;
                });

                // Orange Eyes
                chars.orange.eyesC.style.left = isExposed ? '50px' : `${82 + oPos.faceX}px`;
                chars.orange.eyesC.style.top = isExposed ? '85px' : `${90 + oPos.faceY}px`;
                chars.orange.pupils.forEach(p => {
                    const r = p.parentElement.getBoundingClientRect();
                    const pos = getPupilPos(r, isExposed ? -5 : undefined, isExposed ? -4 : undefined, 5);
                    p.style.transform = `translate(${pos.x}px, ${pos.y}px)`;
                });

                // Yellow Eyes & Mouth
                chars.yellow.eyesC.style.left = isExposed ? '20px' : `${52 + yPos.faceX}px`;
                chars.yellow.eyesC.style.top = isExposed ? '35px' : `${40 + yPos.faceY}px`;
                chars.yellow.mouth.style.left = isExposed ? '10px' : `${40 + yPos.faceX}px`;
                chars.yellow.mouth.style.top = isExposed ? '88px' : `${88 + yPos.faceY}px`;
                
                chars.yellow.pupils.forEach(p => {
                    const r = p.parentElement.getBoundingClientRect();
                    const pos = getPupilPos(r, isExposed ? -5 : undefined, isExposed ? -4 : undefined, 5);
                    p.style.transform = `translate(${pos.x}px, ${pos.y}px)`;
                });
            }

            // Modal Logic
            const modalOverlay = document.getElementById('modal-overlay');
            const modals = document.querySelectorAll('.modal-content');
            
            function openModal(id) {
                modalOverlay.classList.remove('hidden');
                // Allow display:block to apply before animating opacity/scale
                requestAnimationFrame(() => {
                    requestAnimationFrame(() => {
                        modalOverlay.classList.remove('opacity-0');
                        document.getElementById(id).classList.remove('hidden');
                        requestAnimationFrame(() => {
                            document.getElementById(id).classList.remove('scale-95');
                        });
                    });
                });
            }

            function closeModal() {
                modalOverlay.classList.add('opacity-0');
                modals.forEach(m => m.classList.add('scale-95'));
                setTimeout(() => {
                    modalOverlay.classList.add('hidden');
                    modals.forEach(m => m.classList.add('hidden'));
                }, 300);
            }

            document.getElementById('btn-privacy').addEventListener('click', (e) => { e.preventDefault(); openModal('modal-privacy'); });
            document.getElementById('btn-terms').addEventListener('click', (e) => { e.preventDefault(); openModal('modal-terms'); });
            document.getElementById('btn-contact').addEventListener('click', (e) => { e.preventDefault(); openModal('modal-contact'); });
            
            document.querySelectorAll('.close-modal-btn').forEach(btn => btn.addEventListener('click', closeModal));
            modalOverlay.addEventListener('click', (e) => {
                if (e.target === modalOverlay) closeModal();
            });

            // Init
            updateBodies();
            updateEyes();
        });
    </script>
</body>
</html>
