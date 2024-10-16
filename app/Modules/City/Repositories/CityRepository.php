<?php

namespace App\Modules\City\Repositories;

use App\Models\City;
use Illuminate\Database\Eloquent\Collection;

class CityRepository
{
    private City $city;

    public function __construct(City $city)
    {
        $this->city = $city;
    }
    public function getCitiesByState(int $stateId): Collection
    {
        return $this->city->select(['id', 'name'])
                    ->where('state_id', $stateId)
                    ->orderBy('name', 'ASC')
                    ->get();
    }
}