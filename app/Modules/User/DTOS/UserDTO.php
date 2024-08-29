<?php

declare(strict_types=1);

namespace App\Modules\User\DTOS;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

final class UserDTO
{
    public ?string $name = null;
    public ?string $email = null;
    public ?string $phone = null;
    public ?string $document = null;
    public ?UploadedFile $profile = null;
    public ?int $type = null;
    public ?string $instagram = null;
    public ?string $facebook = null;
    public ?string $password = null;
    public ?string $passwordConfirmation = null;

    public static function  new(
        Request $request
    ) : self
    {
        $dto = new self();
        $dto->name = $request->get('name');
        $dto->email = $request->get('email');
        $dto->phone = $request->get('phone');
        $dto->document = $request->get('document');
        $dto->profile = $request->file('profile');
        $dto->type = (int) $request->get('type');
        $dto->instagram = $request->get('instagram');
        $dto->facebook = $request->get('facebook');
        $dto->password = $request->get('password');
        $dto->passwordConfirmation = $request->get('password_confirmation');
        return $dto;
    }
}