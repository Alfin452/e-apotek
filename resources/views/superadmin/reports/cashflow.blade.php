<x-superadmin-layout>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Arus Kas Keluar vs Masuk</h1>
            <p class="text-slate-500 mt-1 font-medium">Perbandingan pendapatan dan pengeluaran 6 bulan terakhir.</p>
        </div>
        <div>
            <a href="{{ route('superadmin.reports.cashflow', ['export' => 'pdf']) }}" target="_blank" class="inline-flex items-center gap-2 bg-brand-blue hover:bg-slate-800 text-white font-bold py-2.5 px-6 rounded-xl transition-colors shadow-sm text-sm">
                Cetak PDF
            </a>
        </div>
    </div>
    <div class="bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm mb-6">
        <canvas id="cashflowChart" height="100"></canvas>
    </div>
    <div class="bg-white rounded-3xl overflow-hidden border border-slate-100 shadow-sm">
        <table class="w-full text-sm text-left">
            <thead class="text-xs text-slate-500 uppercase bg-slate-50 border-b border-slate-100 font-bold">
                <tr><th>Bulan</th><th class="text-right">Masuk (Penjualan)</th><th class="text-right">Keluar (Pembelian)</th><th class="text-right">Selisih Bersih (Rp)</th></tr>
            </thead>
            <tbody class="divide-y divide-slate-100">
                @foreach($tableData as $row)
                <tr>
                    <td class="px-6 py-4 font-bold">{{ $row['month_name'] }}</td>
                    <td class="px-6 py-4 text-right text-emerald-600 font-bold">+ {{ number_format($row['sales'], 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right text-red-600 font-bold">- {{ number_format($row['purchases'], 0, ',', '.') }}</td>
                    <td class="px-6 py-4 text-right font-black {{ $row['net'] >= 0 ? 'text-brand-blue' : 'text-red-600' }}">{{ number_format($row['net'], 0, ',', '.') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('cashflowChart').getContext('2d');
        new Chart(ctx, {
            type: 'line',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [
                    { label: 'Uang Masuk (Penjualan)', data: {!! json_encode($salesData) !!}, borderColor: '#10b981', tension: 0.3 },
                    { label: 'Uang Keluar (Pembelian)', data: {!! json_encode($purchasesData) !!}, borderColor: '#ef4444', tension: 0.3 }
                ]
            }
        });
    </script>
</x-superadmin-layout>