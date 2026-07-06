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