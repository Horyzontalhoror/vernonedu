<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tambah kolom email ke log_users
        Schema::table('log_users', function (Blueprint $table) {
            $table->string('email')->unique()->nullable()->after('no_telepon');
        });

        // 2. Pindahkan data email dari pesertas ke log_users
        DB::statement("
            UPDATE log_users lu
            JOIN pesertas p ON p.log_user_id = lu.id
            SET lu.email = p.email
            WHERE p.email IS NOT NULL
        ");

        // 3. (Opsional tapi direkomendasikan) ubah email jadi NOT NULL jika semua sudah terisi
        // Schema::table('log_users', function (Blueprint $table) {
        //     $table->string('email')->nullable(false)->change();
        // });

        // 4. Hapus kolom email dari pesertas
        Schema::table('pesertas', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->dropColumn('email');
        });
    }

    public function down(): void
    {
        // rollback

        // 1. Tambah kembali kolom email di pesertas
        Schema::table('pesertas', function (Blueprint $table) {
            $table->string('email')->unique()->nullable();
        });

        // 2. Kembalikan data dari log_users ke pesertas
        DB::statement("
            UPDATE pesertas p
            JOIN log_users lu ON p.log_user_id = lu.id
            SET p.email = lu.email
            WHERE lu.email IS NOT NULL
        ");

        // 3. Hapus email dari log_users
        Schema::table('log_users', function (Blueprint $table) {
            $table->dropUnique(['email']);
            $table->dropColumn('email');
        });
    }
};

