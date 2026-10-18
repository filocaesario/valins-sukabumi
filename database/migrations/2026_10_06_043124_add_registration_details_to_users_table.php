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
        Schema::table('users', function (Blueprint $table) {
            $table->string('nik')->nullable()->after('email');
            $table->string('emp_type')->nullable()->after('nik');
            $table->string('wa_phone')->nullable()->after('emp_type');
            $table->string('divisi')->nullable()->after('wa_phone');
            $table->string('homebase')->nullable()->after('divisi');
            $table->json('sto')->nullable()->after('homebase');
            $table->string('role')->nullable()->after('sto');
            $table->string('supervisor')->nullable()->after('role');
            $table->string('regu')->nullable()->after('supervisor');
            $table->string('mfa_method')->nullable()->after('regu');
            $table->string('telegram_id')->nullable()->after('mfa_method');
            $table->string('surat_tugas_path')->nullable()->after('telegram_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'nik',
                'emp_type',
                'wa_phone',
                'divisi',
                'homebase',
                'sto',
                'role',
                'supervisor',
                'regu',
                'mfa_method',
                'telegram_id',
                'surat_tugas_path',
            ]);
        });
    }
};
