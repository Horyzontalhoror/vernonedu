<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        /*
        |--------------------------------------------------------------------------
        | PROGRAMS
        |--------------------------------------------------------------------------
        */

        Schema::table('programs', function (Blueprint $table) {

            $table->string('image_url')
                ->nullable()
                ->after('deskripsi');

        });

        /*
        |--------------------------------------------------------------------------
        | SUB PROGRAMS
        |--------------------------------------------------------------------------
        */

        Schema::table('sub_programs', function (Blueprint $table) {

            $table->string('image_url')
                ->nullable()
                ->after('harga');

        });
    }

    public function down(): void
    {
        Schema::table('programs', function (Blueprint $table) {

            $table->dropColumn('image_url');

        });

        Schema::table('sub_programs', function (Blueprint $table) {

            $table->dropColumn('image_url');

        });
    }
};
