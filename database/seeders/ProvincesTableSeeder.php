<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProvincesTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('provinces')->insert([
            ['name' => 'Jawa Barat'],
            ['name' => 'Jawa Tengah'],
            ['name' => 'DKI Jakarta'],
        ]);
    }
}
