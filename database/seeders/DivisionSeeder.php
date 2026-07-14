<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DivisionSeeder extends Seeder
{
    public function run(): void
    {
        $divisions = [
            ['nama_divisi' => 'UKL UPL'],
            ['nama_divisi' => 'AMDAL'],
            ['nama_divisi' => 'PERTEK BMAL'],
            ['nama_divisi' => 'PERTEK EMISI'],
            ['nama_divisi' => 'RINTEK LB3'],
            ['nama_divisi' => 'RKAB'],
            ['nama_divisi' => 'PKKPRL'],
            ['nama_divisi' => 'PEMANTAUAN'],
        ];

        DB::table('divisions')->insert($divisions);
    }
}