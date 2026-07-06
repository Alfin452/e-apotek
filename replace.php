<?php
$dir = 'c:\\laragon\\www\\e-apotek\\resources\\views\\superadmin\\purchases';
$files = ['index.blade.php', 'create.blade.php', 'chart.blade.php'];

$replacements = [
    'sale_date' => 'purchase_date',
    'sales.index' => 'purchases.index',
    'sales.create' => 'purchases.create',
    'sales.chart' => 'purchases.chart',
    'sales.destroy' => 'purchases.destroy',
    '$sales' => '$purchases',
    '$sale' => '$purchase',
    'sale->' => 'purchase->',
    'sales->' => 'purchases->',
    'Penjualan' => 'Pembelian',
    'penjualan' => 'pembelian',
    'customer_name' => 'supplier->name',
    'Nama Pembeli' => 'Nama Pemasok',
    'pembeli' => 'pemasok',
    'selling_price' => 'price',
    'invoice?.customer_name' => 'invoice?.supplier?.name',
    'Menjual' => 'Membeli',
    'menjual' => 'membeli'
];

foreach ($files as $file) {
    $path = $dir . DIRECTORY_SEPARATOR . $file;
    if (file_exists($path)) {
        $content = file_get_contents($path);
        foreach ($replacements as $search => $replace) {
            $content = str_replace($search, $replace, $content);
        }
        file_put_contents($path, $content);
        echo "Updated $file\n";
    }
}
