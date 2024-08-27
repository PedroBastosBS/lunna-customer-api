<?php

declare(strict_types=1);

namespace App\Modules\User\DTOS;

use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

final class UserDTO
{
    public null|string $name = null;
    public null|string $email = null;
    public null|string $phone = null;
    public null|string $document = null;
    public null|UploadedFile $profile = null;
    public null|int $type = null;
    public null|string $instagram = null;
    public null|string $facebook = null;
    public null|string $password = null;
    public null|string $passwordConfirmation = null;

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
        $dto->type = $request->get('type');
        $dto->instagram = $request->get('instagram');
        $dto->facebook = $request->get('facebook');
        $dto->password = $request->get('password');
        $dto->passwordConfirmation = $request->get('password_confirmation');
        return $dto;
    }
}