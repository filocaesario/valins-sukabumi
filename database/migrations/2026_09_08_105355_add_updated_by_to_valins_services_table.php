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
    // Ganti 'valins_services' dengan nama tabel yang benar jika masih salah
    Schema::table('valins_services', function (Blueprint $table) {
        $table->string('updated_by')->nullable()->after('pic');
    });
}

public function down()
{
    Schema::table('valins_services', function (Blueprint $table) {
        $table->dropColumn('updated_by');
    });
}
};
