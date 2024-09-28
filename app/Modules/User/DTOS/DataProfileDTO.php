<?php

declare(strict_types=1);

namespace App\Modules\User\DTOS;

final class DataProfileDTO
{
    public string $name;
    public string $email;
    public string $phone;
    public string $description;
    public string $registration_completed;
    public ?string $rating = null;
    public ?string $profile = null;

}