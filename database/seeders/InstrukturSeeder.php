<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class InstrukturSeeder extends Seeder
{
    public function run(): void
    {

        DB::table('instrukturs')->insert([
            [
                'nama' => 'Olivia',
                'no_telepon' => '081234567890',
                'jabatan' => 'Mentor Mindset & Character Building',
                'alamat' => 'Sukun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Erick',
                'no_telepon' => '081234567891',
                'jabatan' => 'Mentor Entrepreneurship',
                'alamat' => 'Sukun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Ninda',
                'no_telepon' => '081234567892',
                'jabatan' => 'Mentor Culinary',
                'alamat' => 'Sukun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'nama' => 'Tanti',
                'no_telepon' => '081234567893',
                'jabatan' => 'Mentor Communication',
                'alamat' => 'Sukun',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
