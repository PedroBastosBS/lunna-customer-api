<?php
declare(strict_types=1);

namespace App\Modules\User\Services;

use App\Modules\User\DTOS\AddressDTO;
use App\Modules\User\DTOS\BrokerDTO;
use App\Modules\User\DTOS\UserDTO;
use App\Modules\User\Enums\UserTypeEnum;
use App\Modules\User\Repositories\AddressRepository;
use App\Modules\User\Repositories\BrokerRepository;
use App\Modules\User\Repositories\UserRepository;
use App\Modules\User\UseCases\CompleteRegistrationUseCase;

class CompleteRegistrationService implements CompleteRegistrationUseCase
{
    public function __construct(
        private UserRepository $userRepository, 
        private AddressRepository $addressRepository,
        private BrokerRepository $brokerRepository,
    )
    {
        $this->userRepository = $userRepository;
        $this->addressRepository = $addressRepository;
        $this->brokerRepository = $brokerRepository;
    }
    public function execute(
        int $id, 
        UserDTO $user, 
        AddressDTO $addressDTO, 
        null|BrokerDTO $brokerDTO
    ): string 
    {
        $user = $this->userRepository->completeRegistration($id, $user);
        $this->addressRepository->save($addressDTO);
        if($user->type === UserTypeEnum::ADVERTISER->value) {
            $this->brokerRepository->save($brokerDTO);
        }

        return "Cadastro finalizado com sucesso !";
    }
}

