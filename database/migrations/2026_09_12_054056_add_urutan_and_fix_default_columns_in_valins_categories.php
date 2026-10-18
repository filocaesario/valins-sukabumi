<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\ValinsCategory;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom urutan jika belum ada
        if (!Schema::hasColumn('valins_categories', 'urutan')) {
            Schema::table('valins_categories', function (Blueprint $table) {
                $table->integer('urutan')->default(0)->after('slug');
            });
        }

        // Susunan 19 Kolom Standar Valins
        $kolomStandar = [
            ['nama' => 'TREG', 'tipe' => 'text'],
            ['nama' => 'WITEL', 'tipe' => 'text'],
            ['nama' => 'STO', 'tipe' => 'text'],
            ['nama' => 'ODP NAME', 'tipe' => 'text'],
            ['nama' => 'PANEL ODP', 'tipe' => 'text'],
            ['nama' => 'PORT ODP', 'tipe' => 'text'],
            ['nama' => 'VALINS ID', 'tipe' => 'number'],
            ['nama' => 'NODE ID', 'tipe' => 'text'],
            ['nama' => 'NODE IP', 'tipe' => 'text'],
            ['nama' => 'SLOT', 'tipe' => 'number'],
            ['nama' => 'PORT', 'tipe' => 'number'],
            ['nama' => 'ONU SN', 'tipe' => 'text'],
            ['nama' => 'NO INET VALINS', 'tipe' => 'number'],
            ['nama' => 'SIP 1 VALINS', 'tipe' => 'number'],
            ['nama' => 'SIP 2 VALINS', 'tipe' => 'number'],
            ['nama' => 'SID', 'tipe' => 'text'],
            ['nama' => 'KETERANGAN', 'tipe' => 'text'],
            ['nama' => 'TANGGAL', 'tipe' => 'date'],
            ['nama' => 'PIC', 'tipe' => 'text'],
        ];

        // 2. Isi kolom yang masih kosong (0 Kolom) & beri nomor urut awal
        $kategoriList = ValinsCategory::all();
        $urutan = 1;

        foreach ($kategoriList as $kat) {
            $updateData = ['urutan' => $urutan++];

            // Jika konfigurasi kolom kosong / null, otomatis isi 19 kolom default
            if (empty($kat->konfigurasi_kolom) || count($kat->konfigurasi_kolom) === 0) {
                $updateData['konfigurasi_kolom'] = $kolomStandar;
            }

            $kat->update($updateData);
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('valins_categories', 'urutan')) {
            Schema::table('valins_categories', function (Blueprint $table) {
                $table->dropColumn('urutan');
            });
        }
    }
};