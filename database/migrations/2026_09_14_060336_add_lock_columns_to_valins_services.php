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
        $table->string('locked_by')->nullable()->after('pic');
        $table->timestamp('locked_at')->nullable()->after('locked_by');
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('valins_services', function (Blueprint $table) {
            //
        });
    }
};
