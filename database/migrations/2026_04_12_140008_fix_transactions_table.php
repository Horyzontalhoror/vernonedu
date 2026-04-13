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
        Schema::table('transactions', function (Blueprint $table) {

            // 🔥 ubah amount ke decimal
            $table->decimal('amount', 10, 2)->change();

            // 🔥 hapus kolom status lama (biar tidak double)
            $table->dropColumn('status');

            // 🔥 pastikan order_id unik
            $table->unique('order_id');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->integer('amount')->change();

            $table->string('status')->default('pending');

            $table->dropUnique(['order_id']);
        });
    }

};
