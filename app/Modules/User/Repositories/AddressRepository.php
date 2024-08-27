<?php
declare(strict_types=1);

namespace App\Modules\User\Repositories;

use App\Models\Address;
use App\Modules\User\DTOS\AddressDTO;

class AddressRepository
{
    public function __construct(private Address $address)
    {
        $this->$address = $address;
    }
    public function save(AddressDTO $addressDTO): void
    {
         $this->address->create([
            'street' => $addressDTO->street,
            'district' => $addressDTO->district,
            'zipcode' => $addressDTO->zipcode,
            'city' => $addressDTO->city,
            'state' => $addressDTO->state,
            'complement' => $addressDTO->complement,
            'user_id' => $addressDTO->userId,
        ]);
    }

    public function findAddressByUserId(int $userId): null|Address
    {
        return $this->address->where('user_id', $userId)->first();
    }
}