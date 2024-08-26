<?php
declare(strict_types=1);

namespace App\Modules\User\Repositories;

use App\Models\User;
use App\Modules\User\DTOS\UserDTO;

class UserRepository
{
    public function __construct(private User $user)
    {
        $this->user = $user;
    }
    public function save(UserDTO $user): User
    {
        return $this->user->create([
            ...get_object_vars($user),
            'password' => bcrypt($user->password),
            'confirm_password' => bcrypt($user->passwordConfirmation),
        ]);
    }

    public function completeRegistration(int $id, UserDTO $userDTO): User
    {
        $user = $this->user->find($id);
        $user->type = $userDTO->type;
        $user->document = $userDTO->document;
        $user->instagram = $userDTO->instagram;
        $user->facebook = $userDTO->facebook;
        $user->save();
        return $user;
    }
}