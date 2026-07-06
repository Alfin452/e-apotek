<x-superadmin-layout>
    
    <div class="mb-8">
        <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Overview</h1>
        <p class="text-slate-500 mt-1 font-medium">Pantau ringkasan aktivitas apotek hari ini.</p>
    </div>

    <!-- Bento Grid System -->
    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">

        <!-- Welcome Banner (Span 12) -->
        <div class="md:col-span-12 bg-brand-blue text-white rounded-3xl p-8 shadow-lg shadow-brand-blue/20 relative overflow-hidden flex flex-col justify-between">
            <!-- Decorative circle -->
            <div class="absolute top-[-50%] right-[-5%] w-96 h-96 bg-white/10 rounded-full blur-3xl pointer-events-none"></div>
            
            <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
                <div>
                    <h2 class="text-3xl font-extrabold mb-2">Selamat datang kembali, {{ explode(' ', Auth::user()->name)[0] }}!</h2>
                    <p class="text-blue-100 opacity-90 max-w-xl font-medium">Sistem berjalan normal. Ada {{ $todaySalesCount }} transaksi penjualan hari ini dan {{ \App\Models\Medicine::whereColumn('stock', '<=', 'min_stock')->count() }} obat yang membutuhkan perhatian stok.</p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('superadmin.sales.index') }}" class="inline-flex items-center justify-center gap-2 bg-white text-brand-blue px-6 py-3 rounded-xl font-bold text-sm hover:scale-[1.02] transition-transform shadow-sm">
                        Lihat Data Penjualan
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>
        </div>

        <!-- Quick Stat 1: Pendapatan (Span 4) -->
        <div class="md:col-span-4 bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm flex flex-col justify-center relative overflow-hidden group hover:border-emerald-500/30 transition-colors">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-emerald-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            </div>
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Pendapatan Hari Ini</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">Rp {{ number_format($todayRevenue, 0, ',', '.') }}</h3>
        </div>

        <!-- Quick Stat 2: Transaksi (Span 4) -->
        <div class="md:col-span-4 bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm flex flex-col justify-center relative overflow-hidden group hover:border-brand-blue/30 transition-colors">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-brand-blue" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
            </div>
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Transaksi Hari Ini</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">{{ $todaySalesCount }} <span class="text-lg text-slate-400 font-bold">Trx</span></h3>
        </div>

        <!-- Quick Stat 3: Pengeluaran Restock (Span 4) -->
        <div class="md:col-span-4 bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm flex flex-col justify-center relative overflow-hidden group hover:border-orange-500/30 transition-colors">
            <div class="absolute top-0 right-0 p-6 opacity-5 group-hover:opacity-10 transition-opacity">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 text-orange-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
            </div>
            <p class="text-sm font-bold text-slate-500 uppercase tracking-wider mb-2">Pengeluaran Restock Hari Ini</p>
            <h3 class="text-3xl font-black text-slate-900 tracking-tight">Rp {{ number_format($todayPurchases, 0, ',', '.') }}</h3>
        </div>

        <!-- Stok Obat Kritis Card (Span 6) -->
        <div class="md:col-span-6 bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-900">Peringatan Stok Obat</h3>
                <span class="px-3 py-1 rounded-full bg-brand-yellow/20 text-yellow-700 text-xs font-bold">{{ $lowStockMedicines->count() }} Kritis</span>
            </div>
            <div class="space-y-4 flex-1">
                @forelse($lowStockMedicines as $medicine)
                <div class="flex items-center justify-between p-4 rounded-2xl {{ $medicine->stock == 0 ? 'bg-red-50 border border-red-100' : 'bg-orange-50 border border-orange-100' }} transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="w-10 h-10 rounded-xl bg-white border border-slate-200 flex items-center justify-center text-xl shadow-sm">
                            {{ $medicine->stock == 0 ? '❌' : '⚠️' }}
                        </div>
                        <div>
                            <p class="font-bold text-slate-900 text-sm">{{ $medicine->name }}</p>
                            <p class="text-xs font-bold {{ $medicine->stock == 0 ? 'text-red-600' : 'text-orange-600' }}">Sisa {{ $medicine->stock }} (Min: {{ $medicine->min_stock }})</p>
                        </div>
                    </div>
                    <a href="{{ route('superadmin.purchases.create') }}" class="text-brand-blue text-xs font-bold hover:underline bg-white px-3 py-1.5 rounded-lg border border-slate-200 shadow-sm">Restock</a>
                </div>
                @empty
                <div class="flex flex-col items-center justify-center py-10 text-center h-full">
                    <div class="w-16 h-16 bg-emerald-500/10 text-emerald-600 rounded-full flex items-center justify-center mb-4">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" /></svg>
                    </div>
                    <p class="text-sm font-bold text-slate-700">Stok Obat Aman!</p>
                    <p class="text-xs text-slate-500 mt-1 max-w-[200px]">Belum ada obat yang mencapai batas stok minimum.</p>
                </div>
                @endforelse
            </div>
        </div>

        <!-- Aktivitas Terakhir (Span 6) -->
        <div class="md:col-span-6 bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm flex flex-col">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-lg font-bold text-slate-900">Aktivitas Terakhir</h3>
            </div>
            
            @if($activities->count() > 0)
            <div class="space-y-6 flex-1 relative before:absolute before:inset-0 before:ml-4 before:-translate-x-px md:before:mx-auto md:before:translate-x-0 before:h-full before:w-0.5 before:bg-gradient-to-b before:from-transparent before:via-slate-200 before:to-transparent">
                @foreach($activities as $activity)
                <!-- Activity Item -->
                <div class="relative flex items-center justify-between md:justify-normal md:odd:flex-row-reverse group is-active">
                    <!-- Icon -->
                    <div class="flex items-center justify-center w-8 h-8 rounded-full border border-white bg-slate-100 shadow shrink-0 md:order-1 md:group-odd:-translate-x-1/2 md:group-even:translate-x-1/2 relative z-10 {{ $activity->type == 'sale' ? 'bg-emerald-500/20 text-emerald-600' : 'bg-brand-yellow/20 text-yellow-700' }}">
                        @if($activity->type == 'sale')
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V9a2 2 0 00-2-2h-3m-1 4l-3 3m0 0l-3-3m3 3V4" /></svg>
                        @endif
                    </div>
                    <!-- Content -->
                    <div class="w-[calc(100%-3rem)] md:w-[calc(50%-2rem)] p-4 rounded-2xl shadow-sm border border-slate-100 bg-white group-hover:border-brand-blue/30 transition-colors ml-4 md:ml-0">
                        <div class="flex items-center justify-between mb-1">
                            <h4 class="font-bold text-slate-900 text-sm">{{ $activity->title }}</h4>
                        </div>
                        <p class="text-xs font-medium text-slate-500 mb-2">{{ $activity->description }}</p>
                    </div>
                </div>
                @endforeach
            </div>
            @else
            <div class="flex flex-col items-center justify-center py-10 text-center h-full">
                <div class="w-16 h-16 bg-slate-100 text-slate-400 rounded-full flex items-center justify-center mb-4">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <p class="text-sm font-bold text-slate-700">Belum Ada Aktivitas</p>
                <p class="text-xs text-slate-500 mt-1">Transaksi penjualan dan pembelian akan muncul di sini.</p>
            </div>
            @endif
        </div>

    </div>
</x-superadmin-layout>
