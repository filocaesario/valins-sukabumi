<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('valins_services', function (Blueprint $table) {
            // Menambahkan kolom kategori setelah kolom witel
            $table->string('kategori')->nullable()->after('witel');
        });
    }

    public function down(): void
    {
        Schema::table('valins_services', function (Blueprint $table) {
            $table->dropColumn('kategori');
        });
    }
};
