<?php
declare(strict_types=1);

namespace App\Modules\User\Services;

use App\Mail\PasswordResetMail;
use App\Models\User;
use App\Modules\User\DTOS\DataProfileDTO;
use App\Modules\User\DTOS\PropertyAdvertisersDTO;
use App\Modules\User\DTOS\ResetPasswordDTO;
use App\Modules\User\DTOS\UpdateFormatDataDTO;
use App\Modules\User\DTOS\UserDTO;
use App\Modules\User\Enums\UserInteractionMessagesEnum;
use App\Modules\User\Enums\UserTypeEnum;
use App\Modules\User\Exceptions\PasswordNotMatchException;
use App\Modules\User\Exceptions\TokenExpirationOrInvalidException;
use App\Modules\User\Exceptions\UserNotFoundException;
use App\Modules\User\Mappers\UserMapper;
use App\Modules\User\Repositories\UserRepository;
use App\Modules\User\Repositories\BrokerRepository;
use Exception;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Password;

class UserService
{
    public function __construct(private UserRepository $userRepository, BrokerRepository $brokerRepository)
    {
        $this->userRepository = $userRepository;
        $this->brokerRepository = $brokerRepository;

    }
    public function save(UserDTO $user): UserMapper
    {
        $user = $this->userRepository->save($user);
        return UserMapper::toPresentation($user);
    }

    public function resetPasswordNotification(string $email)
    {
        $user = $this->userRepository->findUserByEmail($email);
        if(empty($user)) {
            throw UserNotFoundException::new();
        }
        $token = Password::createToken($user);
        $url = env('APP_WEB').'/site?open-password-recovery=true&token='.$token.'&email='.$user->email;

        return Mail::to('fabi.tavares1@gmail.com')
            ->send(new PasswordResetMail( $user->name, $url))
            ->getMessageId();
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

    public function findUserById($id): ?DataProfileDTO
    {
        $user = $this->userRepository->findUserById($id);
        if(empty($user)) {
            throw new Exception('Usuário não foi encontrado.');
        }
        return UserMapper::toDataProfilePresentation($user);
    }
    public function findAdvertisersByProperty(int $id): ?PropertyAdvertisersDTO
    {
        $user = $this->userRepository->findUserById($id);
        if(empty($user)) {
            throw new Exception('Usuário não foi encontrado.');
        }

        return PropertyAdvertisersDTO::new($user);
    }

    public function update(int $id, UpdateFormatDataDTO $user, ?string $description): void
    {
        if($user->type == UserTypeEnum::CLIENT->value) {
            $this->userRepository->update($id, $user);
        } else {
            $this->userRepository->update($id, $user);
            $this->brokerRepository->update($id, $description);
        }
    }
}
