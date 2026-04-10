<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (! Schema::hasTable('pesertas') || ! Schema::hasTable('log_users')) {
            return;
        }

        if (Schema::hasColumn('pesertas', 'email')) {
            DB::statement('ALTER TABLE pesertas MODIFY email VARCHAR(255) NULL');
        }

        if (Schema::hasColumn('pesertas', 'jenis_kelamin')) {
            DB::statement('ALTER TABLE pesertas MODIFY jenis_kelamin VARCHAR(255) NULL');
        }

        $activeLogUsers = DB::table('log_users as lu')
            ->where('lu.status', 'active')
            ->whereNotExists(function ($query) {
                $query->select(DB::raw(1))
                    ->from('pesertas as p')
                    ->whereColumn('p.log_user_id', 'lu.id');
            })
            ->get();

        foreach ($activeLogUsers as $logUser) {
            DB::table('pesertas')->insert([
                'log_user_id' => $logUser->id,
                'email' => null,
                'jenis_kelamin' => null,
                'tanggal_lahir' => null,
                'alamat' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if (! Schema::hasTable('pesertas')) {
            return;
        }

        if (Schema::hasColumn('pesertas', 'email')) {
            DB::statement("
                UPDATE pesertas
                SET email = CONCAT('temp-', id, '@placeholder.local')
                WHERE email IS NULL
            ");

            DB::statement('ALTER TABLE pesertas MODIFY email VARCHAR(255) NOT NULL');
        }

        if (Schema::hasColumn('pesertas', 'jenis_kelamin')) {
            DB::statement("
                UPDATE pesertas
                SET jenis_kelamin = 'unknown'
                WHERE jenis_kelamin IS NULL
            ");

            DB::statement('ALTER TABLE pesertas MODIFY jenis_kelamin VARCHAR(255) NOT NULL');
        }
    }
};
