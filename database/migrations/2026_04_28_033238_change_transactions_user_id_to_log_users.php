<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            // 🔥 drop foreign key lama (ke users)
            $table->dropForeign(['user_id']);

            // 🔥 (opsional) kalau mau rename kolom biar lebih jelas
            // $table->renameColumn('user_id', 'log_user_id');

            // 🔥 tambahkan foreign key baru ke log_users
            $table->foreign('user_id')
                ->references('id')
                ->on('log_users')
                ->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {

            // 🔥 drop FK ke log_users
            $table->dropForeign(['user_id']);

            // 🔥 balikin ke users
            $table->foreign('user_id')
                ->references('id')
                ->on('users')
                ->cascadeOnDelete();
        });
    }
};
