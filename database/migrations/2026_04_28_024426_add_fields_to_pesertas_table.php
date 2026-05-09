<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {

            // 🔥 Tambah kolom baru
            $table->unsignedBigInteger('user_id')->nullable()->after('id');
            $table->unsignedBigInteger('sub_program_id')->nullable()->after('user_id');
            $table->string('status')->default('pending')->after('sub_program_id');

            // 🔥 Foreign key (opsional tapi sangat disarankan)
            $table->foreign('user_id')->references('id')->on('users')->cascadeOnDelete();
            $table->foreign('sub_program_id')->references('id')->on('sub_programs')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {

            // 🔥 drop foreign key dulu
            $table->dropForeign(['user_id']);
            $table->dropForeign(['sub_program_id']);

            // 🔥 drop kolom
            $table->dropColumn(['user_id', 'sub_program_id', 'status']);
        });
    }
};
