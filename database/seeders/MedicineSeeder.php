<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Medicine;
use Carbon\Carbon;

class MedicineSeeder extends Seeder
{
    public function run()
    {
        $medicines = [
            [
                'name' => 'Amoxicillin 500mg',
                'storage_id' => 1, // Rak A
                'stock' => 150,
                'min_stock' => 50,
                'type_id' => 1, // Generik
                'unit_id' => 1, // Strip
                'category_id' => 2, // Antibiotik
                'expired_date' => Carbon::now()->addMonths(18),
                'description' => 'Antibiotik untuk infeksi bakteri.',
                'purchase_price' => 5000,
                'selling_price' => 7500,
                'supplier_id' => 1,
            ],
            [
                'name' => 'Paracetamol 500mg',
                'storage_id' => 1,
                'stock' => 500,
                'min_stock' => 100,
                'type_id' => 1, 
                'unit_id' => 1,
                'category_id' => 1, // Obat Bebas
                'expired_date' => Carbon::now()->addMonths(24),
                'description' => 'Obat penurun panas dan pereda nyeri.',
                'purchase_price' => 2000,
                'selling_price' => 3500,
                'supplier_id' => 2,
            ],
            [
                'name' => 'Vitamin C 1000mg',
                'storage_id' => 2,
                'stock' => 200,
                'min_stock' => 30,
                'type_id' => 2, // Paten
                'unit_id' => 3, // Botol
                'category_id' => 3, // Vitamin
                'expired_date' => Carbon::now()->addMonths(12),
                'description' => 'Suplemen daya tahan tubuh.',
                'purchase_price' => 35000,
                'selling_price' => 45000,
                'supplier_id' => 3,
            ],
            [
                'name' => 'OBH Combi Plus',
                'storage_id' => 2,
                'stock' => 80,
                'min_stock' => 20,
                'type_id' => 2,
                'unit_id' => 3,
                'category_id' => 1,
                'expired_date' => Carbon::now()->addMonths(6),
                'description' => 'Obat batuk berdahak.',
                'purchase_price' => 15000,
                'selling_price' => 18500,
                'supplier_id' => 1,
            ],
            [
                'name' => 'Promag Tablet',
                'storage_id' => 1,
                'stock' => 300,
                'min_stock' => 50,
                'type_id' => 1,
                'unit_id' => 1,
                'category_id' => 1,
                'expired_date' => Carbon::now()->addMonths(36),
                'description' => 'Obat sakit maag dan asam lambung.',
                'purchase_price' => 7000,
                'selling_price' => 9500,
                'supplier_id' => 2,
            ],
            [
                'name' => 'Ibuprofen 400mg',
                'storage_id' => 3,
                'stock' => 120,
                'min_stock' => 40,
                'type_id' => 1,
                'unit_id' => 1,
                'category_id' => 2, // Obat Keras / Resep (assuming)
                'expired_date' => Carbon::now()->addMonths(20),
                'description' => 'Obat anti-inflamasi dan pereda nyeri.',
                'purchase_price' => 4500,
                'selling_price' => 6000,
                'supplier_id' => 1,
            ],
            [
                'name' => 'Bodrex Extra',
                'storage_id' => 1,
                'stock' => 250,
                'min_stock' => 50,
                'type_id' => 2,
                'unit_id' => 1,
                'category_id' => 1,
                'expired_date' => Carbon::now()->addMonths(15),
                'description' => 'Obat sakit kepala membandel.',
                'purchase_price' => 4000,
                'selling_price' => 5500,
                'supplier_id' => 3,
            ],
            [
                'name' => 'Betadine 30ml',
                'storage_id' => 3,
                'stock' => 60,
                'min_stock' => 15,
                'type_id' => 2,
                'unit_id' => 3, // Botol
                'category_id' => 4, // Alat/Lainnya
                'expired_date' => Carbon::now()->addMonths(48),
                'description' => 'Antiseptik untuk luka luar.',
                'purchase_price' => 12000,
                'selling_price' => 15000,
                'supplier_id' => 2,
            ],
            [
                'name' => 'Insto Reguler',
                'storage_id' => 2,
                'stock' => 90,
                'min_stock' => 25,
                'type_id' => 2,
                'unit_id' => 3, // Botol / Tetes
                'category_id' => 1,
                'expired_date' => Carbon::now()->addMonths(10),
                'description' => 'Obat tetes mata merah.',
                'purchase_price' => 13500,
                'selling_price' => 16500,
                'supplier_id' => 1,
            ]
        ];

        foreach ($medicines as $medicine) {
            Medicine::create($medicine);
        }
    }
}
