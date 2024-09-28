<?php

declare(strict_types=1);

namespace App\Modules\User\Enums;

enum RegistrationCompletedEnum: string
{
    case INCOMPLETED = "incompleted";
    case COMPLETED = "completed";
    case MESSAGE_REGISTRATION_COMPLETED = "Cadastro finalizado com sucesso !";
}