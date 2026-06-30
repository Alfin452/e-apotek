<x-superadmin-layout>
    
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Overview</h1>
        <p class="text-slate-500 mt-1 font-medium">Pantau ringkasan aktivitas apotek hari ini.</p>
    </div>

    <!-- Bento Grid System -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        <!-- Welcome Banner (Span 8) -->
        <div class="md:col-span-8 bg-brand-green text-white rounded-3xl p-8 shadow-lg shadow-brand-green/20 relative overflow-hidden flex flex-col justify-between min-h-[200px]">
            <!-- Decorative circle -->
            <div class="absolute top-[-20%] right-[-10%] w-64 h-64 bg-white/10 rounded-full blur-2xl pointer-events-none"></div>
            
            <div class="relative z-10">
                <span class="inline-block px-3 py-1 bg-brand-yellow text-slate-900 text-xs font-bold rounded-full mb-4 uppercase tracking-wider">Superadmin Panel</span>
                <h2 class="text-3xl font-extrabold mb-2">Selamat datang kembali, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
                <p class="text-brand-green-100 opacity-90 max-w-md font-medium">Sistem berjalan normal. Ada 12 transaksi baru dan 5 stok obat yang hampir habis hari ini.</p>
            </div>
            
            <div class="relative z-10 mt-6">
                <a href="#" class="inline-flex items-center gap-2 bg-white text-brand-green px-5 py-2.5 rounded-xl font-bold text-sm hover:scale-[1.02] transition-transform shadow-sm">
                    Lihat Laporan Harian
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                </a>
            </div>
        </div>

        <!-- Quick Stat 1 (Span 4) -->
        <div class="md:col-span-4 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm flex flex-col justify-center relative overflow-hidden group hover:border-brand-green/30 transition-colors">
            <div class="absolute top-0 right-0 p-6 opacity-10 group-hover:opacity-20 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-brand-green" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <p class="text-sm font-semibold text-slate-500 mb-1">Pendapatan Hari Ini</p>
            <h3 class="text-4xl font-extrabold text-slate-900 tracking-tight">Rp 8.5M</h3>
            <div class="mt-4 flex items-center text-sm font-medium text-brand-green">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
                <span>+14.5% dari kemarin</span>
            </div>
        </div>

        <!-- Stok Obat Card (Span 6) -->
        <div class="md:col-span-6 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-900">Peringatan Stok Obat</h3>
                <span class="w-8 h-8 rounded-full bg-brand-yellow/20 text-yellow-700 flex items-center justify-center font-bold">3</span>
            </div>
            <div class="space-y-4">
                <!-- Item -->
                <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-xl">💊</div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">Paracetamol 500mg</p>
                            <p class="text-xs font-medium text-slate-500">Sisa 12 Strip</p>
                        </div>
                    </div>
                    <button class="text-brand-green text-sm font-bold hover:underline">Restock</button>
                </div>
                <!-- Item -->
                <div class="flex items-center justify-between p-4 rounded-2xl bg-slate-50">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-xl">💉</div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">Amoxicillin 250mg</p>
                            <p class="text-xs font-medium text-red-500">Sisa 2 Box</p>
                        </div>
                    </div>
                    <button class="text-brand-green text-sm font-bold hover:underline">Restock</button>
                </div>
            </div>
        </div>

        <!-- Aktivitas Terakhir (Span 6) -->
        <div class="md:col-span-6 bg-white rounded-3xl p-8 border border-slate-100 shadow-sm">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-900">Aktivitas Pegawai</h3>
                <a href="#" class="text-sm font-bold text-brand-green hover:underline">Lihat Semua</a>
            </div>
            <div class="space-y-6">
                <!-- Activity Item -->
                <div class="flex gap-4 relative">
                    <div class="absolute left-4 top-10 bottom-[-24px] w-px bg-slate-100"></div>
                    <div class="w-8 h-8 rounded-full bg-brand-green/10 text-brand-green flex items-center justify-center shrink-0 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Transaksi #TRX-9921 berhasil</p>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Kasir: Budi Santoso • 2 menit yang lalu</p>
                    </div>
                </div>
                <!-- Activity Item -->
                <div class="flex gap-4 relative">
                    <div class="w-8 h-8 rounded-full bg-brand-yellow/20 text-yellow-700 flex items-center justify-center shrink-0 z-10">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                    </div>
                    <div>
                        <p class="text-sm font-bold text-slate-900">Penerimaan Barang: PT. Kimia Farma</p>
                        <p class="text-xs font-medium text-slate-500 mt-0.5">Gudang: Siti Aminah • 45 menit yang lalu</p>
                    </div>
                </div>
            </div>
        </div>

    </div>
</x-superadmin-layout>
