<?php
declare(strict_types=1);

namespace App\Modules\User\Repositories;

use App\Models\User;
use App\Modules\User\DTOS\UserDTO;
use App\Modules\User\Enums\UserTypeEnum;
use App\Modules\User\ExternalServices\AwsS3Manager;
use Illuminate\Database\Eloquent\Collection;

class UserRepository
{

    public function __construct(private User $user, private AwsS3Manager $awsS3Manager)
    {
        $this->user = $user;
        $this->awsS3Manager = $awsS3Manager;
    }
    public function save(UserDTO $user): User
    {
        return $this->user->create([
            ...get_object_vars($user),
            'password' => bcrypt($user->password),
            'confirm_password' => bcrypt($user->passwordConfirmation),
        ]);
    }
    public function findUserByEmail(string $email): ?User
    {
        return $this->user->where('email', $email)->first();
    }
    public function completeRegistration(int $id, UserDTO $userDTO): User
    {
        $user = $this->user->find($id);
        $user->type = $userDTO->type;
        $user->document = preg_replace('/\D/', '', $userDTO->document);
        $user->instagram = $userDTO->instagram;
        $user->facebook = $userDTO->facebook;
        $user->profile = $this->awsS3Manager->upload($userDTO->profile);
        $user->save();
        return $user;
    }
    public function showTopAdvertisers(): Collection
    {
        return $this->user->from('users as u')
            ->join('brokers as b', 'b.user_id', 'u.id')
            ->where('u.type', UserTypeEnum::ADVERTISER->value)
            ->select(['u.name as name', 'u.profile', 'b.description', 'b.rating'])
            ->orderBy('b.rating', 'DESC')
            ->limit(6)
            ->get();
    }
}