<?php
declare(strict_types=1);

namespace App\Modules\User\Services;

use App\Modules\User\Repositories\BrokerRepository;

class BrokerRatingService
{
    public function __construct(
        private BrokerRepository $brokerRepository,
    )
    {
        $this->brokerRepository = $brokerRepository;
    }
    public function execute(
        int $userId,
        string $rating
    ): void 
    {
        $this->brokerRepository->rating($userId, $rating);
    }
}

