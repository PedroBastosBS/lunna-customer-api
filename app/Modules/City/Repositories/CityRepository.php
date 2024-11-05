<?php

namespace App\Modules\City\Repositories;

use App\Models\Address;
use App\Models\City;
use App\Modules\State\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Collection;

class CityRepository
{
    private City $city;
    private Address $address;

    public function __construct(City $city, Address $address)
    {
        $this->city = $city;
        $this->address = $address;
    }
    public function getCitiesByState(int $stateId): Collection
    {
        return $this->city->select(['id', 'name'])
                    ->where('state_id', $stateId)
                    ->where('status', StatusEnum::ACTIVE->value)
                    ->orderBy('name', 'ASC')
                    ->get();
    }
    public function getDistrictsByCityId(int $cityId): Collection
    {
        return $this->address->select(['id', 'district'])
                    ->where('city_id', $cityId)
                    ->distinct()
                    ->get();
    }
}