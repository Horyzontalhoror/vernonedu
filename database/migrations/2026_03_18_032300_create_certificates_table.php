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
        Schema::create('certificates', function (Blueprint $table) {
            $table->id();

            $table->foreignId('peserta_id')->constrained()->cascadeOnDelete();
            $table->foreignId('sub_program_id')->constrained()->cascadeOnDelete();

            $table->string('file_path')->nullable();
            $table->string('file_url')->nullable();

            $table->string('status')->default('draft');

            $table->timestamp('issued_at')->nullable();

            $table->timestamps();

            $table->unique(['peserta_id', 'sub_program_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('certificates');
    }
};
