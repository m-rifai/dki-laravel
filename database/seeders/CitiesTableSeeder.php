<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CitiesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $provinces = Province::all();

        $cities = [
            [
                'name' => 'Bandung',
                'province_id' => $provinces->where('name', 'Jawa Barat')->first()->id,
            ],
            [
                'name' => 'Bekasi',
                'province_id' => $provinces->where('name', 'Jawa Barat')->first()->id,
            ],
            [
                'name' => 'Bogor',
                'province_id' => $provinces->where('name', 'Jawa Barat')->first()->id,
            ],
            [
                'name' => 'Semarang',
                'province_id' => $provinces->where('name', 'Jawa Tengah')->first()->id,
            ],
            [
                'name' => 'Solo (Surakarta)',
                'province_id' => $provinces->where('name', 'Jawa Tengah')->first()->id,
            ],
            [
                'name' => 'Magelang',
                'province_id' => $provinces->where('name', 'Jawa Tengah')->first()->id,
            ],
            [
                'name' => 'Jakarta Pusat',
                'province_id' => $provinces->where('name', 'DKI Jakarta')->first()->id,
            ],
            [
                'name' => 'Jakarta Selatan',
                'province_id' => $provinces->where('name', 'DKI Jakarta')->first()->id,
            ],
            [
                'name' => 'Jakarta Barat',
                'province_id' => $provinces->where('name', 'DKI Jakarta')->first()->id,
            ],

        ];

        foreach ($cities as $city) {
            DB::table('cities')->insert([
                'name' => $city['name'],
                'province_id' => $city['province_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
