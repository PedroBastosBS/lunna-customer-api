<?php

declare(strict_types=1);

namespace App\Modules\User\DTOS;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

final class UpdateFormatDataDTO
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $phone = null;
    public ?UploadedFile $profile = null;
    public ?int $type = null;
    public ?string $instagram = null;
    public ?string $facebook = null;

    public static function  new(
        Request $request,
    ) : self
    {
        $dto = new self();
        $dto->name = $request->input('name');
        $dto->email = $request->input('email');
        $dto->phone = $request->input('phone');
        $dto->profile = $request->file('profile');
        $dto->type = (int) $request->input('type');
        $dto->instagram = $request->input('instagram');
        $dto->facebook = $request->input('facebook');
        return $dto;
    }
}