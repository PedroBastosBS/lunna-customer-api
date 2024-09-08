<?php

declare(strict_types=1);

namespace App\Modules\User\Exceptions;

final class TokenExpirationOrInvalidException extends \DomainException
{
    public static function new(): self
    {
        return new self(sprintf('Token inválido ou expirado.'));
    }
}