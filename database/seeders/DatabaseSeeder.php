<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'Superadmin User',
            'email' => 'superadmin@apotek.com',
            'role' => 'superadmin',
            'password' => bcrypt('password'),
        ]);

        $this->call([
            MasterDataSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'Pegawai User',
            'email' => 'pegawai@apotek.com',
            'role' => 'pegawai',
            'password' => bcrypt('password'),
        ]);

        User::factory()->create([
            'name' => 'Pasien User',
            'email' => 'pasien@apotek.com',
            'role' => 'pasien',
            'password' => bcrypt('password'),
        ]);
    }
}
