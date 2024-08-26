<?php
declare(strict_types=1);

namespace App\Modules\User\UseCases;

use App\Models\User;
use App\Modules\User\DTOS\AddressDTO;
use App\Modules\User\DTOS\BrokerDTO;
use App\Modules\User\DTOS\UserDTO;

interface CompleteRegistrationUseCase
{
    public function execute(int $id, UserDTO $user, AddressDTO $addressDTO, null|BrokerDTO $brokerDTO): string;
}