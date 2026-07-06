<x-superadmin-layout>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Status Stok Obat</h1>
            <p class="text-slate-500 mt-1 font-medium">Analisis daftar obat yang membutuhkan restock segera.</p>
        </div>
        <div>
            <a href="{{ route('superadmin.reports.stock_status', ['export' => 'pdf']) }}" target="_blank" class="inline-flex items-center gap-2 bg-brand-blue hover:bg-slate-800 text-white font-bold py-2.5 px-6 rounded-xl transition-colors shadow-sm text-sm">
                Cetak PDF
            </a>
        </div>
    </div>
    
    <div class="bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm mb-6 flex justify-center">
        <div style="max-width: 400px; width:100%">
            <canvas id="stockChart"></canvas>
        </div>
    </div>

    <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100 font-bold">
                <tr><th>Nama Obat</th><th>Stok Saat Ini</th><th>Batas Minimum</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($criticalStocks as $row)
                <tr>
                    <td class="px-6 py-4 font-bold">{{ $row->name }}</td>
                    <td class="px-6 py-4 text-red-600 font-bold">{{ $row->stock }}</td>
                    <td class="px-6 py-4">{{ $row->min_stock }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('stockChart').getContext('2d');
        new Chart(ctx, {
            type: 'pie',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{ data: {!! json_encode($stockData) !!}, backgroundColor: ['#ef4444', '#10b981'] }]
            }
        });
    </script>
</x-superadmin-layout>