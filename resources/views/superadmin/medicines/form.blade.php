<x-superadmin-layout>
    <div class="mb-8">
        <a href="{{ route('superadmin.medicines.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-slate-500 hover:text-brand-blue mb-4 transition-colors">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" /></svg>
            Kembali ke Data Obat
        </a>
        <h1 class="text-2xl font-bold text-slate-900 tracking-tight">{{ isset($medicine) ? 'Edit Data Obat' : 'Tambah Obat Baru' }}</h1>
        <p class="text-sm text-slate-500 mt-1">Isi formulir di bawah ini dengan lengkap dan benar.</p>
    </div>

    @if ($errors->any())
    <div class="mb-6 p-4 rounded-2xl bg-red-50 border border-red-200 shadow-sm">
        <div class="flex items-center gap-3 mb-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-red-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
            <h3 class="text-sm font-bold text-red-800">Terdapat kesalahan input:</h3>
        </div>
        <ul class="list-disc list-inside text-sm text-red-700 ml-8">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <form action="{{ isset($medicine) ? route('superadmin.medicines.update', $medicine->id) : route('superadmin.medicines.store') }}" method="POST" class="space-y-6 w-full">
        @csrf
        @if(isset($medicine))
            @method('PUT')
        @endif

        <!-- SECTION 1: Informasi Dasar -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
            <h2 class="text-lg font-extrabold text-slate-800 mb-6">
                Informasi Dasar Obat
            </h2>
            
            <div class="space-y-6">
                <div>
                    <label class="block text-sm font-bold text-slate-900 mb-2">Nama Obat <span class="text-red-500">*</span></label>
                    <input type="text" name="name" value="{{ old('name', $medicine->name ?? '') }}" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900" placeholder="Contoh: Paracetamol 500mg">
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-900 mb-2">Kategori <span class="text-red-500">*</span></label>
                        <select name="category_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900">
                            <option value="">Pilih Kategori</option>
                            @foreach($categories as $cat)
                                <option value="{{ $cat->id }}" {{ old('category_id', $medicine->category_id ?? '') == $cat->id ? 'selected' : '' }}>{{ $cat->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-900 mb-2">Jenis Obat <span class="text-red-500">*</span></label>
                        <select name="type_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900">
                            <option value="">Pilih Jenis</option>
                            @foreach($types as $type)
                                <option value="{{ $type->id }}" {{ old('type_id', $medicine->type_id ?? '') == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-bold text-slate-900 mb-2">Deskripsi & Indikasi</label>
                    <textarea name="description" rows="3" class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900" placeholder="Tambahkan indikasi, efek samping, atau catatan khusus (Opsional)">{{ old('description', $medicine->description ?? '') }}</textarea>
                </div>
            </div>
        </div>

        <!-- SECTION 2: Inventori & Penyimpanan -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
            <h2 class="text-lg font-extrabold text-slate-800 mb-6">
                Inventori & Penyimpanan
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <!-- Kiri -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-900 mb-2">Lokasi Penyimpanan <span class="text-red-500">*</span></label>
                        <select name="storage_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900">
                            <option value="">Pilih Lokasi</option>
                            @foreach($storages as $st)
                                <option value="{{ $st->id }}" {{ old('storage_id', $medicine->storage_id ?? '') == $st->id ? 'selected' : '' }}>{{ $st->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-900 mb-2">Tanggal Kadaluarsa (Exp. Date) <span class="text-red-500">*</span></label>
                        <input type="text" name="expired_date" value="{{ old('expired_date', $medicine->expired_date ?? '') }}" required class="datepicker w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900" placeholder="YYYY-MM-DD">
                    </div>
                </div>

                <!-- Kanan -->
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-900 mb-2">Satuan (Unit) <span class="text-red-500">*</span></label>
                        <select name="unit_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900">
                            <option value="">Pilih Unit</option>
                            @foreach($units as $unit)
                                <option value="{{ $unit->id }}" {{ old('unit_id', $medicine->unit_id ?? '') == $unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-bold text-slate-900 mb-2">Stok Awal <span class="text-red-500">*</span></label>
                            <input type="number" name="stock" value="{{ old('stock', $medicine->stock ?? 0) }}" min="0" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900">
                        </div>
                        <div>
                            <label class="block text-sm font-bold text-slate-900 mb-2">Min. Stok Alert <span class="text-red-500">*</span></label>
                            <input type="number" name="min_stock" value="{{ old('min_stock', $medicine->min_stock ?? 5) }}" min="0" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900">
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SECTION 3: Harga & Pemasok -->
        <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8">
            <h2 class="text-lg font-extrabold text-slate-800 mb-6">
                Harga & Pemasok
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <div class="space-y-6">
                    <div>
                        <label class="block text-sm font-bold text-slate-900 mb-2">Harga Beli (Modal) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">Rp</span>
                            <input type="text" data-target="purchase_price_hidden" value="{{ old('purchase_price', $medicine->purchase_price ?? '') }}" required class="rupiah-input w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-bold text-slate-900">
                            <input type="hidden" name="purchase_price" id="purchase_price_hidden" value="{{ old('purchase_price', $medicine->purchase_price ?? '') }}">
                        </div>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-slate-900 mb-2">Harga Jual (Retail) <span class="text-red-500">*</span></label>
                        <div class="relative">
                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-slate-400 font-bold">Rp</span>
                            <input type="text" data-target="selling_price_hidden" value="{{ old('selling_price', $medicine->selling_price ?? '') }}" required class="rupiah-input w-full pl-12 pr-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-bold text-slate-900">
                            <input type="hidden" name="selling_price" id="selling_price_hidden" value="{{ old('selling_price', $medicine->selling_price ?? '') }}">
                        </div>
                    </div>
                </div>
                <div>
                    <label class="block text-sm font-bold text-slate-900 mb-2">Pemasok Utama (Supplier) <span class="text-red-500">*</span></label>
                    <select name="supplier_id" required class="w-full px-4 py-3 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900">
                        <option value="">Pilih Pemasok</option>
                        @foreach($suppliers as $sup)
                            <option value="{{ $sup->id }}" {{ old('supplier_id', $medicine->supplier_id ?? '') == $sup->id ? 'selected' : '' }}>{{ $sup->name }}</option>
                        @endforeach
                    </select>
                    <p class="text-xs text-slate-500 mt-2">Untuk menambah pemasok baru, silakan pergi ke menu Manajemen Pemasok.</p>
                </div>
            </div>
        </div>

        <!-- Form Actions -->
        <div class="flex items-center justify-end gap-4 pt-4 pb-12">
            <a href="{{ route('superadmin.medicines.index') }}" class="px-6 py-3.5 rounded-xl font-bold text-slate-600 bg-white border border-slate-200 hover:bg-slate-50 transition-colors focus:ring-2 focus:ring-slate-200 focus:outline-none">
                Batalkan
            </a>
            <button type="submit" class="px-8 py-3.5 rounded-xl font-bold text-brand-yellow bg-brand-blue hover:bg-brand-blue/90 shadow-lg shadow-brand-blue/20 transition-all focus:ring-2 focus:ring-brand-blue focus:outline-none">
                {{ isset($medicine) ? 'Simpan Perubahan' : 'Simpan Obat Baru' }}
            </button>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            function formatRupiah(angka) {
                var number_string = angka.toString().replace(/[^,\d]/g, ''),
                    split = number_string.split(','),
                    sisa  = split[0].length % 3,
                    rupiah  = split[0].substr(0, sisa),
                    ribuan  = split[0].substr(sisa).match(/\d{3}/gi);
                    
                if (ribuan) {
                    let separator = sisa ? '.' : '';
                    rupiah += separator + ribuan.join('.');
                }
                return rupiah;
            }

            document.querySelectorAll('.rupiah-input').forEach(function(input) {
                // Format saat load pertama kali (jika ada isinya, misal pas Edit)
                if(input.value) {
                    input.value = formatRupiah(input.value);
                }
                
                // Format saat pengguna mengetik
                input.addEventListener('input', function(e) {
                    let rawValue = this.value.replace(/\./g, '');
                    this.value = formatRupiah(rawValue);
                    
                    let targetId = this.getAttribute('data-target');
                    if(targetId) {
                        document.getElementById(targetId).value = rawValue;
                    }
                });
            });
        });
    </script>
</x-superadmin-layout>
