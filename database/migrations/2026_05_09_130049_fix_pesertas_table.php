<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {

            // hapus FK user_id
            if (Schema::hasColumn('pesertas', 'user_id')) {
                $table->dropForeign(['user_id']);
                $table->dropColumn('user_id');
            }

            // hapus FK sub_program_id
            if (Schema::hasColumn('pesertas', 'sub_program_id')) {
                $table->dropForeign(['sub_program_id']);
                $table->dropColumn('sub_program_id');
            }

        });
    }

    public function down(): void
    {
        Schema::table('pesertas', function (Blueprint $table) {

            $table->foreignId('user_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

            $table->foreignId('sub_program_id')
                ->nullable()
                ->constrained()
                ->nullOnDelete();

        });
    }
};
