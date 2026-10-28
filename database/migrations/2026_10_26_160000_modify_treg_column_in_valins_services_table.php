<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Ubah tipe kolom treg menjadi VARCHAR(50) NULLABLE agar dapat menyimpan format "TREG 2", "TREG 3", atau nama wilayah regional tanpa error
        DB::statement("ALTER TABLE valins_services MODIFY treg VARCHAR(50) NULL DEFAULT NULL");
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        DB::statement("ALTER TABLE valins_services MODIFY treg INT NOT NULL DEFAULT 3");
    }
};
