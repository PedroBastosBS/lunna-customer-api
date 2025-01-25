<?php

declare(strict_types=1);

namespace App\Modules\User\DTOS;

use App\Modules\User\ExternalServices\AwsS3Manager;

final class ShowTopAdvertisersPresentationDTO
{
    public int $userId;
    public string $name;
    public ?string $profile;
    public string $description;
    public ?string  $rating;

    public static function  new(
        int $userId,
        string $name,
        ?string $profile,
        string $description,
        ?string $rating,
    ) : self|null
    {
        $awsS3Manager = new AwsS3Manager();
        $dto = new self();
        $dto->userId = $userId;
        $dto->name = $name;
        $dto->profile = $awsS3Manager->preSignUrl($profile);
        $dto->description = $description;
        $dto->rating = $rating;
        return $dto;
    }
}