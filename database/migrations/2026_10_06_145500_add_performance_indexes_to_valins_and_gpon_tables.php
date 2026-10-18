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
        Schema::table('valins_services', function (Blueprint $table) {
            if (Schema::hasColumn('valins_services', 'kategori')) {
                $table->index('kategori', 'valins_services_kategori_index');
            }
            if (Schema::hasColumn('valins_services', 'odp_name')) {
                $table->index('odp_name', 'valins_services_odp_name_index');
            }
            if (Schema::hasColumn('valins_services', 'keterangan')) {
                $table->index('keterangan', 'valins_services_keterangan_index');
            }
            if (Schema::hasColumn('valins_services', 'sto')) {
                $table->index('sto', 'valins_services_sto_index');
            }
            if (Schema::hasColumn('valins_services', 'locked_by')) {
                $table->index('locked_by', 'valins_services_locked_by_index');
            }
        });

        Schema::table('master_gpons', function (Blueprint $table) {
            if (Schema::hasColumn('master_gpons', 'sto')) {
                $table->index('sto', 'master_gpons_sto_index');
            }
            if (Schema::hasColumn('master_gpons', 'node_id')) {
                $table->index('node_id', 'master_gpons_node_id_index');
            }
            if (Schema::hasColumn('master_gpons', 'slot')) {
                $table->index('slot', 'master_gpons_slot_index');
            }
            if (Schema::hasColumn('master_gpons', 'port')) {
                $table->index('port', 'master_gpons_port_index');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('valins_services', function (Blueprint $table) {
            $table->dropIndex('valins_services_kategori_index');
            $table->dropIndex('valins_services_odp_name_index');
            $table->dropIndex('valins_services_keterangan_index');
            $table->dropIndex('valins_services_sto_index');
            $table->dropIndex('valins_services_locked_by_index');
        });

        Schema::table('master_gpons', function (Blueprint $table) {
            $table->dropIndex('master_gpons_sto_index');
            $table->dropIndex('master_gpons_node_id_index');
            $table->dropIndex('master_gpons_slot_index');
            $table->dropIndex('master_gpons_port_index');
        });
    }
};
