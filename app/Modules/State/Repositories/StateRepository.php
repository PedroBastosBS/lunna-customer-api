<?php

namespace App\Modules\State\Repositories;

use App\Models\State;
use App\Modules\State\Enums\StatusEnum;
use Illuminate\Database\Eloquent\Collection;

class StateRepository
{
    private State $state;

    public function __construct(State $state)
    {
        $this->state = $state;
    }
    public function getStatesActive(): Collection
    {
        return $this->state->select(['id', 'name', 'uf'])
                    ->where('status', StatusEnum::ACTIVE->value)
                    ->get();
    }
}