<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('master_gpons', function (Blueprint $table) {
            $table->id();

            // Nama Tab Excel
            $table->string('sto', 10)->nullable()->comment('Contoh: BGL, CBD, CBE');

            // Baris 1: ID Logical Device
            $table->string('id_logical_device')->nullable()->comment('Contoh: 75794, 250425161');

            // Baris 2: Node ID & Node IP
            $table->string('node_id')->comment('Contoh: GPON00-D3-BGL-2');
            $table->string('node_ip')->nullable()->comment('Contoh: 172.29.137.4');

            // Baris 3: Type GPON
            $table->string('type_gpon')->nullable()->comment('Contoh: HUAWEI, FIBERHOME, ZTE');

            // Baris 4 ke bawah: Slot & Detail Port
            $table->string('slot')->nullable()->comment('Contoh: SLOT 1, SLOT 2');
            $table->string('port')->nullable()->comment('Contoh: GPON - 85927-361271 - GPON_OLT:0');

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('master_gpons');
    }
};
