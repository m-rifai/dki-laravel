<?php

namespace Database\Seeders;

use App\Models\District;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class VillagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $districts = District::all();

        $villages = [

            [
                'name' => 'Cimanggu',
                'district_id' => $districts->where('name', 'Coblong')->first()->id,
            ],
            [
                'name' => 'Ciburial',
                'district_id' => $districts->where('name', 'Coblong')->first()->id,
            ],
            [
                'name' => 'Cibeunying Kidul',
                'district_id' => $districts->where('name', 'Coblong')->first()->id,
            ],

            [
                'name' => 'Kranji',
                'district_id' => $districts->where('name', 'Bekasi Timur')->first()->id,
            ],
            [
                'name' => 'Rawalumbu',
                'district_id' => $districts->where('name', 'Bekasi Timur')->first()->id,
            ],
            [
                'name' => 'Tanjung Barat',
                'district_id' => $districts->where('name', 'Bekasi Timur')->first()->id,
            ],

            [
                'name' => 'Semarang Selatan',
                'district_id' => $districts->where('name', 'Semarang Barat')->first()->id,
            ],
            [
                'name' => 'Panggung',
                'district_id' => $districts->where('name', 'Semarang Barat')->first()->id,
            ],
            [
                'name' => 'Tirtomoyo',
                'district_id' => $districts->where('name', 'Semarang Barat')->first()->id,
            ],

            [
                'name' => 'Kebon Baru',
                'district_id' => $districts->where('name', 'Gambir')->first()->id,
            ],
            [
                'name' => 'Gunung Sahari Utara',
                'district_id' => $districts->where('name', 'Gambir')->first()->id,
            ],
            [
                'name' => 'Taman',
                'district_id' => $districts->where('name', 'Gambir')->first()->id,
            ],

        ];

        foreach ($villages as $village) {
            DB::table('villages')->insert([
                'name' => $village['name'],
                'district_id' => $village['district_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
