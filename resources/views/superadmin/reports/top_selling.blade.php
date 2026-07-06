<x-superadmin-layout>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Obat Terlaris (Kuantitas)</h1>
            <p class="text-slate-500 mt-1 font-medium">Daftar obat yang paling sering terjual secara kuantitas.</p>
        </div>
        <div>
            <a href="{{ route('superadmin.reports.top_selling', ['export' => 'pdf']) }}" target="_blank" class="inline-flex items-center gap-2 bg-brand-blue hover:bg-slate-800 text-white font-bold py-2.5 px-6 rounded-xl transition-colors shadow-sm text-sm">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak PDF
            </a>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm mb-6 flex justify-center">
        <div style="width: 100%; max-width: 800px; height: 300px;">
            <canvas id="reportChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
        <div class="overflow-x-auto">
            <table class="w-full text-sm text-left">
                <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100 font-bold">
                    <tr>
                        <th class="px-6 py-4 text-center">Nama Obat</th><th class="px-6 py-4 text-center">Total Qty Terjual</th><th class="px-6 py-4 text-center">Total Pendapatan (Rp)</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($tableData as $row)
                    <tr class="hover:bg-slate-50/50 transition-colors">
                        <td class="px-6 py-4 font-bold text-slate-900">{{ $row->name }}</td><td class="px-6 py-4 text-center font-bold text-red-600">{{ $row->total_qty }}</td><td class="px-6 py-4 text-right">{{ number_format($row->total_revenue, 0, ',', '.') }}</td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-8 text-center text-slate-500 font-medium">Belum ada data.</td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('reportChart').getContext('2d');
            const labels = {!! json_encode($labels ?? []) !!};
            
            // Try to find the correct data variable from the controller
            let chartData = [];
            if (typeof {!! json_encode($salesData ?? null) !!} !== 'undefined' && {!! json_encode($salesData ?? null) !!} !== null) chartData = {!! json_encode($salesData ?? []) !!};
            else if (typeof {!! json_encode($revenueData ?? null) !!} !== 'undefined' && {!! json_encode($revenueData ?? null) !!} !== null) chartData = {!! json_encode($revenueData ?? []) !!};
            else if (typeof {!! json_encode($spendingData ?? null) !!} !== 'undefined' && {!! json_encode($spendingData ?? null) !!} !== null) chartData = {!! json_encode($spendingData ?? []) !!};
            else if (typeof {!! json_encode($qtyData ?? null) !!} !== 'undefined' && {!! json_encode($qtyData ?? null) !!} !== null) chartData = {!! json_encode($qtyData ?? []) !!};

            let bgColors = '#ef4444';
            if ('bar' === 'pie' || 'bar' === 'doughnut') {
                bgColors = [
                    '#3b82f6', '#10b981', '#f59e0b', '#ef4444', '#8b5cf6', 
                    '#ec4899', '#06b6d4', '#14b8a6', '#f43f5e', '#6366f1'
                ];
            }

            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: labels,
                    datasets: [{
                        label: 'Qty Terjual',
                        data: chartData,
                        backgroundColor: bgColors,
                        borderRadius: ('bar' === 'bar') ? 6 : 0,
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        });
    </script>
</x-superadmin-layout>