<?php

declare(strict_types=1);

namespace App\Modules\User\Mappers;

use App\Models\User;
use App\Modules\User\DTOS\DataProfileDTO;
use App\Modules\User\ExternalServices\AwsS3Manager;

final class UserMapper
{
    public int $id;
    public string $name;
    public string $email;

    public static function toPresentation(object $user) : object
    {
        $dto = new self();
        $dto->id = $user->id;
        $dto->name = $user->name;
        $dto->email = $user->email;
        return $dto;
    }

    public static function toDataProfilePresentation(User $user) : DataProfileDTO
    {
        $awsS3Manager = new AwsS3Manager();
        $dto = new DataProfileDTO();
        $dto->name = $user->name;
        $dto->email = $user->email;
        $dto->phone = $user->phone;
        $dto->description = $user->description;
        $dto->rating = $user->rating;
        $dto->profile = $awsS3Manager->preSignUrl($user->profile);
        return $dto;
    }
}