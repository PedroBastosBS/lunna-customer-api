<?php

declare(strict_types=1);

namespace App\Modules\User\Mappers;

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
}