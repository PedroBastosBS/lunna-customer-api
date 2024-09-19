<?php
declare(strict_types=1);

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\DTOS\AddressDTO;
use App\Modules\User\DTOS\BrokerDTO;
use App\Modules\User\DTOS\ResetPasswordDTO;
use App\Modules\User\DTOS\UserDTO;
use App\Modules\User\Exceptions\PasswordNotMatchException;
use App\Modules\User\Exceptions\TokenExpirationOrInvalidException;
use App\Modules\User\Exceptions\UserNotFoundException;
use App\Modules\User\Http\Requests\CompleteResgistrationRequest;
use App\Modules\User\Http\Requests\PasswordResetRequest;
use App\Modules\User\Http\Requests\UserCreateRequest;
use App\Modules\User\Services\UserService;
use App\Modules\User\UseCases\CompleteRegistrationUseCase;
use App\Modules\User\UseCases\ShowTopAdvertisersUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
class UserController extends Controller
{
    public function __construct(
        private UserService $userService, 
        private CompleteRegistrationUseCase $completeRegistrationUseCase,
        private ShowTopAdvertisersUseCase $showTopAdvertisersUseCase
        )
    {
        $this->userService = $userService;
        $this->completeRegistrationUseCase = $completeRegistrationUseCase;
        $this->showTopAdvertisersUseCase = $showTopAdvertisersUseCase;

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
    public function showTopAdvertisers(): JsonResponse
    {
        try {
            return response()->json($this->showTopAdvertisersUseCase->execute(), Response::HTTP_OK);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function resetPasswordNotification(PasswordResetRequest $request): JsonResponse
    {
        try {
            return response()->json(['message' => $this->userService->resetPasswordNotification($request->get('email'))], Response::HTTP_OK);
        } catch(UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
    public function passwordReset(PasswordResetRequest $request) 
    {
        try {
            return response()->json($this->userService->resetPassword(ResetPasswordDTO::new($request)), Response::HTTP_OK);
        } catch(UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        } catch(TokenExpirationOrInvalidException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch(PasswordNotMatchException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_BAD_REQUEST);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}