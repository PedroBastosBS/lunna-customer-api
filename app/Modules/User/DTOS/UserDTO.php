<?php

declare(strict_types=1);

namespace App\Modules\User\DTOS;

use Illuminate\Http\Request;

final class UserDTO
{
    public string $name;
    public string $email;
    public string $phone;
    public null|string $document = null;
    public string $password;
    public string $passwordConfirmation;

    public static function  new(
        Request $request
    ) : self
    {
        $dto = new self();
        $dto->name = $request->get('name');
        $dto->email = $request->get('email');
        $dto->phone = $request->get('phone');
        $dto->document = $request->get('document');
        $dto->password = $request->get('password');
        $dto->passwordConfirmation =$request->get('password_confirmation');
        return $dto;
    }
}