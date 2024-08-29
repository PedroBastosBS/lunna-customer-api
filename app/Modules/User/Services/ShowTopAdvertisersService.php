<?php
declare(strict_types=1);

namespace App\Modules\User\Services;

use App\Modules\User\DTOS\ShowTopAdvertisersPresentationDTO;
use App\Modules\User\Repositories\UserRepository;
use App\Modules\User\UseCases\ShowTopAdvertisersUseCase;
use Illuminate\Support\Collection;

class ShowTopAdvertisersService implements ShowTopAdvertisersUseCase
{
    public function __construct(
        private UserRepository $userRepository
    )
    {
        $this->userRepository = $userRepository;
    }
    public function execute(): Collection
    {
        return $this->userRepository->showTopAdvertisers()->map(function($advertise){
            return ShowTopAdvertisersPresentationDTO::new(
                    $advertise->name,
                    $advertise->profile,
                    $advertise->description,
                    $advertise->rating
            );
        });
    }
}

