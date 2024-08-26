<?php
declare(strict_types=1);

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\DTOS\AddressDTO;
use App\Modules\User\DTOS\BrokerDTO;
use App\Modules\User\DTOS\UserDTO;
use App\Modules\User\Http\Requests\CompleteResgistrationRequest;
use App\Modules\User\Http\Requests\UserCreateRequest;
use App\Modules\User\Services\CompleteRegistrationService;
use App\Modules\User\Services\UserService;
use App\Modules\User\UseCases\CompleteRegistrationUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(private UserService $userService, private CompleteRegistrationUseCase $completeRegistrationUseCase)
    {
        $this->userService = $userService;
        $this->completeRegistrationUseCase = $completeRegistrationUseCase;
    }

    public function save(UserCreateRequest $request): JsonResponse
    {
        try {
            return response()->json($this->userService->save(UserDTO::new($request)), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function completeRegistration(CompleteResgistrationRequest $request, int $id): JsonResponse
    {
        try {
            return response()->json($this->completeRegistrationUseCase->execute(
                $id,
                UserDTO::new($request),
                AddressDTO::new($id, $request),
                BrokerDTO::new($id, $request)
            ), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}