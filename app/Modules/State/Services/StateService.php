<?php

declare(strict_types=1);

namespace App\Modules\State\Services;

use App\Modules\State\Repositories\StateRepository;
use Illuminate\Database\Eloquent\Collection;

class StateService
{
    private StateRepository $stateRepository;

    public function __construct(StateRepository $stateRepository)
    {
        $this->stateRepository = $stateRepository;
    }
    public function getStatesActive(): Collection
    {
        return $this->stateRepository->getStatesActive();
    }
}