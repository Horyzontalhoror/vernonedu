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
        Schema::create('enrollments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_program_id')->constrained()->cascadeOnDelete();
            $table->date('tanggal_daftar')->nullable();
            $table->enum('status', ['aktif', 'selesai', 'keluar'])->default('aktif');
            $table->timestamps();

            $table->unique(['peserta_id', 'sub_program_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('enrollments');
    }
};
