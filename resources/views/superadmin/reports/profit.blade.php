<x-superadmin-layout>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Laporan Laba/Rugi Bersih</h1>
            <p class="text-slate-500 mt-1 font-medium">Analisis profitabilitas murni dari transaksi penjualan bulanan.</p>
        </div>
        <div>
            <a href="{{ route('superadmin.reports.profit', ['export' => 'pdf']) }}" target="_blank" class="inline-flex items-center gap-2 bg-brand-blue hover:bg-slate-800 text-white font-bold py-2.5 px-6 rounded-xl transition-colors shadow-sm text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak PDF
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm mb-6">
        <canvas id="profitChart" height="100"></canvas>
    </div>

    <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100 font-bold">
                    <tr>
                        <th class="px-6 py-4">Bulan</th>
                        <th class="px-6 py-4 text-right">Total Pendapatan (Rp)</th>
                        <th class="px-6 py-4 text-right">Total HPP (Rp)</th>
                        <th class="px-6 py-4 text-right">Laba Bersih (Rp)</th>
                        <th class="px-6 py-4 text-right">Margin Laba (%)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tableData as $row)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $row['month_name'] }}</td>
                        <td class="px-6 py-4 font-medium text-slate-700 text-right">{{ number_format($row['revenue'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-medium text-slate-700 text-right">{{ number_format($row['cogs'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-bold text-emerald-600 text-right">{{ number_format($row['profit'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-bold text-slate-700 text-right">
                            @if($row['revenue'] > 0)
                                {{ number_format(($row['profit'] / $row['revenue']) * 100, 1) }}%
                            @else
                                0%
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
