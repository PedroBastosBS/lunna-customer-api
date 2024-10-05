<?php

namespace App\Modules\Auth\Mappers;

use App\Modules\Auth\DTOS\UserAuthDTO;
use App\Modules\User\ExternalServices\AwsS3Manager;

class AuthMapper
{
    public static function fromUserToUserAuthDTO(object $user): UserAuthDTO
    {
        $awsS3Manager = new AwsS3Manager();
        $dto = new UserAuthDTO();
        $dto->id = $user->id;
        $dto->name = $user->name;
        $dto->email = $user->email;
        $dto->profile = $awsS3Manager->preSignUrl($user->profile);
        $dto->registration_completed = $user->registration_completed;
        return $dto;
    }
}