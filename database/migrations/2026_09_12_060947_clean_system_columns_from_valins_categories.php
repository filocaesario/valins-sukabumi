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
        $categories = \App\Models\ValinsCategory::all();

        foreach ($categories as $cat) {
            if (!empty($cat->konfigurasi_kolom)) {
                // Buang KETERANGAN, TANGGAL, dan PIC dari kolom JSON karena sudah ada kolom khususnya di database
                $cleaned = collect($cat->konfigurasi_kolom)->reject(function ($col) {
                    return in_array(strtoupper(trim($col['nama'] ?? '')), ['KETERANGAN', 'TANGGAL', 'PIC']);
                })->values()->all();

                $cat->update(['konfigurasi_kolom' => $cleaned]);
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('valins_categories', function (Blueprint $table) {
            //
        });
    }
};
