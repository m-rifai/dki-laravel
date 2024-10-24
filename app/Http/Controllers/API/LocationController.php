<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\CityResource;
use App\Http\Resources\DistrictResource;
use App\Http\Resources\ProvinceResource;
use App\Http\Resources\VillageResource;
use App\Models\City;
use App\Models\District;
use App\Models\Province;
use App\Models\Village;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Cache;

class LocationController extends Controller
{
    /**
     * Get All Provinces
     *
     * Returns a list of all provinces.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function getProvinces()
    {
        $provinces = Cache::remember('provinces', 60 * 60, function () {
            return Province::all();
        });

        return ProvinceResource::collection($provinces);
    }

    /**
     * Get Cities by Province
     *
     * @param  \App\Models\Province  $province
     * @return \Illuminate\Http\JsonResponse
     */
    public function getCities(Province $province)
    {
        $cacheKey = "cities_province_{$province->id}";
        $cities = Cache::remember($cacheKey, 60 * 60, function () use ($province) {
            return $province->cities;
        });

        return CityResource::collection($cities);
    }

    /**
     * Get Districts by City
     *
     * @param  \App\Models\City  $city
     * @return \Illuminate\Http\JsonResponse
     */
    public function getDistricts(City $city)
    {
        $cacheKey = "districts_city_{$city->id}";
        $districts = Cache::remember($cacheKey, 60 * 60, function () use ($city) {
            return $city->districts;
        });

        return DistrictResource::collection($districts);
    }

    /**
     * Get Villages by District
     *
     * @param  \App\Models\District  $district
     * @return \Illuminate\Http\JsonResponse
     */
    public function getVillages(District $district)
    {
        $cacheKey = "villages_district_{$district->id}";
        $villages = Cache::remember($cacheKey, 60 * 60, function () use ($district) {
            return $district->villages;
        });

        return VillageResource::collection($villages);
    }
}
