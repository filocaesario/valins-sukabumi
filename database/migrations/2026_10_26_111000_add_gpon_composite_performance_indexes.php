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
        Schema::table('master_gpons', function (Blueprint $table) {
            // Composite Index untuk Index-Only Scan saat filter STO & distinct/sort Node ID
            $table->index(['sto', 'node_id'], 'master_gpons_sto_node_id_idx');
            
            // Composite Index untuk pemanggilan port data per node & slot
            $table->index(['sto', 'node_id', 'slot'], 'master_gpons_sto_node_slot_idx');

            // Index tambahan untuk pencarian node_ip yang cepat
            if (Schema::hasColumn('master_gpons', 'node_ip')) {
                $table->index('node_ip', 'master_gpons_node_ip_idx');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('master_gpons', function (Blueprint $table) {
            $table->dropIndex('master_gpons_sto_node_id_idx');
            $table->dropIndex('master_gpons_sto_node_slot_idx');
            if (Schema::hasColumn('master_gpons', 'node_ip')) {
                $table->dropIndex('master_gpons_node_ip_idx');
            }
        });
    }
};
