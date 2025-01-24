<?php
declare(strict_types=1);

namespace App\Modules\User\Repositories;

use App\Models\User;
use App\Modules\User\DTOS\UpdateFormatDataDTO;
use App\Modules\User\DTOS\UserDTO;
use App\Modules\User\Enums\RegistrationCompletedEnum;
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
    public function findUserById(int $id): ?User
    {
        return $this->user->from('users as u')
                    ->leftJoin('brokers as br', 'u.id', '=', 'br.user_id')
                    ->select('u.name','u.facebook', 'u.document','br.description', 'br.rating', 'u.phone', 'u.email', 'u.instagram', 'u.profile', 'u.registration_completed')
                    ->where('u.id', $id)
                    ->first();
                
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
    public function profileFinalization(int $id): void
    {
        $this->user->where('id', $id)->update(['registration_completed' => RegistrationCompletedEnum::COMPLETED->value]);
    }
    public function update(int $id, UpdateFormatDataDTO $userDTO): void
    {
        $this->user->where('id', $id)->update([
            'name' => $userDTO->name,
           'email' => $userDTO->email,
           'phone' => $userDTO->phone,
           'profile' =>  $this->awsS3Manager->upload($userDTO->profile),
           'instagram' => $userDTO->instagram,
           'facebook' => $userDTO->facebook,
        ]);
    }
}