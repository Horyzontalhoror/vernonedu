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
        Schema::create('pembayarans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('peserta_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_program_id')->constrained()->cascadeOnDelete();
            $table->decimal('jumlah', 10, 2);
            $table->enum('status', ['pending', 'lunas', 'gagal'])->default('pending');
            $table->date('tanggal')->nullable();
            $table->string('metode')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pembayarans');
    }
};
