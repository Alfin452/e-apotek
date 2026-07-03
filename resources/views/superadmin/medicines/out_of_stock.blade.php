<x-superadmin-layout>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pusat Peringatan Stok</h1>
            <p class="text-slate-500 mt-1">Pantau ketersediaan fisik obat yang sedang kosong atau menipis.</p>
        </div>
    </div>



    <!-- Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Empty Card -->
        <div class="bg-red-50/50 rounded-3xl p-6 border border-red-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-100 rounded-full opacity-50 blur-xl"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-red-600/80 uppercase tracking-wider mb-1">Kosong Total (Habis)</p>
                    <h3 class="text-4xl font-black text-red-700">{{ $countEmpty }}</h3>
                    <p class="text-xs font-medium text-red-500 mt-2">Tidak bisa dijual sama sekali.</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 12H4m8-8v16" /></svg>
                </div>
            </div>
        </div>

        <!-- Low Card -->
        <div class="bg-orange-50/50 rounded-3xl p-6 border border-orange-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-100 rounded-full opacity-50 blur-xl"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-orange-600/80 uppercase tracking-wider mb-1">Menipis (< Min Stok)</p>
                    <h3 class="text-4xl font-black text-orange-600">{{ $countLow }}</h3>
                    <p class="text-xs font-medium text-orange-500 mt-2">Segera jadwalkan pembelian.</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6" /></svg>
                </div>
            </div>
        </div>

        <!-- Restock Value Card -->
        <div class="bg-slate-900 rounded-3xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+CjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0ibm9uZSI+PC9yZWN0Pgo8Y2lyY2xlIGN4PSIyIiBjeT0iMiIgcj0iMSIgZmlsbD0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjAzKSI+PC9jaXJjbGU+Cjwvc3ZnPg==')] z-0"></div>
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-brand-blue/20 rounded-full blur-2xl z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Estimasi Modal Restock</p>
                    <h3 class="text-3xl font-black text-white">Rp {{ number_format($restockValue, 0, ',', '.') }}</h3>
                    <p class="text-xs font-medium text-slate-500 mt-2">Untuk memenuhi defisit minimum stok.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Bento Box -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 overflow-hidden">
        
        <!-- Filter & Legend -->
        <div class="flex flex-col md:flex-row gap-6 justify-between items-center mb-8 border-b border-slate-100 pb-6">
            <form action="{{ route('superadmin.medicines.out_of_stock') }}" method="GET" class="w-full md:w-1/3 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari obat habis..." class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-orange-200 focus:border-orange-300 transition-all text-sm font-medium text-slate-800 placeholder-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </form>

            <div class="flex flex-wrap gap-4 items-center bg-slate-50 px-5 py-3 rounded-2xl border border-slate-100">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mr-2">Indikator:</span>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-500 animate-pulse shadow-[0_0_8px_rgba(239,68,68,0.6)]"></span>
                    <span class="text-xs font-semibold text-slate-600">Habis Total (= 0)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-orange-400 shadow-[0_0_8px_rgba(249,115,22,0.4)]"></span>
                    <span class="text-xs font-semibold text-slate-600">Menipis (<= Min)</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/50 text-slate-500 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-4 rounded-tl-xl">Status</th>
                        <th class="px-4 py-4">Nama Obat</th>
                        <th class="px-4 py-4">Stok Saat Ini</th>
                        <th class="px-4 py-4">Batas Minimal</th>
                        <th class="px-4 py-4">Pemasok</th>
                        <th class="px-4 py-4 text-right rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($medicines as $med)
                        @php
                            $statusColor = 'bg-orange-400 shadow-[0_0_8px_rgba(249,115,22,0.4)]';
                            $statusText = 'text-orange-700';
                            $statusBg = 'bg-orange-50 border border-orange-100';
                            $statusIcon = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                            $statusLabel = 'Menipis';

                            if ($med->stock <= 0) {
                                $statusColor = 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)] animate-pulse';
                                $statusText = 'text-red-700';
                                $statusBg = 'bg-red-50 border border-red-100';
                                $statusIcon = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                                $statusLabel = 'Habis Total';
                            }
                        @endphp
                    <tr class="hover:bg-slate-50 transition-colors group">
                        <td class="px-4 py-4">
                            <div class="inline-flex items-center gap-2 px-2.5 py-1.5 rounded-lg {{ $statusBg }} {{ $statusText }} font-bold text-xs">
                                <span class="w-2 h-2 rounded-full {{ $statusColor }}"></span>
                                {!! $statusIcon !!}
                                <span>{{ $statusLabel }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-bold text-slate-900">{{ $med->name }}</div>
                            <div class="text-xs text-slate-500 mt-0.5">{{ $med->category->name ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-black text-2xl {{ $med->stock <= 0 ? 'text-red-600' : 'text-orange-600' }}">
                                {{ $med->stock }}
                            </div>
                            <div class="text-xs font-semibold text-slate-400 mt-1 uppercase">{{ $med->unit->name }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-bold text-slate-700">{{ $med->min_stock }} <span class="font-medium text-slate-400">{{ $med->unit->name }}</span></div>
                            <div class="text-xs text-slate-500 mt-0.5">Defisit: {{ max(0, $med->min_stock - $med->stock) }} {{ $med->unit->name }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-slate-700 font-medium">{{ $med->supplier->name ?? '-' }}</div>
                            @if($med->supplier && $med->supplier->phone)
                                <div class="text-xs text-slate-500 mt-0.5">{{ $med->supplier->phone }}</div>
                            @endif
                        </td>
                        <td class="px-4 py-4 text-right">
                            <a href="{{ route('superadmin.medicines.edit', $med->id) }}" class="inline-flex items-center gap-2 px-4 py-2 text-xs font-bold text-brand-blue bg-blue-50 hover:bg-blue-100 rounded-xl transition-all border border-blue-100">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                                Restock / Edit Stok
                            </a>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-16 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <span class="font-bold text-slate-700 text-lg">Gudang Aman!</span>
                                <span class="text-sm mt-1">Tidak ada obat yang menipis atau kosong sama sekali.</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $medicines->links() }}
        </div>
    </div>
</x-superadmin-layout>
