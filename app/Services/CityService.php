<?php


namespace App\Services;


use App\Models\City;

class CityService
{
    /**
     * @param string $npId
     * @param string $city
     *
     * @return City
     */
    public function getOrCreate(string $npId, string $city): City
    {
        /** @var City $city */
        $city =  City::query()->firstOrCreate(['np_id' => $npId], [
            'np_id' => $npId,
            'name'  => $city
        ]);

        return $city;
    }
}
