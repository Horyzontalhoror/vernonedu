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
        //
        Schema::table('pesertas', function (Blueprint $table) {
            // tambah relasi dulu
            $table->foreignId('log_user_id')->nullable()->after('id');

            // hapus kolom lama
            $table->dropColumn(['nama', 'no_telepon']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::table('pesertas', function (Blueprint $table) {
            // kembalikan kolom lama
            $table->string('nama')->after('id');
            $table->string('no_telepon')->after('nama');

            // hapus relasi
            $table->dropForeign(['log_user_id']);
            $table->dropColumn('log_user_id');
        });
    }
};
