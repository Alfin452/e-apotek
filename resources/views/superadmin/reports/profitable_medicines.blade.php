<x-superadmin-layout>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Obat Paling Menguntungkan</h1>
            <p class="text-slate-500 mt-1 font-medium">Analisis daftar obat yang memberikan margin keuntungan terbesar bagi apotek.</p>
        </div>
        <div>
            <a href="{{ route('superadmin.reports.profitable_medicines', ['export' => 'pdf']) }}" target="_blank" class="inline-flex items-center gap-2 bg-brand-blue hover:bg-slate-800 text-white font-bold py-2.5 px-6 rounded-xl transition-colors shadow-sm text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak PDF
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <div class="lg:col-span-2 bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm flex flex-col">
            <h3 class="text-lg font-bold text-slate-900 mb-4">Top 10 Obat Paling Untung</h3>
            <div class="flex-1 min-h-[300px]">
                <canvas id="profitChart"></canvas>
            </div>
        </div>
        
        <div class="bg-brand-blue rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm text-white flex flex-col justify-center relative overflow-hidden">
            <div class="absolute -right-10 -top-10 opacity-10">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-64 w-64" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6" /></svg>
            </div>
            <div class="relative z-10">
                <p class="text-blue-100 font-medium uppercase tracking-wider mb-2 text-sm">Juara Profit 1</p>
                <h3 class="text-3xl font-black mb-4">{{ count($tableData) > 0 ? $tableData[0]['name'] : '-' }}</h3>
                <p class="text-white text-lg font-bold">
                    Rp {{ count($tableData) > 0 ? number_format($tableData[0]['profit'], 0, ',', '.') : '0' }}
                </p>
                <p class="text-blue-100 text-sm mt-1">Total Laba Bersih Keseluruhan</p>
            </div>
        </div>
    </div>

    <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100 font-bold">
                    <tr>
                        <th class="px-6 py-4">Peringkat</th>
                        <th class="px-6 py-4">Nama Obat</th>
                        <th class="px-6 py-4 text-center">Qty Terjual</th>
                        <th class="px-6 py-4 text-right">Total Pendapatan (Rp)</th>
                        <th class="px-6 py-4 text-right">Total Laba Bersih (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tableData as $index => $row)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-500">#{{ $index + 1 }}</td>
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $row['name'] }}</td>
                        <td class="px-6 py-4 font-medium text-slate-700 text-center">{{ $row['qty'] }}</td>
                        <td class="px-6 py-4 font-medium text-slate-700 text-right">{{ number_format($row['revenue'], 0, ',', '.') }}</td>
                        <td class="px-6 py-4 font-bold text-emerald-600 text-right">{{ number_format($row['profit'], 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 font-medium">Belum ada data transaksi penjualan.</td>
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
            const profitData = {!! json_encode($profitData ?? []) !!};

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [
                        {
                            label: 'Laba Bersih',
                            data: profitData,
                            backgroundColor: '#3b82f6', // blue-500
                            borderRadius: 6,
                        }
                    ]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    indexAxis: 'y',
                    plugins: {
                        legend: { display: false },
                        tooltip: {
                            callbacks: {
                                label: function(context) {
                                    return 'Rp ' + new Intl.NumberFormat('id-ID').format(context.parsed.x);
                                }
                            }
                        }
                    },
                    scales: {
                        x: {
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
