<?php

declare(strict_types=1);

namespace App\Modules\User\DTOS;

use App\Models\User;
use App\Modules\User\ExternalServices\AwsS3Manager;
use Illuminate\Http\UploadedFile;

final class PropertyAdvertisersDTO
{
    public ?string $name = null;
    public ?string $profile = null;
    public ?string $whatsAppAcountLink = null;
    public ?string $rating = null;

    public static function  new(
        User $user
    ) : self
    {
        $awsS3Manager = new AwsS3Manager();
        $dto = new self();
        $dto->profile = $awsS3Manager->preSignUrl($user->profile);
        $dto->name = $user->name;
        $dto->description = $user->description;
        $dto->whatsAppAcountLink = $user->phone ? "https://wa.me/" . $user->phone : null;
        $dto->rating = $user->rating;
        return $dto;
    }
}