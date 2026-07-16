<x-superadmin-layout>
    <!-- We removed the flaky @media print CSS and use JS iframe printing instead -->
    <div x-data="{ invoiceModalOpen: false, invoice: null }">
    <div class="mb-8 flex flex-col md:flex-row md:items-center justify-between gap-4">
        <div>
            <h1 class="text-3xl font-extrabold text-slate-900 tracking-tight">Riwayat Penjualan</h1>
            <p class="text-slate-500 mt-1">Daftar transaksi kasir yang telah berhasil dilakukan.</p>
        </div>
        <a href="{{ route('superadmin.sales.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand-blue text-brand-yellow font-bold rounded-xl shadow-lg shadow-brand-blue/20 hover:bg-brand-blue/90 transition-all focus:ring-2 focus:ring-brand-blue focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Tambah Transaksi Baru
        </a>
    </div>

    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-6 overflow-hidden">
        <div class="flex flex-col sm:flex-row justify-between items-center mb-6 gap-4 border-b border-slate-100 pb-4">
            <h3 class="text-lg font-bold text-slate-800">Daftar Transaksi</h3>
            <form action="{{ route('superadmin.sales.index') }}" method="GET" class="w-full sm:w-64 relative">
                <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama pembeli..." class="w-full pl-10 pr-4 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue transition-all text-sm font-medium">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="bg-slate-50/50 text-slate-500 font-semibold border-b border-slate-100">
                    <tr>
                        <th class="px-4 py-3 rounded-tl-xl">ID Transaksi</th>
                        <th class="px-4 py-3">Tanggal</th>
                        <th class="px-4 py-3">Nama Pembeli</th>
                        <th class="px-4 py-3">Kasir</th>
                        <th class="px-4 py-3 text-right">Grand Total</th>
                        <th class="px-4 py-3 text-center rounded-tr-xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($sales as $sale)
                    <tr class="hover:bg-slate-50 transition-colors">
                        <td class="px-4 py-3 font-bold text-slate-700">#TRX-{{ str_pad($sale->id, 5, '0', STR_PAD_LEFT) }}</td>
                        <td class="px-4 py-3 text-slate-500 font-medium">{{ \Carbon\Carbon::parse($sale->sale_date)->translatedFormat('d F Y') }}</td>
                        <td class="px-4 py-3 font-bold text-slate-800">{{ $sale->customer_name }}</td>
                        <td class="px-4 py-3 text-slate-500">{{ $sale->user->name ?? '-' }}</td>
                        <td class="px-4 py-3 text-right font-black text-brand-blue">Rp {{ number_format($sale->grand_total, 0, ',', '.') }}</td>
                        <td class="px-4 py-3 text-center">
                            <div class="flex items-center justify-center gap-2">
                                <!-- Print Invoice Button -->
                                <button type="button" @click="invoice = {{ json_encode($sale) }}; invoiceModalOpen = true" class="p-2 text-slate-400 hover:text-brand-blue hover:bg-blue-50 rounded-lg transition-colors" title="Cetak Struk">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                                </button>
                                
                                <!-- Delete Button (with confirmation) -->
                                <form action="{{ route('superadmin.sales.destroy', $sale->id) }}" method="POST" class="inline-block confirm-form" data-action="menghapus transaksi {{ $sale->customer_name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 hover:bg-red-50 rounded-lg transition-colors" title="Batalkan Transaksi & Kembalikan Stok">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-16 text-center">
                            <div class="flex flex-col items-center justify-center">
                                <div class="w-16 h-16 bg-slate-100 rounded-full flex items-center justify-center mb-4 text-slate-400">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                                </div>
                                <h4 class="text-lg font-bold text-slate-700">Belum Ada Transaksi</h4>
                                <p class="text-slate-500 mt-1 max-w-sm">Klik tombol "Tambah Transaksi Baru" di atas untuk mulai menjual obat ke pelanggan.</p>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $sales->links() }}
        </div>
        
        <!-- Invoice Modal -->
        <div x-show="invoiceModalOpen" style="display: none;" class="fixed inset-0 z-[100] overflow-y-auto no-print" aria-labelledby="modal-title" role="dialog" aria-modal="true">
            <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
                <div x-show="invoiceModalOpen" x-transition.opacity class="fixed inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity" aria-hidden="true" @click="invoiceModalOpen = false"></div>
                <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
                
                <div x-show="invoiceModalOpen" 
                     x-transition:enter="ease-out duration-300" 
                     x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95" 
                     x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave="ease-in duration-200" 
                     x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100" 
                     x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                     class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-md w-full border border-slate-100">
                    
                    <div id="printable-invoice" class="bg-white px-6 pt-6 pb-6" x-show="invoice">
                        <!-- Invoice Header -->
                        <div class="text-center border-b border-dashed border-slate-300 pb-4 mb-4">
                            <h2 class="text-xl font-black text-slate-900 tracking-tight">APOTEK ANJIR PASAR KM 18</h2>
                            <p class="text-xs text-slate-500 mt-1">support@e-apotek.com</p>
                            <p class="text-xs text-slate-500">Telp: +62 812 3456 7890</p>
                        </div>
                        
                        <!-- Invoice Info -->
                        <div class="flex justify-between text-xs text-slate-600 font-medium mb-4">
                            <div>
                                <p>No. TRX : <span x-text="'#TRX-' + String(invoice?.id).padStart(5, '0')"></span></p>
                                <p>Kasir   : <span x-text="invoice?.user?.name || '-'"></span></p>
                            </div>
                            <div class="text-right">
                                <p>Tgl : <span x-text="new Date(invoice?.sale_date).toLocaleDateString('id-ID')"></span></p>
                                <p>Plg : <span x-text="invoice?.customer_name"></span></p>
                            </div>
                        </div>
                        
                        <!-- Invoice Items -->
                        <div class="border-b border-dashed border-slate-300 pb-4 mb-4">
                            <table class="w-full text-xs text-slate-700">
                                <thead class="border-b border-slate-200">
                                    <tr>
                                        <th class="text-left py-2">Item</th>
                                        <th class="text-center py-2">Qty</th>
                                        <th class="text-right py-2">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <template x-for="item in invoice?.details" :key="item.id">
                                        <tr>
                                            <td class="py-2 pr-2">
                                                <div class="font-bold" x-text="item.medicine?.name"></div>
                                                <div class="text-[10px] text-slate-500"><span x-text="new Intl.NumberFormat('id-ID').format(item.selling_price)"></span> / <span x-text="item.medicine?.unit?.name"></span></div>
                                            </td>
                                            <td class="py-2 text-center align-top font-bold text-slate-600" x-text="item.quantity"></td>
                                            <td class="py-2 text-right align-top font-bold" x-text="new Intl.NumberFormat('id-ID').format(item.subtotal)"></td>
                                        </tr>
                                    </template>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Invoice Total -->
                        <div class="flex justify-between items-center text-sm font-black text-slate-900 mb-1">
                            <span>TOTAL BELANJA</span>
                            <span>Rp <span x-text="new Intl.NumberFormat('id-ID').format(invoice?.grand_total || 0)"></span></span>
                        </div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-600 mb-1">
                            <span>TUNAI</span>
                            <span>Rp <span x-text="new Intl.NumberFormat('id-ID').format(invoice?.cash_given || 0)"></span></span>
                        </div>
                        <div class="flex justify-between items-center text-xs font-bold text-slate-600 mb-6 border-t border-slate-200 pt-1">
                            <span>KEMBALI</span>
                            <span>Rp <span x-text="new Intl.NumberFormat('id-ID').format(invoice?.change || 0)"></span></span>
                        </div>
                        
                        <!-- Footer -->
                        <div class="text-center text-[10px] text-slate-500 font-medium">
                            <p>Terima kasih telah berbelanja di E-Apotek.</p>
                            <p>Semoga lekas sembuh!</p>
                        </div>
                    </div>
                    
                    <div class="bg-slate-50 px-4 py-4 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100 no-print">
                        <button type="button" onclick="printInvoice('printable-invoice')" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-brand-blue text-base font-bold text-white hover:bg-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Cetak Struk (Print)
                        </button>
                        <button type="button" @click="invoiceModalOpen = false" class="mt-3 w-full inline-flex justify-center rounded-xl border border-slate-200 shadow-sm px-4 py-2 bg-white text-base font-bold text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-brand-blue sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Tutup
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Script for bulletproof iframe printing -->
    <script>
        function printInvoice(divId) {
            const content = document.getElementById(divId).innerHTML;
            const iframe = document.createElement('iframe');
            
            // Hide iframe
            iframe.style.position = 'fixed';
            iframe.style.right = '0';
            iframe.style.bottom = '0';
            iframe.style.width = '0';
            iframe.style.height = '0';
            iframe.style.border = '0';
            document.body.appendChild(iframe);
            
            const doc = iframe.contentWindow.document;
            
            // Copy head content (Tailwind CSS, fonts, etc)
            doc.write('<html><head>');
            doc.write(document.head.innerHTML);
            // Specific styles for 80mm Thermal POS Printer
            doc.write('<style>');
            doc.write('@page { size: 80mm auto; margin: 0; }');
            doc.write('body { width: 80mm; margin: 0 auto; padding: 4mm; background: white; color: black !important; }');
            doc.write('* { color: black !important; border-color: black !important; }'); // Force Black & White for thermal
            doc.write('</style>');
            doc.write('</head><body>');
            doc.write(content);
            doc.write('</body></html>');
            doc.close();
            
            // Wait for styles to load then print
            iframe.onload = function() {
                iframe.contentWindow.focus();
                iframe.contentWindow.print();
                
                // Cleanup
                setTimeout(function() {
                    document.body.removeChild(iframe);
                }, 1000);
            };
        }
    </script>
</x-superadmin-layout>
