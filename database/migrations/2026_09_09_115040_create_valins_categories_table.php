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
        // BARIS SAKTI: Hapus tabel lama jika sudah ada agar tidak bentrok
        Schema::dropIfExists('valins_categories');

        // Baru kemudian buat ulang tabelnya
        Schema::create('valins_categories', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori'); 
            $table->string('slug')->unique(); 
            $table->json('konfigurasi_kolom')->nullable(); 
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('valins_categories');
    }
};
