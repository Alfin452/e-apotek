<x-superadmin-layout>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Laporan Laba/Rugi Bersih</h1>
            <p class="text-slate-500 mt-1 font-medium">Analisis profitabilitas murni dari transaksi penjualan bulanan (Pendapatan vs HPP).</p>
        </div>
        <div>
            <a href="{{ route('superadmin.reports.profit', ['export' => 'pdf']) }}" target="_blank" class="inline-flex items-center gap-2 bg-brand-blue hover:bg-slate-800 text-white font-bold py-2.5 px-6 rounded-xl transition-colors shadow-sm text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak PDF
            </a>
        </div>
    </div>

    @php
        $totalRev = collect($tableData)->sum('revenue');
        $totalCogs = collect($tableData)->sum('cogs');
        $totalProfit = collect($tableData)->sum('profit');
        $avgMargin = $totalRev > 0 ? ($totalProfit / $totalRev) * 100 : 0;
    @endphp

    <!-- Metric Summary Cards -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Pendapatan (6 Bln)</p>
            <h4 class="text-2xl font-black text-slate-900">Rp {{ number_format($totalRev, 0, ',', '.') }}</h4>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total HPP (Modal)</p>
            <h4 class="text-2xl font-black text-slate-700">Rp {{ number_format($totalCogs, 0, ',', '.') }}</h4>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Laba Bersih</p>
            <h4 class="text-2xl font-black {{ $totalProfit >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                {{ $totalProfit >= 0 ? '+' : '' }}Rp {{ number_format($totalProfit, 0, ',', '.') }}
            </h4>
        </div>
        <div class="bg-white p-5 rounded-2xl border border-slate-100 shadow-sm">
            <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Rata-rata Margin Laba</p>
            <h4 class="text-2xl font-black {{ $avgMargin >= 0 ? 'text-brand-blue' : 'text-rose-600' }}">
                {{ $avgMargin >= 0 ? '+' : '' }}{{ number_format($avgMargin, 1) }}%
            </h4>
        </div>
    </div>

    <!-- Chart Section -->
    <div class="bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm mb-6">
        <h3 class="text-lg font-bold text-slate-900 mb-4">Grafik Tren Pendapatan & Laba Bersih</h3>
        <canvas id="profitChart" height="100"></canvas>
    </div>

    <!-- Table Section -->
    <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
        <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-2">
            <h3 class="text-lg font-bold text-slate-900">Rincian Performa Laba/Rugi Bulanan</h3>
            <span class="text-xs text-slate-400 font-medium">Rumus: Margin = (Laba ÷ Pendapatan) × 100%</span>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100 font-bold">
                    <tr>
                        <th class="px-6 py-4">Bulan</th>
                        <th class="px-6 py-4 text-right">Total Pendapatan (Rp)</th>
                        <th class="px-6 py-4 text-right">Total HPP (Rp)</th>
                        <th class="px-6 py-4 text-right">Laba/Rugi Bersih (Rp)</th>
                        <th class="px-6 py-4 text-right">Margin Laba (%)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tableData as $row)
                    @php
                        $rowMargin = $row['revenue'] > 0 ? ($row['profit'] / $row['revenue']) * 100 : 0;
                    @endphp
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $row['month_name'] }}</td>
                        <td class="px-6 py-4 font-medium text-slate-700 text-right">Rp {{ number_format($row['revenue'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-medium text-slate-700 text-right">Rp {{ number_format($row['cogs'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-bold text-right {{ $row['profit'] >= 0 ? 'text-emerald-600' : 'text-rose-600' }}">
                            {{ $row['profit'] >= 0 ? '+' : '' }}Rp {{ number_format($row['profit'], 0, ',', '.') }}
                        </td>
                        <td class="px-6 py-4 font-bold text-right">
                            @if($row['revenue'] > 0)
                                @if($rowMargin > 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-emerald-50 text-emerald-700 border border-emerald-100">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-emerald-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18"/></svg>
                                        +{{ number_format($rowMargin, 1) }}%
                                    </span>
                                @elseif($rowMargin < 0)
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg text-xs font-bold bg-rose-50 text-rose-700 border border-rose-100" title="Defisit / Rugi">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 text-rose-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 14l-7 7m0 0l-7-7m7 7V3"/></svg>
                                        {{ number_format($rowMargin, 1) }}% <span class="text-[10px] uppercase tracking-wider font-extrabold text-rose-600">(Rugi)</span>
                                    </span>
                                @else
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-lg text-xs font-semibold bg-slate-100 text-slate-600">
                                        0.0% (Impas)
                                    </span>
                                @endif
                            @else
                                <span class="text-slate-400 font-medium text-xs">0.0%</span>
                            @endif
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 font-medium">Belum ada data transaksi.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="px-6 py-4 bg-slate-50/50 border-t border-slate-100 flex items-center gap-2 text-xs text-slate-500">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
            <span><strong>Catatan:</strong> Margin Laba Bersih dihitung dari persentase keuntungan murni terhadap total pendapatan penjualan. Margin bernilai positif jika pendapatan melebihi HPP.</span>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('profitChart').getContext('2d');
            const labels = {!! json_encode($labels ?? []) !!};
            const revenueData = {!! json_encode($revenueData ?? []) !!};
            const profitData = {!! json_encode($profitData ?? []) !!};

            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Pendapatan',
                            data: revenueData,
                            borderColor: '#3b82f6', // blue-500
                            backgroundColor: 'rgba(59, 130, 246, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true
                        },
                        {
                            label: 'Laba Bersih',
                            data: profitData,
                            borderColor: '#10b981', // emerald-500
                            backgroundColor: 'rgba(16, 185, 129, 0.1)',
                            borderWidth: 2,
                            tension: 0.4,
                            fill: true
                        }
                    ]
                },
                options: {
                    responsive: true,
                    plugins: {
                        legend: { position: 'top' },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    let label = context.dataset.label || '';
                                    if (label) {
                                        label += ': ';
                                    }
                                    if (context.parsed.y !== null) {
                                        label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.parsed.y);
                                    }
                                    return label;
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: {
                                callback: function(value) {
                                    return 'Rp ' + (value/1000) + 'K';
                                }
                            }
                        }
                    }
                }
            });
        });
    </script>
</x-superadmin-layout>
