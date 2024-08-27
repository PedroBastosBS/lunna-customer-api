<?php
declare(strict_types=1);

namespace App\Modules\User\UseCases;

use Illuminate\Database\Eloquent\Collection;

interface ShowTopAdvertisersUseCase
{
    public function execute(): Collection;
}