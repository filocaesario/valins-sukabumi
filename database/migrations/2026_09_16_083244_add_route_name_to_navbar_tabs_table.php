<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('navbar_tabs', function (Blueprint $table) {
            $table->string('route_name')->nullable()->after('slug');
        });

        // Daftarkan tab bawaan ke database jika belum ada
        $now = now();
        $defaultTabs = [
            [
                'nama_tab'   => 'Valins Services',
                'slug'       => 'valins-services',
                'route_name' => 'valins.index',
                'deskripsi'  => 'Manajemen Data Valins Telkom Akses',
                'urutan'     => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'nama_tab'   => 'Monitoring GPON',
                'slug'       => 'monitoring-gpon',
                'route_name' => 'gpon.index',
                'deskripsi'  => 'Halaman Monitoring GPON',
                'urutan'     => 2,
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($defaultTabs as $tab) {
            if (!DB::table('navbar_tabs')->where('slug', $tab['slug'])->exists()) {
                DB::table('navbar_tabs')->insert($tab);
            }
        }
    }

    public function down(): void
    {
        Schema::table('navbar_tabs', function (Blueprint $table) {
            $table->dropColumn('route_name');
        });
    }
};