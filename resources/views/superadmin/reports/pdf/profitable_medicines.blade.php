<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Obat Paling Menguntungkan</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; color: #333; }
        .header { text-align: center; margin-bottom: 20px; border-bottom: 2px solid #2563eb; padding-bottom: 10px; }
        .title { font-size: 18px; font-weight: bold; margin: 0; color: #1e3a8a; }
        .subtitle { font-size: 12px; color: #64748b; margin: 5px 0 0 0; }
        table { width: 100%; border-collapse: collapse; margin-top: 15px; }
        th, td { border: 1px solid #cbd5e1; padding: 8px 10px; text-align: right; }
        th { background-color: #f8fafc; font-weight: bold; text-align: center; color: #475569; }
        td.text-left { text-align: left; }
        td.text-center { text-align: center; }
        .profit { color: #16a34a; font-weight: bold; }
        .footer { margin-top: 30px; text-align: right; font-size: 10px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">LAPORAN OBAT PALING MENGUNTUNGKAN</h1>
        <p class="subtitle">Apotek E-Apotek | Semua Waktu</p>
        <p class="subtitle">Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Peringkat</th>
                <th>Nama Obat</th>
                <th>Qty Terjual</th>
                <th>Total Pendapatan (Rp)</th>
                <th>Total Laba Bersih (Rp)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tableData as $index => $row)
            <tr>
                <td class="text-center">#{{ $index + 1 }}</td>
                <td class="text-left"><strong>{{ $row['name'] }}</strong></td>
                <td class="text-center">{{ $row['qty'] }}</td>
                <td>{{ number_format($row['revenue'], 0, ',', '.') }}</td>
                <td class="profit">{{ number_format($row['profit'], 0, ',', '.') }}</td>
            </tr>
            @empty
            <tr>
                <td colspan="5" style="text-align: center;">Belum ada data transaksi penjualan.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        Dicetak oleh Sistem Informasi E-Apotek
    </div>
</body>
</html>
