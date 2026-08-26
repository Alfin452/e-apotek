<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Laporan Laba/Rugi Bersih</title>
    <style>
        body { font-family: sans-serif; font-size: 11px; color: #333; }
        .header { text-align: center; margin-bottom: 15px; border-bottom: 2px solid #2563eb; padding-bottom: 8px; }
        .title { font-size: 16px; font-weight: bold; margin: 0; color: #1e3a8a; }
        .subtitle { font-size: 11px; color: #64748b; margin: 3px 0 0 0; }
        
        .section-title { font-size: 12px; font-weight: bold; margin: 15px 0 6px 0; padding-left: 5px; border-left: 3px solid #2563eb; }
        
        table { width: 100%; border-collapse: collapse; margin-top: 5px; margin-bottom: 15px; }
        th, td { border: 1px solid #cbd5e1; padding: 7px 9px; font-size: 10px; }
        th { background-color: #f8fafc; font-weight: bold; text-align: center; color: #475569; }
        
        .text-left { text-align: left; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .font-bold { font-weight: bold; }
        
        .profit { color: #16a34a; font-weight: bold; }
        .loss { color: #dc2626; font-weight: bold; }
        
        .summary-box { width: 100%; margin-bottom: 15px; }
        .summary-box td { border: 1px solid #e2e8f0; padding: 6px 10px; }
        
        .footer { margin-top: 25px; text-align: right; font-size: 9px; color: #94a3b8; }
    </style>
</head>
<body>
    <div class="header">
        <h1 class="title">LAPORAN LABA/RUGI BERSIH</h1>
        <p class="subtitle">Apotek E-Apotek | Periode 6 Bulan Terakhir</p>
        <p class="subtitle">Dicetak pada: {{ now()->translatedFormat('d F Y H:i') }}</p>
    </div>

    @php
        $totalRev = collect($tableData)->sum('revenue');
        $totalCogs = collect($tableData)->sum('cogs');
        $totalProfit = collect($tableData)->sum('profit');
        $avgMargin = $totalRev > 0 ? ($totalProfit / $totalRev) * 100 : 0;
    @endphp

    <!-- Ringkasan Finansial -->
    <div class="section-title">Ringkasan Finansial (6 Bulan)</div>
    <table class="summary-box">
        <thead>
            <tr>
                <th class="text-left">Total Pendapatan (Rp)</th>
                <th class="text-left">Total HPP / Modal (Rp)</th>
                <th class="text-left">Total Laba Bersih (Rp)</th>
                <th class="text-center">Rata-rata Margin</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td class="text-left font-bold">Rp {{ number_format($totalRev, 0, ',', '.') }}</td>
                <td class="text-left font-bold">Rp {{ number_format($totalCogs, 0, ',', '.') }}</td>
                <td class="text-left {{ $totalProfit >= 0 ? 'profit' : 'loss' }}">
                    {{ $totalProfit >= 0 ? '+' : '' }}Rp {{ number_format($totalProfit, 0, ',', '.') }}
                </td>
                <td class="text-center {{ $avgMargin >= 0 ? 'profit' : 'loss' }}">
                    {{ $avgMargin >= 0 ? '+' : '' }}{{ number_format($avgMargin, 1) }}%
                </td>
            </tr>
        </tbody>
    </table>

    <!-- Rincian Bulanan -->
    <div class="section-title">Rincian Laba/Rugi per Bulan</div>
    <table>
        <thead>
            <tr>
                <th style="width: 5%;">No</th>
                <th class="text-left" style="width: 25%;">Bulan</th>
                <th class="text-right" style="width: 20%;">Total Pendapatan (Rp)</th>
                <th class="text-right" style="width: 20%;">Total HPP (Rp)</th>
                <th class="text-right" style="width: 18%;">Laba/Rugi Bersih (Rp)</th>
                <th class="text-right" style="width: 12%;">Margin Laba (%)</th>
            </tr>
        </thead>
        <tbody>
            @forelse($tableData as $index => $row)
            @php
                $rowMargin = $row['revenue'] > 0 ? ($row['profit'] / $row['revenue']) * 100 : 0;
            @endphp
            <tr>
                <td class="text-center">{{ $index + 1 }}</td>
                <td class="text-left font-bold">{{ $row['month_name'] }}</td>
                <td class="text-right">Rp {{ number_format($row['revenue'], 0, ',', '.') }}</td>
                <td class="text-right">Rp {{ number_format($row['cogs'], 0, ',', '.') }}</td>
                <td class="text-right {{ $row['profit'] >= 0 ? 'profit' : 'loss' }}">
                    {{ $row['profit'] >= 0 ? '+' : '' }}Rp {{ number_format($row['profit'], 0, ',', '.') }}
                </td>
                <td class="text-right {{ $rowMargin >= 0 ? 'profit' : 'loss' }}">
                    @if($row['revenue'] > 0)
                        {{ $rowMargin > 0 ? '+' : '' }}{{ number_format($rowMargin, 1) }}%{{ $rowMargin < 0 ? ' (Rugi)' : '' }}
                    @else
                        0.0%
                    @endif
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="text-center" style="padding: 10px; color: #64748b;">Belum ada data transaksi.</td>
            </tr>
            @endforelse
        </tbody>
    </table>

    <div style="font-size: 8px; color: #64748b; margin-top: -5px; margin-bottom: 15px;">
        * Margin Laba Bersih = (Laba Bersih ÷ Total Pendapatan) × 100%. Margin positif menunjukkan rasio keuntungan murni dari total penjualan.
    </div>

    <div class="footer">Dicetak otomatis oleh Sistem Informasi E-Apotek</div>
</body>
</html>
