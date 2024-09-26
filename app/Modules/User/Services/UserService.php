<?php
declare(strict_types=1);

namespace App\Modules\User\Services;

use App\Mail\PasswordResetMail;
use App\Models\User;
use App\Modules\User\DTOS\ResetPasswordDTO;
use App\Modules\User\DTOS\UserDTO;
use App\Modules\User\Enums\UserInteractionMessagesEnum;
use App\Modules\User\Exceptions\PasswordNotMatchException;
use App\Modules\User\Exceptions\TokenExpirationOrInvalidException;
use App\Modules\User\Exceptions\UserNotFoundException;
use App\Modules\User\Mappers\UserMapper;
use App\Modules\User\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UserService
{
    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function save(UserDTO $user): UserMapper
    {
        $user = $this->userRepository->save($user);
        return UserMapper::toPresentation($user);
    }

    public function resetPasswordNotification(string $email): string
    {
        $user = $this->userRepository->findUserByEmail($email);
        $token = Password::createToken($user);
        $url = env('APP_WEB').'/home?open-password-recovery=true&token='.$token.'&email='.$user->email;
        if(empty($user)) {
           throw UserNotFoundException::new();
        }
        Mail::to($email)
            ->send(new PasswordResetMail( $user->name, $url));
        return UserInteractionMessagesEnum::SEND_EMAIL_SUCCESS->value;
    }
    public function resetPassword(ResetPasswordDTO $resetPasswordDTO): string
    {
        if ($resetPasswordDTO->password!==$resetPasswordDTO->passwordConfirmation) {
            throw PasswordNotMatchException::new();
        }
        $user = $this->userRepository->findUserByEmail($resetPasswordDTO->email);

        if(empty($user)) {
           throw UserNotFoundException::new();
        }
       $resetPassword = Password::reset(
        [
            'email' => $resetPasswordDTO->email,
            'password' => $resetPasswordDTO->password,
            'password_confirmation' => $resetPasswordDTO->passwordConfirmation,
            'token' => $resetPasswordDTO->token,
        ],
        function ($user, $password) {
            $user->forceFill([
                'password' => bcrypt($password)
            ])->save();
            }
        );
        if($resetPassword != Password::PASSWORD_RESET) {
            throw TokenExpirationOrInvalidException::new();
        }
        return UserInteractionMessagesEnum::PASSWORD_SUCCESS_RESET->value;
    }

    public function findUserById(int $id): ?User
    {
        $user = $this->userRepository->findUserById($id);
        if(empty($user)) {
            throw new Exception('Usuário não foi encontrado.');
        }
        return $user;
    }
}