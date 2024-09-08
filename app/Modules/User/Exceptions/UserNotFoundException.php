<?php

declare(strict_types=1);

namespace App\Modules\User\Exceptions;

final class UserNotFoundException extends \DomainException
{
    public static function new(): self
    {
        return new self(sprintf('Não foi possível encontrar um usuário com o e-mail informado. Por favor, verifique o e-mail e tente novamente.'));
    }
}