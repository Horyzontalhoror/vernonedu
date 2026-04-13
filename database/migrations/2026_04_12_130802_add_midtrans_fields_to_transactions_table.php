<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('order_id')->nullable()->after('id');
            $table->integer('amount')->nullable()->after('order_id');
            $table->text('snap_token')->nullable()->after('amount');
            $table->string('payment_type', 50)->nullable()->after('snap_token');
            $table->string('transaction_status', 50)->nullable()->after('payment_type');
        });
    }

    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn([
                'order_id',
                'amount',
                'snap_token',
                'payment_type',
                'transaction_status',
            ]);
        });
    }
};
