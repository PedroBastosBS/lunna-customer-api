<?php

namespace App\Modules\Auth\DTOS;

class UserAuthDTO
{
    public int $id;
    public string $name;
    public string $email;
    public ?string $profile = null;
    public string $registration_completed;
}