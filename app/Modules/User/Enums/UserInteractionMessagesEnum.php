<?php

declare(strict_types=1);

namespace App\Modules\User\Enums;

enum UserInteractionMessagesEnum: string
{
    case SEND_EMAIL_SUCCESS = "Um e-mail com o link para a recuperação de senha foi enviado com sucesso. Verifique sua caixa de entrada e siga as instruções para redefinir sua senha. Se você não receber o e-mail em alguns minutos, verifique também a pasta de spam ou lixo eletrônico.";
    case PASSWORD_SUCCESS_RESET = "Senha redefinida com sucesso.";
}