<x-superadmin-layout>
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Risiko Kadaluarsa</h1>
            <p class="text-slate-500 mt-1 font-medium">Prediksi potensi kerugian jika obat kadaluarsa tidak laku.</p>
        </div>
        <div>
            <a href="{{ route('superadmin.reports.expired_risk', ['export' => 'pdf']) }}" target="_blank" class="inline-flex items-center gap-2 bg-brand-blue hover:bg-slate-800 text-white font-bold py-2.5 px-6 rounded-xl transition-colors shadow-sm text-sm">
                Cetak PDF
            </a>
        </div>
    </div>
    
    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-6">
        <div class="bg-red-50 rounded-3xl p-6 border border-red-100 text-center">
            <h3 class="text-red-800 font-bold mb-2">Nilai Kerugian Kritis (< 30 Hari)</h3>
            <p class="text-3xl font-black text-red-600">Rp {{ number_format($tableData['criticalValue'], 0, ',', '.') }}</p>
        </div>
        <div class="bg-orange-50 rounded-3xl p-6 border border-orange-100 text-center">
            <h3 class="text-orange-800 font-bold mb-2">Nilai Kerugian Waspada (< 60 Hari)</h3>
            <p class="text-3xl font-black text-orange-600">Rp {{ number_format($tableData['warningValue'], 0, ',', '.') }}</p>
        </div>
    </div>

    <div class="bg-white rounded-3xl p-6 lg:p-8 border border-slate-100 shadow-sm mb-6 flex justify-center">
        <canvas id="riskChart" height="100"></canvas>
    </div>

    <!-- Detail Obat Kritis -->
    @if(count($tableData['critical']) > 0)
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-slate-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-red-100 flex items-center justify-center text-red-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Detail Obat Kritis (&lt; 30 Hari)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/50 text-slate-500 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3">Nama Obat</th>
                        <th class="px-6 py-3">Tgl Kadaluarsa</th>
                        <th class="px-6 py-3">Sisa Stok</th>
                        <th class="px-6 py-3 text-right">Potensi Kerugian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($tableData['critical'] as $med)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3 font-bold text-slate-700">{{ $med->name }}</td>
                        <td class="px-6 py-3 text-red-600 font-medium">{{ \Carbon\Carbon::parse($med->expired_date)->format('d-m-Y') }}</td>
                        <td class="px-6 py-3">{{ $med->stock }}</td>
                        <td class="px-6 py-3 text-right font-medium">Rp {{ number_format($med->stock * $med->purchase_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <!-- Detail Obat Waspada -->
    @if(count($tableData['warning']) > 0)
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 overflow-hidden mb-6">
        <div class="p-6 border-b border-slate-100 flex items-center gap-3">
            <div class="w-8 h-8 rounded-full bg-orange-100 flex items-center justify-center text-orange-600">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            </div>
            <h3 class="text-lg font-bold text-slate-800">Detail Obat Waspada (&lt; 60 Hari)</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/50 text-slate-500 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-6 py-3">Nama Obat</th>
                        <th class="px-6 py-3">Tgl Kadaluarsa</th>
                        <th class="px-6 py-3">Sisa Stok</th>
                        <th class="px-6 py-3 text-right">Potensi Kerugian</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @foreach($tableData['warning'] as $med)
                    <tr class="hover:bg-slate-50">
                        <td class="px-6 py-3 font-bold text-slate-700">{{ $med->name }}</td>
                        <td class="px-6 py-3 text-orange-600 font-medium">{{ \Carbon\Carbon::parse($med->expired_date)->format('d-m-Y') }}</td>
                        <td class="px-6 py-3">{{ $med->stock }}</td>
                        <td class="px-6 py-3 text-right font-medium">Rp {{ number_format($med->stock * $med->purchase_price, 0, ',', '.') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('riskChart').getContext('2d');
        new Chart(ctx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($labels) !!},
                datasets: [{ label: 'Nilai Kerugian (Rp)', data: {!! json_encode($riskData) !!}, backgroundColor: ['#ef4444', '#f97316'] }]
            }
        });
    </script>
</x-superadmin-layout>