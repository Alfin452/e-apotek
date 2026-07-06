<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Using DB::statement to modify ENUM in MySQL safely without doctrine/dbal issues
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'apoteker', 'kasir', 'pegawai', 'pasien') DEFAULT 'pasien'");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('superadmin', 'pegawai', 'pasien') DEFAULT 'pasien'");
    }
};
