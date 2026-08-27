<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('valins_services', function (Blueprint $table) {
            // TREG biasanya berisi angka 3 untuk wilayah Jawa Barat
            $table->integer('treg')->default(3)->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('valins_services', function (Blueprint $table) {
            $table->dropColumn('treg');
        });
    }
};
