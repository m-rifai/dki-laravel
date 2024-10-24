<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class JobsTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('jobs')->insert([
            ['name' => 'PNS'],
            ['name' => 'Swasta'],
            ['name' => 'Wiraswasta'],
            ['name' => 'Pelajar/Mahasiswa'],
            ['name' => 'Lainnya'],
        ]);
    }
}
