<?php

declare(strict_types=1);

namespace App\Modules\User\DTOS;

final class DataProfileDTO
{
    public string $name;
    public string $email;
    public string $phone;    
    public string $document;
    public ?string $description = null;
    public string $registration_completed;
    public ?string $rating = null;
    public ?string $profile = null;
    public ?string $instagram = null;
    public ?string $facebook = null;
}