<?php
declare(strict_types=1);

namespace App\Modules\User\Services;

use App\Models\User;
use App\Modules\User\DTOS\UserDTO;
use App\Modules\User\Repositories\UserRepository;

class UserService
{
    public function __construct(private UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    public function save(UserDTO $user): User
    {
        return $this->userRepository->save($user);
    }
}

