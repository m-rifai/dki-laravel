<?php

namespace Database\Seeders;

use App\Models\City;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DistrictsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $cities = City::all();

        $districts = [

            [
                'name' => 'Coblong',
                'city_id' => $cities->where('name', 'Bandung')->first()->id,
            ],
            [
                'name' => 'Cidadap',
                'city_id' => $cities->where('name', 'Bandung')->first()->id,
            ],
            [
                'name' => 'Cibeunying Kaler',
                'city_id' => $cities->where('name', 'Bandung')->first()->id,
            ],

            [
                'name' => 'Bekasi Barat',
                'city_id' => $cities->where('name', 'Bekasi')->first()->id,
            ],
            [
                'name' => 'Bekasi Timur',
                'city_id' => $cities->where('name', 'Bekasi')->first()->id,
            ],
            [
                'name' => 'Bekasi Utara',
                'city_id' => $cities->where('name', 'Bekasi')->first()->id,
            ],

            [
                'name' => 'Semarang Barat',
                'city_id' => $cities->where('name', 'Semarang')->first()->id,
            ],
            [
                'name' => 'Semarang Timur',
                'city_id' => $cities->where('name', 'Semarang')->first()->id,
            ],
            [
                'name' => 'Semarang Selatan',
                'city_id' => $cities->where('name', 'Semarang')->first()->id,
            ],

            [
                'name' => 'Gambir',
                'city_id' => $cities->where('name', 'Jakarta Pusat')->first()->id,
            ],
            [
                'name' => 'Tanah Abang',
                'city_id' => $cities->where('name', 'Jakarta Pusat')->first()->id,
            ],
            [
                'name' => 'Cempaka Putih',
                'city_id' => $cities->where('name', 'Jakarta Pusat')->first()->id,
            ],

        ];

        foreach ($districts as $district) {
            DB::table('districts')->insert([
                'name' => $district['name'],
                'city_id' => $district['city_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
