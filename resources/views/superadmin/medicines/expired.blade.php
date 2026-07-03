<x-superadmin-layout>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Pusat Peringatan Kadaluarsa</h1>
            <p class="text-slate-500 mt-1">Pantau obat yang mendekati atau sudah melewati batas waktu kelayakan (Max 6 Bulan).</p>
        </div>
    </div>



    <!-- Metric Cards -->
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        <!-- Expired Card -->
        <div class="bg-red-50/50 rounded-3xl p-6 border border-red-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-red-100 rounded-full opacity-50 blur-xl"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-red-600/80 uppercase tracking-wider mb-1">Sudah Kadaluarsa</p>
                    <h3 class="text-4xl font-black text-red-700">{{ $countAlreadyExpired }}</h3>
                    <p class="text-xs font-medium text-red-500 mt-2">Segera musnahkan obat ini.</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-red-100 text-red-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                </div>
            </div>
        </div>

        <!-- Critical Card -->
        <div class="bg-orange-50/50 rounded-3xl p-6 border border-orange-100 shadow-sm relative overflow-hidden">
            <div class="absolute -right-4 -top-4 w-24 h-24 bg-orange-100 rounded-full opacity-50 blur-xl"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-orange-600/80 uppercase tracking-wider mb-1">Kritis (< 3 Bulan)</p>
                    <h3 class="text-4xl font-black text-orange-600">{{ $countCritical }}</h3>
                    <p class="text-xs font-medium text-orange-500 mt-2">Prioritaskan penjualan segera.</p>
                </div>
                <div class="w-14 h-14 rounded-2xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
        </div>

        <!-- Potential Loss Card -->
        <div class="bg-slate-900 rounded-3xl p-6 shadow-xl relative overflow-hidden">
            <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+CjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0ibm9uZSI+PC9yZWN0Pgo8Y2lyY2xlIGN4PSIyIiBjeT0iMiIgcj0iMSIgZmlsbD0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjAzKSI+PC9jaXJjbGU+Cjwvc3ZnPg==')] z-0"></div>
            <div class="absolute -right-4 -top-4 w-32 h-32 bg-red-500/20 rounded-full blur-2xl z-0"></div>
            <div class="relative z-10 flex items-center justify-between">
                <div>
                    <p class="text-sm font-semibold text-slate-400 uppercase tracking-wider mb-1">Potensi Kerugian</p>
                    <h3 class="text-3xl font-black text-white">Rp {{ number_format($potentialLoss, 0, ',', '.') }}</h3>
                    <p class="text-xs font-medium text-slate-500 mt-2">Total modal obat yang sudah kadaluarsa.</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Bento Box -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 overflow-hidden">
        
        <!-- Filter & Legend -->
        <div class="flex flex-col md:flex-row gap-6 justify-between items-center mb-8 border-b border-slate-100 pb-6">
            <form action="{{ route('superadmin.medicines.expired') }}" method="GET" class="w-full md:w-1/3 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari obat kadaluarsa..." class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-red-200 focus:border-red-300 transition-all text-sm font-medium text-slate-800 placeholder-slate-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </form>

            <div class="flex flex-wrap gap-4 items-center bg-slate-50 px-5 py-3 rounded-2xl border border-slate-100">
                <span class="text-xs font-bold text-slate-400 uppercase tracking-widest mr-2">Indikator:</span>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-red-500 animate-pulse shadow-[0_0_8px_rgba(239,68,68,0.6)]"></span>
                    <span class="text-xs font-semibold text-slate-600">Sudah Lewat</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-orange-400 shadow-[0_0_8px_rgba(249,115,22,0.4)]"></span>
                    <span class="text-xs font-semibold text-slate-600">Kritis (< 3 Bln)</span>
                </div>
                <div class="flex items-center gap-2">
                    <span class="w-3 h-3 rounded-full bg-yellow-400"></span>
                    <span class="text-xs font-semibold text-slate-600">Waspada (< 6 Bln)</span>
                </div>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/50 text-slate-500 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-4 rounded-tl-xl">Status</th>
                        <th class="px-4 py-4">Nama Obat</th>
                        <th class="px-4 py-4">Tanggal Exp.</th>
                        <th class="px-4 py-4">Stok Sisa</th>
                        <th class="px-4 py-4">Pemasok</th>
                        <th class="px-4 py-4 text-right rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($medicines as $med)
                        @php
                            $daysLeft = (int) round(now()->startOfDay()->diffInDays(\Carbon\Carbon::parse($med->expired_date)->startOfDay(), false)); // negative if past
                            
                            $statusColor = 'bg-yellow-400';
                            $statusText = 'text-yellow-700';
                            $statusBg = 'bg-yellow-50';
                            $statusIcon = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>';
                            $statusLabel = 'Waspada';

                            if ($daysLeft < 0) {
                                $statusColor = 'bg-red-500 shadow-[0_0_8px_rgba(239,68,68,0.6)] animate-pulse';
                                $statusText = 'text-red-700';
                                $statusBg = 'bg-red-50 border border-red-100';
                                $statusIcon = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                                $statusLabel = 'Kadaluarsa';
                            } elseif ($daysLeft <= 90) {
                                $statusColor = 'bg-orange-400 shadow-[0_0_8px_rgba(249,115,22,0.4)]';
                                $statusText = 'text-orange-700';
                                $statusBg = 'bg-orange-50 border border-orange-100';
                                $statusIcon = '<svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>';
                                $statusLabel = 'Kritis';
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
                            <div class="font-bold {{ $daysLeft < 0 ? 'text-red-600' : 'text-slate-700' }}">
                                {{ \Carbon\Carbon::parse($med->expired_date)->translatedFormat('d M Y') }}
                            </div>
                            <div class="text-xs mt-0.5 {{ $daysLeft < 0 ? 'text-red-500 font-semibold' : 'text-slate-500' }}">
                                @if($daysLeft < 0)
                                    Terlewat {{ abs($daysLeft) }} Hari
                                @else
                                    Sisa {{ $daysLeft }} Hari
                                @endif
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-bold text-slate-700">{{ $med->stock }} <span class="font-medium text-slate-400">{{ $med->unit->name }}</span></div>
                            <div class="text-xs text-slate-500 mt-0.5">Modal: Rp {{ number_format($med->purchase_price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="text-sm text-slate-700 font-medium">{{ $med->supplier->name ?? '-' }}</div>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <form action="{{ route('superadmin.medicines.destroy', $med->id) }}" method="POST" class="inline-block confirm-form" data-action="memusnahkan dan membuang obat {{ $med->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="px-4 py-2 text-xs font-bold text-red-600 bg-red-50 hover:bg-red-100 hover:text-red-700 rounded-xl transition-all shadow-sm border border-red-100 flex items-center gap-2">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        Buang (Musnahkan)
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-16 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-green-50 rounded-full flex items-center justify-center mb-4">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                                </div>
                                <span class="font-bold text-slate-700 text-lg">Aman Terkendali!</span>
                                <span class="text-sm mt-1">Tidak ada obat yang kadaluarsa dalam 6 bulan ke depan.</span>
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
