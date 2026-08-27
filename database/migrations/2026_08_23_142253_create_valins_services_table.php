<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('valins_services', function (Blueprint $table) {
            $table->id();
            $table->string('witel')->default('SUKABUMI');
            $table->string('sto', 10);
            $table->string('odp_name');
            $table->string('panel_o')->nullable();
            $table->string('port_od')->nullable();
            $table->string('valins_id')->nullable()->index(); // Di-index untuk pencarian cepat
            $table->string('node_id')->nullable();
            $table->string('node_ip', 50)->nullable()->index();
            $table->integer('slot')->nullable();
            $table->integer('port')->nullable();
            $table->string('onu_sn', 50)->nullable()->index(); // Di-index untuk pencarian cepat
            $table->string('no_inet_valins', 50)->nullable()->index();
            $table->string('sip1_valins', 50)->nullable();
            $table->string('sip2_valins', 50)->nullable();
            $table->string('sid', 50)->nullable();
            $table->string('keterangan')->nullable(); // DONE, OTB, DISCONNECTED, dll
            $table->date('tanggal')->nullable();
            $table->string('pic')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('valins_services');
    }
};
