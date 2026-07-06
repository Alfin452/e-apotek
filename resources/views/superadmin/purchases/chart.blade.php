<x-superadmin-layout>
    <!-- Include Flatpickr CSS/JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Grafik Pembelian</h1>
            <p class="text-slate-500 mt-1">Pantau performa pendapatan apotek setiap bulannya.</p>
        </div>
        
        <form method="GET" action="{{ route('superadmin.purchases.chart') }}" id="yearForm" class="flex items-center gap-3">
            <label for="year" class="text-sm font-bold text-slate-600">Pilih Tahun:</label>
            <div class="relative">
                <input type="text" name="year" id="year" value="{{ $year }}" class="px-4 py-2.5 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue text-sm font-black text-brand-blue shadow-sm cursor-pointer transition-all hover:bg-slate-50 w-32 text-center" placeholder="Tahun" readonly>
            </div>
        </form>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 md:p-8">
        <h3 class="text-lg font-bold text-slate-800 mb-6 border-b border-slate-100 pb-4">Statistik Pembelian Tahun {{ $year }}</h3>
        
        <!-- Total Header Summary (Optional) -->
        <div class="mb-6 flex gap-4">
            <div class="px-6 py-4 bg-brand-blue/5 rounded-2xl border border-brand-blue/10">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-1">Total Pendapatan {{ $year }}</p>
                <p class="text-2xl font-black text-brand-blue">Rp {{ number_format(array_sum($chartData), 0, ',', '.') }}</p>
            </div>
        </div>

        <div class="relative h-96 w-full mb-8">
            <canvas id="salesChart"></canvas>
        </div>

        <!-- Statistik Bawah -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 pt-6 border-t border-slate-100">
            <div class="p-5 rounded-2xl bg-brand-blue/5 border border-brand-blue/10 hover:shadow-md transition-shadow">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pembelian Terbanyak</p>
                <p class="text-2xl font-black text-slate-800">{{ $stats['highest_sales']['value'] }} <span class="text-sm font-medium text-slate-500">trx</span></p>
                <p class="text-sm text-brand-blue font-bold mt-1">Bulan {{ $stats['highest_sales']['month'] }}</p>
            </div>
            
            <div class="p-5 rounded-2xl bg-red-50 border border-red-100 hover:shadow-md transition-shadow">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pembelian Tersedikit</p>
                <p class="text-2xl font-black text-slate-800">{{ $stats['lowest_sales']['value'] }} <span class="text-sm font-medium text-slate-500">trx</span></p>
                <p class="text-sm text-red-600 font-bold mt-1">Bulan {{ $stats['lowest_sales']['month'] }}</p>
            </div>

            <div class="p-5 rounded-2xl bg-emerald-50 border border-emerald-100 hover:shadow-md transition-shadow">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pendapatan Tertinggi</p>
                <p class="text-2xl font-black text-slate-800">Rp {{ number_format($stats['highest_revenue']['value'], 0, ',', '.') }}</p>
                <p class="text-sm text-emerald-600 font-bold mt-1">Bulan {{ $stats['highest_revenue']['month'] }}</p>
            </div>

            <div class="p-5 rounded-2xl bg-orange-50 border border-orange-100 hover:shadow-md transition-shadow">
                <p class="text-xs font-bold text-slate-500 uppercase tracking-wider mb-2">Pendapatan Terendah</p>
                <p class="text-2xl font-black text-slate-800">Rp {{ number_format($stats['lowest_revenue']['value'], 0, ',', '.') }}</p>
                <p class="text-sm text-orange-600 font-bold mt-1">Bulan {{ $stats['lowest_revenue']['month'] }}</p>
            </div>
        </div>

        <!-- Top Medicines -->
        <div class="mt-8 pt-6 border-t border-slate-100">
            <h4 class="text-lg font-bold text-slate-800 mb-4">5 Obat Paling Laris (Tahun {{ $year }})</h4>
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm overflow-hidden">
                <table class="w-full text-left border-collapse">
                    <thead>
                        <tr class="bg-slate-50 border-b border-slate-100 text-xs font-bold text-slate-500 uppercase tracking-wider">
                            <th class="px-6 py-4">Peringkat</th>
                            <th class="px-6 py-4">Nama Obat</th>
                            <th class="px-6 py-4 text-right">Total Terjual</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100">
                        @forelse($topMedicines as $index => $med)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="px-6 py-3.5 text-sm font-bold text-slate-400">#{{ $index + 1 }}</td>
                                <td class="px-6 py-3.5 text-sm font-bold text-slate-800">{{ $med->name }}</td>
                                <td class="px-6 py-3.5 text-sm font-black text-brand-blue text-right">{{ $med->total_qty }} <span class="text-xs text-slate-400 font-medium">unit</span></td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="px-6 py-8 text-center text-slate-500 text-sm font-medium">Belum ada data pemasokan obat di tahun ini.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Chart.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('salesChart').getContext('2d');
            
            // Format Rupiah
            const formatRupiah = (number) => {
                return new Intl.NumberFormat('id-ID', {
                    style: 'currency',
                    currency: 'IDR',
                    minimumFractionDigits: 0
                }).format(number);
            };

            const data = @json(array_values($chartData));
            
            // Gradient Background for Line Chart
            let gradient = ctx.createLinearGradient(0, 0, 0, 400);
            gradient.addColorStop(0, 'rgba(30, 66, 159, 0.4)'); // brand-blue semi-transparent
            gradient.addColorStop(1, 'rgba(30, 66, 159, 0.0)'); // transparent
            
            new Chart(ctx, {
                type: 'line',
                data: {
                    labels: ['Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni', 'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'],
                    datasets: [{
                        label: 'Total Pembelian (Rp)',
                        data: data,
                        backgroundColor: gradient,
                        borderColor: '#1e429f',
                        borderWidth: 3,
                        pointBackgroundColor: '#ffffff',
                        pointBorderColor: '#1e429f',
                        pointBorderWidth: 2,
                        pointRadius: 4,
                        pointHoverRadius: 6,
                        pointHoverBackgroundColor: '#fbfc09', // brand-yellow
                        pointHoverBorderColor: '#1e429f',
                        fill: true,
                        tension: 0.4 // Makes the line curved and smooth
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: {
                            display: false
                        },
                        tooltip: {
                            backgroundColor: '#0f172a',
                            titleFont: { size: 14, family: 'system-ui' },
                            bodyFont: { size: 15, weight: 'bold', family: 'system-ui' },
                            padding: 16,
                            cornerRadius: 12,
                            displayColors: false,
                            callbacks: {
                                title: function(context) {
                                    return context[0].label + ' {{ $year }}';
                                },
                                label: function(context) {
                                    return formatRupiah(context.raw);
                                }
                            }
                        }
                    },
                    scales: {
                        y: {
                            beginAtZero: true,
                            grid: {
                                color: '#f1f5f9',
                                drawBorder: false,
                                borderDash: [5, 5]
                            },
                            ticks: {
                                font: { size: 12, weight: '600' },
                                color: '#64748b',
                                padding: 10,
                                callback: function(value) {
                                    if (value >= 1000000) {
                                        return 'Rp ' + (value / 1000000) + ' Jt';
                                    }
                                    if (value >= 1000) {
                                        return 'Rp ' + (value / 1000) + ' Rb';
                                    }
                                    return 'Rp ' + value;
                                }
                            }
                        },
                        x: {
                            grid: {
                                display: false,
                                drawBorder: false,
                            },
                            ticks: {
                                font: { size: 12, weight: 'bold' },
                                color: '#475569',
                                padding: 10
                            }
                        }
                    },
                    animation: {
                        y: {
                            duration: 1500,
                            easing: 'easeOutQuart'
                        }
                    }
                }
            });

            // Initialize Flatpickr for Year selection
            flatpickr("#year", {
                locale: "id",
                dateFormat: "Y",
                defaultDate: "{{ $year }}",
                onChange: function(selectedDates, dateStr, instance) {
                    document.getElementById('yearForm').submit();
                }
            });
        });
    </script>
</x-superadmin-layout>
