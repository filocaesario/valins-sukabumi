<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('valins_services', function (Blueprint $table) {
            // Menggunakan tipe 'text' agar bisa menampung kalimat panjang
            $table->text('update_progress')->nullable()->after('keterangan');
        });
    }

    public function down(): void
    {
        Schema::table('valins_services', function (Blueprint $table) {
            $table->dropColumn('update_progress');
        });
    }
};
