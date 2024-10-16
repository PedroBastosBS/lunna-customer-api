<?php

declare(strict_types=1);

namespace App\Modules\City\Services;

use App\Modules\City\Repositories\CityRepository;
use Illuminate\Database\Eloquent\Collection;

class CityService
{
    private CityRepository $cityRepository;

    public function __construct(CityRepository $cityRepository)
    {
        $this->cityRepository = $cityRepository;
    }
    public function getCitiesByState(int $stateId): Collection
    {
        return $this->cityRepository->getCitiesByState($stateId);
    }
}