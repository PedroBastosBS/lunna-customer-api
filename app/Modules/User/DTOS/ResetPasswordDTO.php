<?php

declare(strict_types=1);

namespace App\Modules\User\DTOS;

use Illuminate\Http\Request;

final class ResetPasswordDTO
{
    public string $email;
    public string $password;
    public string $passwordConfirmation;
    public string $token;

    public static function  new(
        Request $request
    ) : self
    {
        $dto = new self();
        $dto->email = $request->get('email');
        $dto->password = $request->get('password');
        $dto->passwordConfirmation = $request->get('password_confirmation');
        $dto->token = $request->get('token');
        return $dto;
    }
}