<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Illuminate\Support\Facades\DB;

class MasterDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Kategori
        $categories = ['Antibiotik', 'Anti Radang', 'Anti Depresan', 'Analgesik', 'Antasida', 'Vitamin', 'Suplemen', 'Obat Batuk'];
        foreach ($categories as $cat) {
            DB::table('categories')->insert(['name' => $cat, 'created_at' => now(), 'updated_at' => now()]);
        }

        // Jenis Obat
        $types = ['Generik', 'Paten', 'Obat Bebas', 'Obat Keras', 'Obat Herbal (Jamu)', 'Obat Herbal Terstandar (OHT)', 'Narkotika'];
        foreach ($types as $type) {
            DB::table('types')->insert(['name' => $type, 'created_at' => now(), 'updated_at' => now()]);
        }

        // Unit
        $units = ['Sirup', 'Kapsul', 'Tablet', 'Semprot', 'Kaplet', 'Salep', 'Botol', 'Ampul', 'Sachet', 'Pcs'];
        foreach ($units as $unit) {
            DB::table('units')->insert(['name' => $unit, 'created_at' => now(), 'updated_at' => now()]);
        }

        // Penyimpanan (Inventory)
        $storages = [
            ['name' => 'Gudang Utama', 'description' => 'Penyimpanan stok skala besar'],
            ['name' => 'Etalase Depan', 'description' => 'Obat siap jual'],
            ['name' => 'Rak Obat Keras', 'description' => 'Penyimpanan khusus dengan pengawasan'],
            ['name' => 'Lemari Pendingin', 'description' => 'Untuk obat yang butuh suhu rendah'],
        ];
        foreach ($storages as $storage) {
            DB::table('storages')->insert([
                'name' => $storage['name'],
                'description' => $storage['description'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }

        // Pemasok (Suppliers)
        $suppliers = [
            ['name' => 'PT. Kimia Farma', 'contact' => '08111111111', 'address' => 'Jakarta'],
            ['name' => 'PT. Kalbe Farma', 'contact' => '08222222222', 'address' => 'Bandung'],
            ['name' => 'PT. Sanbe Farma', 'contact' => '08333333333', 'address' => 'Surabaya'],
        ];
        foreach ($suppliers as $sup) {
            DB::table('suppliers')->insert([
                'name' => $sup['name'],
                'contact_number' => $sup['contact'],
                'address' => $sup['address'],
                'created_at' => now(),
                'updated_at' => now()
            ]);
        }
    }
}
