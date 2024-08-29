<?php

declare(strict_types=1);

namespace App\Modules\User\DTOS;

use Illuminate\Http\Request;

final class AddressDTO
{
    public string $street;
    public string $district;
    public string $zipcode;
    public string $city;
    public string $state;
    public int $userId;
    public ?string $complement = null;

    public static function  new(
        int $userId,
        Request $request
    ) : self
    {
        $dto = new self();
        $dto->street = $request->get('street');
        $dto->district = $request->get('district');
        $dto->zipcode = $request->get('zipcode');
        $dto->city = $request->get('city');
        $dto->state = $request->get('state');
        $dto->userId = $userId;
        $dto->complement = $request->get('complement');
        return $dto;
    }
}