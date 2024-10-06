<?php

declare(strict_types=1);

namespace App\Modules\User\DTOS;

use App\Modules\User\Enums\UserTypeEnum;
use Illuminate\Http\Request;

final class BrokerDTO
{
    public int $userId;
    public ?int $realStateId = null;
    public ?string $creci = null;
    public ?string $description = null;

    public static function  new(
        int $userId,
        Request $request
    ) : self|null
    {
        if($request->get('type') === UserTypeEnum::CLIENT->value) {
            return null;
        }

        $dto = new self();
        $dto->realStateId = $request->get('realStateId');
        $dto->creci = $request->get('creci');
        $dto->description = $request->get('description');
        $dto->userId = $userId;
        return $dto;
    }
}