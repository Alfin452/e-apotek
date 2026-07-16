<x-superadmin-layout>
    <!-- Include Flatpickr CSS/JS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>

    <div class="mb-4 flex justify-end">
        <a href="{{ route('superadmin.sales.index') }}" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-slate-700 font-bold rounded-xl border border-slate-200 hover:bg-slate-50 hover:text-brand-blue transition-all shadow-sm text-sm">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali ke Riwayat
        </a>
    </div>

    @if ($errors->any())
    <div class="mb-6 p-4 bg-red-50 border border-red-200 rounded-2xl flex items-start gap-3 shadow-sm">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-red-600 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
        <ul class="list-disc pl-5 text-sm font-medium text-red-800 mt-0.5">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <div x-data="posApp()" class="grid grid-cols-1 xl:grid-cols-3 gap-4 items-start">
        
        <!-- Left: Form Input -->
        <div class="xl:col-span-2">
            <div class="bg-white rounded-2xl shadow-sm border border-slate-100 p-4 md:p-5">
                <form action="{{ route('superadmin.sales.store') }}" method="POST" id="salesForm" @submit.prevent="submitForm">
                    @csrf
                    
                    <!-- Customer & Date -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4 border-b border-slate-100 pb-4">
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Nama Pembeli <span class="text-red-500">*</span></label>
                            <input type="text" name="customer_name" required placeholder="Nama pelanggan umum / pasien" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue transition-all text-sm font-medium text-slate-800">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-slate-700 mb-1">Tanggal Transaksi <span class="text-red-500">*</span></label>
                            <div class="relative">
                                <input type="text" name="sale_date" id="sale_date" required placeholder="Pilih Tanggal" class="w-full pl-10 pr-3 py-2 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue transition-all text-sm font-medium text-slate-800 cursor-pointer">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-slate-400 absolute left-3.5 top-1/2 -translate-y-1/2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                            </div>
                        </div>
                    </div>

                    <!-- Repeater Keranjang -->
                    <div class="mb-4 flex items-center justify-between">
                        <h3 class="text-lg font-bold text-slate-800">Keranjang Obat</h3>
                        <button type="button" @click="addItem()" class="inline-flex items-center gap-2 px-4 py-2 bg-blue-50 text-brand-blue font-bold rounded-xl border border-blue-100 hover:bg-blue-100 transition-all text-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                            Tambah Produk
                        </button>
                    </div>

                    <div class="space-y-3">
                        <template x-for="(item, index) in items" :key="item.id">
                            <div class="p-3 rounded-xl border border-slate-200 bg-slate-50 relative group transition-all">
                                
                                <!-- Hapus Tombol -->
                                <button type="button" @click="removeItem(index)" x-show="items.length > 1" class="absolute -top-3 -right-3 w-8 h-8 bg-red-100 text-red-600 rounded-full flex items-center justify-center border border-white hover:bg-red-500 hover:text-white transition-all shadow-sm opacity-0 group-hover:opacity-100">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                </button>

                                <div class="grid grid-cols-1 md:grid-cols-12 gap-4">
                                    
                                    <!-- Pilih Obat (Custom Searchable Combobox) -->
                                    <div class="md:col-span-5 relative" x-data="{ 
                                        search: '', 
                                        dropdownOpen: false,
                                        initSearch() {
                                            this.search = item.medicine_id ? getMedicineLabel(item.medicine_id) : '';
                                            this.$watch('item.medicine_id', value => {
                                                this.search = value ? getMedicineLabel(value) : '';
                                            });
                                        },
                                        isSearching() {
                                            if (!item.medicine_id) return this.search.length > 0;
                                            return this.search.toLowerCase() !== getMedicineLabel(item.medicine_id).toLowerCase();
                                        }
                                    }" x-init="initSearch()" @click.away="dropdownOpen = false">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Nama Obat</label>
                                        
                                        <!-- Searchable Input -->
                                        <div class="relative">
                                            <input type="text" 
                                                   x-model="search" 
                                                   @focus="dropdownOpen = true; $el.select()"
                                                   @input="dropdownOpen = true; if(isSearching()) { item.medicine_id = ''; updateItemDetails(index); }"
                                                   @click="dropdownOpen = true"
                                                   placeholder="Ketik cari obat atau klik ikon..." 
                                                   class="w-full pl-3 pr-8 py-2 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue font-bold text-slate-800 text-sm transition-all shadow-sm">
                                            
                                            <!-- Dropdown Arrow Icon (Clickable to toggle) -->
                                            <button type="button" @click="dropdownOpen = !dropdownOpen" class="absolute right-0 top-0 h-full px-3 flex items-center justify-center text-slate-400 hover:text-brand-blue transition-colors focus:outline-none">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200" :class="{'rotate-180': dropdownOpen}" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>
                                            </button>
                                        </div>
                                        
                                        <!-- Hidden actual input for form submission -->
                                        <input type="hidden" :name="`medicines[${index}][id]`" x-model="item.medicine_id" required>

                                        <!-- Dropdown Menu -->
                                        <div x-show="dropdownOpen" x-transition.opacity.duration.200ms style="display: none;" class="absolute z-50 left-0 w-full min-w-[300px] sm:w-[150%] lg:w-[125%] mt-1 bg-white border border-slate-100 rounded-2xl shadow-2xl max-h-72 overflow-hidden flex flex-col">
                                            
                                            <!-- Options List -->
                                            <div class="overflow-y-auto flex-1 p-2 space-y-1 custom-scrollbar">
                                                <template x-for="med in availableMedicines.filter(m => !isSearching() || m.name.toLowerCase().includes(search.toLowerCase()))" :key="med.id">
                                                    <button type="button" 
                                                            @click="if(!isMedicineSelected(med.id, index)) { 
                                                                item.medicine_id = med.id; 
                                                                search = med.name;
                                                                updateItemDetails(index); 
                                                                dropdownOpen = false; 
                                                            }" 
                                                            :disabled="isMedicineSelected(med.id, index)"
                                                            :class="isMedicineSelected(med.id, index) ? 'opacity-50 cursor-not-allowed bg-slate-50 text-slate-400' : 'hover:bg-blue-50 hover:text-brand-blue text-slate-700'"
                                                            class="w-full text-left px-3 py-2.5 rounded-xl text-sm font-bold transition-all flex justify-between items-center group">
                                                        <span x-text="med.name" class="truncate pr-2"></span>
                                                        <span class="text-[10px] px-2 py-1 rounded-lg font-bold shrink-0" :class="isMedicineSelected(med.id, index) ? 'bg-slate-200 text-slate-500' : 'bg-green-100 text-green-700 group-hover:bg-green-200 group-hover:shadow-sm'" x-text="isMedicineSelected(med.id, index) ? 'Dipilih' : `Stok: ${med.stock}`"></span>
                                                    </button>
                                                </template>
                                                <div x-show="availableMedicines.filter(m => !isSearching() || m.name.toLowerCase().includes(search.toLowerCase())).length === 0" class="text-center py-4 text-slate-400 text-xs font-semibold flex flex-col items-center">
                                                    Obat tidak ditemukan.
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Harga Satuan (Readonly UI) -->
                                    <div class="md:col-span-3">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Harga / Satuan</label>
                                        <div class="px-3 py-2 bg-slate-100 border border-slate-200 rounded-xl text-sm font-semibold text-slate-500 flex items-center justify-between">
                                            <span x-text="item.price ? 'Rp ' + formatRupiah(item.price) : '-'"></span>
                                            <span class="text-[10px] text-slate-400 font-bold" x-text="item.unitName ? '/ '+item.unitName : ''"></span>
                                        </div>
                                    </div>

                                    <!-- Qty -->
                                    <div class="md:col-span-2">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Qty</label>
                                        <input type="number" x-model.number="item.quantity" @input="calculateSubtotal(index)" :name="`medicines[${index}][quantity]`" required min="1" :max="item.maxStock" placeholder="0" class="w-full px-3 py-2 rounded-xl border border-slate-200 bg-white focus:ring-2 focus:ring-brand-blue/20 focus:border-brand-blue font-black text-center text-slate-800 text-sm" :disabled="!item.medicine_id">
                                        <div x-show="item.medicine_id" class="text-[10px] font-semibold text-center mt-1" :class="item.quantity > item.maxStock ? 'text-red-500' : 'text-slate-400'">
                                            Maks: <span x-text="item.maxStock"></span>
                                        </div>
                                    </div>

                                    <!-- Subtotal -->
                                    <div class="md:col-span-2">
                                        <label class="block text-[10px] font-bold text-slate-500 uppercase tracking-wider mb-1">Subtotal</label>
                                        <div class="px-3 py-2 bg-brand-yellow/10 border border-brand-yellow/30 rounded-xl text-sm font-black text-slate-800 text-right">
                                            <span x-text="item.subtotal ? formatRupiah(item.subtotal) : '0'"></span>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </template>
                    </div>
                </form>
            </div>
        </div>

        <!-- Right: Summary Panel -->
        <div class="xl:col-span-1">
            <div class="bg-slate-900 rounded-2xl shadow-xl p-5 md:p-6 sticky top-4 relative overflow-hidden">
                <!-- Aesthetic Background Elements -->
                <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCI+CjxyZWN0IHdpZHRoPSIyMCIgaGVpZ2h0PSIyMCIgZmlsbD0ibm9uZSI+PC9yZWN0Pgo8Y2lyY2xlIGN4PSIyIiBjeT0iMiIgcj0iMSIgZmlsbD0icmdiYSgyNTUsIDI1NSwgMjU1LCAwLjAzKSI+PC9jaXJjbGU+Cjwvc3ZnPg==')] z-0"></div>
                <div class="absolute -right-8 -top-8 w-32 h-32 bg-brand-blue/30 rounded-full blur-2xl z-0"></div>
                
                <div class="relative z-10">
                    <h3 class="text-lg font-bold text-white mb-4 flex items-center gap-2 border-b border-slate-700 pb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 text-brand-yellow" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                        Ringkasan Belanja
                    </h3>

                    <div class="space-y-3 mb-6">
                        <div class="flex justify-between items-center text-slate-300">
                            <span class="text-xs font-medium">Total Item Obat:</span>
                            <span class="font-bold text-white bg-slate-800 px-2 py-1 rounded-md text-xs" x-text="items.filter(i => i.medicine_id).length + ' Jenis'"></span>
                        </div>
                        <div class="flex justify-between items-center text-slate-300">
                            <span class="text-xs font-medium">Total Kuantitas:</span>
                            <span class="font-bold text-white bg-slate-800 px-2 py-1 rounded-md text-xs" x-text="items.reduce((sum, item) => sum + (item.quantity || 0), 0) + ' Pcs'"></span>
                        </div>
                    </div>

                    <div class="bg-black/20 rounded-xl p-4 mb-4 border border-white/5">
                        <div class="text-slate-400 text-xs font-semibold uppercase tracking-wider mb-1">Grand Total</div>
                        <div class="text-3xl font-black text-brand-yellow tracking-tight">
                            Rp <span x-text="formatRupiah(grandTotal)"></span>
                        </div>
                    </div>

                    <!-- Kalkulator Uang Pelanggan -->
                    <div class="space-y-4 mb-6">
                        <div>
                            <label class="block text-xs font-semibold text-slate-300 uppercase tracking-wider mb-1.5">Uang Tunai (Dibayar)</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 font-bold">Rp</span>
                                <input type="text" x-model="formattedCash" @input="updateCash()" placeholder="0" class="w-full pl-10 pr-4 py-2.5 rounded-xl border border-slate-600 bg-slate-800 focus:bg-slate-700 focus:ring-2 focus:ring-brand-yellow/50 focus:border-brand-yellow transition-all text-white font-bold text-lg">
                                <input type="hidden" form="salesForm" name="customer_cash" :value="customerCash">
                            </div>
                        </div>
                        
                        <div class="bg-slate-800/50 rounded-xl p-3 border border-slate-700/50 flex justify-between items-center" :class="customerCash > 0 && customerCash < grandTotal ? 'border-red-500/50 bg-red-500/10' : ''">
                            <span class="text-xs font-bold uppercase tracking-wider" :class="customerCash > 0 && customerCash < grandTotal ? 'text-red-400' : 'text-slate-400'">Kembalian</span>
                            <div class="text-xl font-black" :class="customerCash > 0 && customerCash < grandTotal ? 'text-red-400' : 'text-emerald-400'">
                                Rp <span x-text="formatRupiah(customerChange)"></span>
                            </div>
                        </div>
                    </div>

                    <button type="submit" form="salesForm" class="w-full bg-brand-yellow hover:bg-yellow-400 text-slate-900 font-black py-3 px-4 rounded-xl transition-all shadow-[0_0_20px_rgba(251,252,9,0.3)] text-base flex items-center justify-center gap-2 group" :disabled="grandTotal === 0 || hasErrors() || (customerCash > 0 && customerCash < grandTotal)">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 transform group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        Simpan Transaksi
                    </button>
                    
                    <div x-show="hasErrors()" class="mt-4 text-xs font-medium text-red-400 text-center bg-red-400/10 py-2 px-3 rounded-lg border border-red-400/20">
                        Ada kesalahan pada form (cth: kuantitas melebihi stok). Periksa kembali pesanan Anda.
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script>
        // Init Flatpickr
        document.addEventListener('DOMContentLoaded', function() {
            flatpickr("#sale_date", {
                locale: "id",
                dateFormat: "Y-m-d",
                defaultDate: "today",
                maxDate: "today", // Prevent future dates
            });
        });

        // Alpine JS Logic
        function posApp() {
            return {
                availableMedicines: @json($medicines), // Datang dari controller
                customerCash: 0,
                formattedCash: '',
                items: [
                    { id: Date.now(), medicine_id: '', price: 0, quantity: 1, subtotal: 0, maxStock: 0, unitName: '' }
                ],
                
                updateCash() {
                    // Remove non-digits
                    let rawValue = this.formattedCash.replace(/\D/g, '');
                    this.customerCash = parseInt(rawValue) || 0;
                    // Format back with dots
                    this.formattedCash = rawValue ? parseInt(rawValue).toLocaleString('id-ID') : '';
                },
                
                get grandTotal() {
                    return this.items.reduce((sum, item) => sum + (item.subtotal || 0), 0);
                },

                get customerChange() {
                    if (this.customerCash === 0 || this.customerCash < this.grandTotal) return 0;
                    return this.customerCash - this.grandTotal;
                },

                getMedicineLabel(id) {
                    let med = this.availableMedicines.find(m => m.id == id);
                    return med ? med.name : '-- Cari & Pilih Obat --';
                },

                addItem() {
                    this.items.push({
                        id: Date.now(),
                        medicine_id: '',
                        price: 0,
                        quantity: 1,
                        subtotal: 0,
                        maxStock: 0,
                        unitName: ''
                    });
                },

                removeItem(index) {
                    this.items.splice(index, 1);
                },

                updateItemDetails(index) {
                    let item = this.items[index];
                    let medicine = this.availableMedicines.find(m => m.id == item.medicine_id);
                    
                    if (medicine) {
                        item.price = medicine.selling_price;
                        item.maxStock = medicine.stock;
                        item.unitName = medicine.unit.name;
                        // Reset qty to 1 when changing product to be safe
                        item.quantity = 1;
                        this.calculateSubtotal(index);
                    } else {
                        item.price = 0;
                        item.maxStock = 0;
                        item.unitName = '';
                        item.quantity = 0;
                        item.subtotal = 0;
                    }
                },

                calculateSubtotal(index) {
                    let item = this.items[index];
                    // Prevent negative or zero
                    if (item.quantity < 1) item.quantity = 1;
                    // Cap at max stock visually (backend will also validate)
                    if (item.quantity > item.maxStock) {
                        // We won't force it down to let the user see their error, but we show error text below input
                    }
                    item.subtotal = item.price * item.quantity;
                },

                isMedicineSelected(medId, currentIndex) {
                    // Prevent selecting the same medicine in multiple rows to keep cart clean
                    return this.items.some((item, index) => item.medicine_id == medId && index !== currentIndex);
                },

                hasErrors() {
                    return this.items.some(item => !item.medicine_id || item.quantity > item.maxStock || item.quantity < 1);
                },

                submitForm() {
                    if (this.hasErrors()) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Data Tidak Valid',
                            text: 'Pastikan jumlah obat tidak melebihi sisa stok dan semua baris obat sudah dipilih.',
                            confirmButtonColor: '#ef4444'
                        });
                        return;
                    }
                    
                    document.getElementById('salesForm').submit();
                },

                formatRupiah(number) {
                    return new Intl.NumberFormat('id-ID').format(number);
                }
            }
        }
    </script>
</x-superadmin-layout>
