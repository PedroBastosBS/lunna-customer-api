<?php

declare(strict_types=1);

namespace App\Modules\User\Exceptions;

final class PasswordNotMatchException extends \DomainException
{
    public static function new(): self
    {
        return new self(sprintf('As senhas não coincidem. Verifique e tente novamente.'));
    }
}