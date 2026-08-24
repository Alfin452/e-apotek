<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Risiko Kadaluarsa</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #2563eb; padding-bottom: 8px; }
        .title { font-size: 16px; font-weight: bold; margin: 0; color: #1e3a8a; }
        .subtitle { font-size: 11px; color: #64748b; margin: 3px 0 0 0; }
        
        .section-title { font-size: 12px; font-weight: bold; margin: 15px 0 6px 0; padding-left: 5px; border-left: 3px solid #2563eb; }
        .section-title.critical { color: #dc2626; border-left-color: #dc2626; }
        .section-title.warning { color: #ea580c; border-left-color: #ea580c; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 5px; margin-bottom: 15px; }
        th, td { border: 1px solid #cbd5e1; padding: 6px 8px; font-size: 10px; }
        th { background-color: #f8fafc; font-weight: bold; text-align: center; color: #475569; }
        
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        .text-danger { color: #dc2626; }
        .text-warning { color: #ea580c; }
        
        .summary-box { width: 100%; margin-bottom: 10px; }
        .summary-box td { border: 1px solid #e2e8f0; padding: 6px 10px; }
        
        .footer { margin-top: 25px; text-align: right; font-size: 9px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">LAPORAN: RISIKO KADALUARSA OBAT</h1>
        <p class="subtitle">Apotek E-Apotek | Sistem Pelaporan</p>
        <p class="subtitle">Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    <!-- Ringkasan Nilai Kerugian -->
    <div class="section-title">Ringkasan Potensi Kerugian</div>
    <table class="summary-box">
        <thead>
            <tr>
                <th class="text-left" style="width: 50%;">Tingkat Risiko</th>
                <th class="text-center" style="width: 20%;">Jumlah Obat</th>
                <th class="text-right" style="width: 30%;">Total Potensi Kerugian (Rp)</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-left font-bold text-danger">Kritis (&lt; 30 Hari)</td>
                <td class="text-center">{{ count($tableData['critical']) }} Obat</td>
                <td class="text-right font-bold text-danger">Rp {{ number_format($tableData['criticalValue'], 0, ',', '.') }}</td>
            </tr>
            <tr>
                <td class="text-left font-bold text-warning">Waspada (&lt; 60 Hari)</td>
                <td class="text-center">{{ count($tableData['warning']) }} Obat</td>
                <td class="text-right font-bold text-warning">Rp {{ number_format($tableData['warningValue'], 0, ',', '.') }}</td>
            </tr>
            <tr style="background-color: #f1f5f9;">
                <td class="text-left font-bold" colspan="2">TOTAL KESELURUHAN</td>
                <td class="text-right font-bold" style="color: #1e3a8a;">Rp {{ number_format($tableData['criticalValue'] + $tableData['warningValue'], 0, ',', '.') }}</td>
            </tr>
        </tbody>
    </table>

    <!-- Rincian Obat Kritis -->
    <div class="section-title critical">Rincian Obat Kritis (&lt; 30 Hari)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th class="text-left" style="width: 40%;">Nama Obat</th>
                <th style="width: 15%;">Tgl Kadaluarsa</th>
                <th style="width: 10%;">Sisa Stok</th>
                <th class="text-right" style="width: 15%;">Harga Beli (Rp)</th>
                <th class="text-right" style="width: 15%;">Potensi Kerugian (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tableData['critical'] as $index => $med)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-left font-bold">{{ $med->name }}</td>
                <td class="text-center text-danger font-bold">{{ \Carbon\Carbon::parse($med->expired_date)->format('d-m-Y') }}</td>
                <td class="text-center">{{ $med->stock }}</td>
                <td class="text-right">{{ number_format($med->purchase_price, 0, ',', '.') }}</td>
                <td class="text-right font-bold text-danger">Rp {{ number_format($med->stock * $med->purchase_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 10px; color: #64748b;">Tidak ada obat dalam kategori kritis (&lt; 30 hari).</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Rincian Obat Waspada -->
    <div class="section-title warning">Rincian Obat Waspada (&lt; 60 Hari)</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th class="text-left" style="width: 40%;">Nama Obat</th>
                <th style="width: 15%;">Tgl Kadaluarsa</th>
                <th style="width: 10%;">Sisa Stok</th>
                <th class="text-right" style="width: 15%;">Harga Beli (Rp)</th>
                <th class="text-right" style="width: 15%;">Potensi Kerugian (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tableData['warning'] as $index => $med)
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-left font-bold">{{ $med->name }}</td>
                <td class="text-center text-warning font-bold">{{ \Carbon\Carbon::parse($med->expired_date)->format('d-m-Y') }}</td>
                <td class="text-center">{{ $med->stock }}</td>
                <td class="text-right">{{ number_format($med->purchase_price, 0, ',', '.') }}</td>
                <td class="text-right font-bold text-warning">Rp {{ number_format($med->stock * $med->purchase_price, 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 10px; color: #64748b;">Tidak ada obat dalam kategori waspada (&lt; 60 hari).</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">Dicetak otomatis oleh Sistem Informasi E-Apotek</div>
</body>
</html>