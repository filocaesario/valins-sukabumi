<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('valins_services', function (Blueprint $table) {
            // Relasi ke tabel kategori (opsional, karena data lama belum punya relasi)
            $table->foreignId('valins_category_id')->nullable()->constrained('valins_categories')->nullOnDelete();
            
            // Kolom JSON penampung data dari custom kolom
            $table->json('dynamic_data')->nullable()->after('keterangan'); 
        });
    }

    public function down()
    {
        Schema::table('valins_services', function (Blueprint $table) {
            $table->dropForeign(['valins_category_id']);
            $table->dropColumn(['valins_category_id', 'dynamic_data']);
        });
    }
};
