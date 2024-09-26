<?php

namespace App\Modules\Auth\Mappers;

use App\Modules\Auth\DTOS\UserAuthDTO;

class AuthMapper
{
    public static function fromUserToUserAuthDTO(object $user): UserAuthDTO
    {
        $dto = new UserAuthDTO();
        $dto->id = $user->id;
        $dto->name = $user->name;
        $dto->email = $user->email;
        return $dto;
    }
}