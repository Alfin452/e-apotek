<x-superadmin-layout>
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="text-2xl font-bold text-slate-900 tracking-tight">Data Obat</h1>
            <p class="text-sm text-slate-600 mt-1">Kelola stok, harga, dan master data obat apotek Anda.</p>
        </div>
        <a href="{{ route('superadmin.medicines.create') }}" class="inline-flex items-center gap-2 px-4 py-2.5 bg-brand-blue text-brand-yellow font-bold rounded-xl shadow-lg shadow-brand-blue/20 hover:bg-brand-blue/90 transition-all focus:ring-2 focus:ring-brand-blue focus:outline-none">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Tambah Obat
        </a>
    </div>



    <!-- Main Bento Box -->
    <div class="bg-white rounded-3xl shadow-sm border border-slate-100 p-8 overflow-hidden">
        <!-- Search and Filters -->
        <form action="{{ route('superadmin.medicines.index') }}" method="GET" class="mb-6 space-y-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative">
                    <input type="text" name="search" value="{{ $search }}" placeholder="Cari nama obat..." class="w-full pl-11 pr-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-800 placeholder-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 absolute left-4 top-1/2 -translate-y-1/2 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                </div>
                
                <div>
                    <select name="category_id" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900">
                        <option value="">Semua Kategori</option>
                        @foreach($categories as $cat)
                            <option value="{{ $cat->id }}" {{ (isset($category_id) && $category_id == $cat->id) ? 'selected' : '' }}>{{ $cat->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <select name="type_id" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900">
                        <option value="">Semua Jenis</option>
                        @foreach($types as $type)
                            <option value="{{ $type->id }}" {{ (isset($type_id) && $type_id == $type->id) ? 'selected' : '' }}>{{ $type->name }}</option>
                        @endforeach
                    </select>
                </div>

                <div class="flex gap-2">
                    <div class="flex-1">
                        <select name="supplier_id" onchange="this.form.submit()" class="w-full px-4 py-2.5 rounded-xl border border-slate-200 bg-slate-50 focus:bg-white focus:ring-2 focus:ring-slate-200 focus:border-slate-300 transition-all text-sm font-medium text-slate-900">
                            <option value="">Semua Pemasok</option>
                            @foreach($suppliers as $sup)
                                <option value="{{ $sup->id }}" {{ (isset($supplier_id) && $supplier_id == $sup->id) ? 'selected' : '' }}>{{ $sup->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    @if($search || request('category_id') || request('type_id') || request('supplier_id'))
                        <a href="{{ route('superadmin.medicines.index') }}" class="px-3 py-2.5 bg-red-50 text-red-600 font-bold rounded-xl hover:bg-red-100 transition-colors shadow-sm flex items-center justify-center shrink-0" title="Reset Filter">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                        </a>
                    @endif
                </div>
            </div>
            
            <button type="submit" class="hidden"></button>
        </form>

        <div class="overflow-x-auto">
            <table class="w-full text-left text-sm text-slate-600">
                <thead class="text-xs text-slate-700 uppercase bg-slate-50/50">
                    <tr>
                        <th class="px-4 py-4 font-bold rounded-tl-2xl">Nama Obat</th>
                        <th class="px-4 py-4 font-bold">Kategori & Jenis</th>
                        <th class="px-4 py-4 font-bold">Penyimpanan</th>
                        <th class="px-4 py-4 font-bold">Stok</th>
                        <th class="px-4 py-4 font-bold">Harga Jual</th>
                        <th class="px-4 py-4 font-bold text-right rounded-tr-2xl">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse($medicines as $med)
                    <tr class="hover:bg-slate-50/80 transition-colors group">
                        <td class="px-4 py-4">
                            <div class="font-bold text-slate-900">{{ $med->name }}</div>
                            <div class="text-xs text-slate-600 mt-1">Exp: <span class="font-medium {{ $med->expired_date < now()->addMonth() ? 'text-red-500' : '' }}">{{ \Carbon\Carbon::parse($med->expired_date)->translatedFormat('d M Y') }}</span></div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 bg-brand-blue/10 text-brand-blue text-[10px] font-bold uppercase rounded-md tracking-wider">{{ $med->category->name }}</span>
                                <span class="px-2 py-1 bg-slate-100 text-slate-600 text-[10px] font-bold uppercase rounded-md tracking-wider">{{ $med->type->name }}</span>
                            </div>
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-medium text-slate-800">{{ $med->storage->name }}</div>
                        </td>
                        <td class="px-4 py-4">
                            @if($med->stock <= $med->min_stock)
                                <div class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-lg bg-red-50 text-red-700 font-bold text-xs border border-red-200">
                                    <span class="relative flex h-2 w-2"><span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span><span class="relative inline-flex rounded-full h-2 w-2 bg-red-500"></span></span>
                                    {{ $med->stock }} {{ $med->unit->name }}
                                </div>
                            @else
                                <div class="font-bold text-slate-700">{{ $med->stock }} <span class="font-medium text-slate-400">{{ $med->unit->name }}</span></div>
                            @endif
                        </td>
                        <td class="px-4 py-4">
                            <div class="font-bold text-brand-blue">Rp {{ number_format($med->selling_price, 0, ',', '.') }}</div>
                        </td>
                        <td class="px-4 py-4 text-right">
                            <div class="flex items-center justify-end gap-2 transition-opacity">
                                <a href="{{ route('superadmin.medicines.edit', $med->id) }}" class="p-2 text-slate-400 hover:text-brand-blue bg-white hover:bg-slate-50 border border-transparent hover:border-slate-200 rounded-lg transition-all shadow-sm" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" /></svg>
                                </a>
                                <form action="{{ route('superadmin.medicines.destroy', $med->id) }}" method="POST" class="inline-block confirm-form" data-action="menghapus obat {{ $med->name }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="p-2 text-slate-400 hover:text-red-500 bg-white hover:bg-red-50 border border-transparent hover:border-red-100 rounded-lg transition-all shadow-sm" title="Hapus">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-4 py-12 text-center text-slate-400">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mb-3 text-slate-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                <span class="font-medium text-slate-600">Belum ada data obat</span>
                            </div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        <div class="mt-6">
            {{ $medicines->links() }}
        </div>
    </div>
</x-superadmin-layout>
