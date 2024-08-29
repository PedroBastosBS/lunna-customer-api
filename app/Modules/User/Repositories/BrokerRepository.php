<?php
declare(strict_types=1);

namespace App\Modules\User\Repositories;

use App\Models\Broker;
use App\Modules\User\DTOS\BrokerDTO;

class BrokerRepository
{
    public function __construct(private Broker $broker)
    {
        $this->$broker = $broker;
    }
    public function save(BrokerDTO $brokerDTO): void
    {
         $this->broker->create([
            'user_id' => $brokerDTO->userId,
            'creci' => $brokerDTO->creci,
            'description' => $brokerDTO->description,
        ]);
    }

    public function findBrokerByUserId(int $userId): ?Broker
    {
        return $this->broker->where('user_id', $userId)->first();
    }
}