<?php
declare(strict_types=1);

namespace App\Modules\User\UseCases;

use Illuminate\Support\Collection;
interface ShowTopAdvertisersUseCase
{
    public function execute(): Collection;
}