<?php
declare(strict_types=1);

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\DTOS\AddressDTO;
use App\Modules\User\DTOS\BrokerDTO;
use App\Modules\User\DTOS\ResetPasswordDTO;
use App\Modules\User\DTOS\UpdateFormatDataDTO;
use App\Modules\User\DTOS\UserDTO;
use App\Modules\User\Exceptions\PasswordNotMatchException;
use App\Modules\User\Exceptions\TokenExpirationOrInvalidException;
use App\Modules\User\Exceptions\UserNotFoundException;
use App\Modules\User\Http\Requests\CompleteResgistrationRequest;
use App\Modules\User\Http\Requests\PasswordResetRequest;
use App\Modules\User\Http\Requests\RatingUpdateRequest;
use App\Modules\User\Http\Requests\UserCreateRequest;
use App\Modules\User\Services\BrokerRatingService;
use App\Modules\User\Services\UserService;
use App\Modules\User\UseCases\CompleteRegistrationUseCase;
use App\Modules\User\UseCases\ShowTopAdvertisersUseCase;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class UserController extends Controller
{
    public function __construct(
        private UserService $userService,
        private CompleteRegistrationUseCase $completeRegistrationUseCase,
        private ShowTopAdvertisersUseCase $showTopAdvertisersUseCase,
        private BrokerRatingService $brokerRatingService,
        )
    {
        $this->userService = $userService;
        $this->completeRegistrationUseCase = $completeRegistrationUseCase;
        $this->showTopAdvertisersUseCase = $showTopAdvertisersUseCase;
        $this->brokerRatingService = $brokerRatingService;
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
    public function passwordReset(PasswordResetRequest $request): JsonResponse
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

    public function findUserById(mixed $id): JsonResponse
    {
        try {
            return response()->json($this->userService->findUserById($id), Response::HTTP_OK);
        } catch(UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function ratingUpdate(RatingUpdateRequest $request, int $userId): JsonResponse
    {
        try {
            $this->brokerRatingService->execute($userId, $request->get('rating'));
            return response()->json(null, Response::HTTP_OK);
        } catch(UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
    public function findAdvertisersByProperty(int $userId): JsonResponse
    {
        try {
            return response()->json($this->userService->findAdvertisersByProperty($userId), Response::HTTP_OK);
        } catch(UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }
    public function update(Request $request, int $id): JsonResponse
    {
        try {
            return response()->json($this->userService->update($id, UpdateFormatDataDTO::new($request),$request->get('description')), Response::HTTP_OK);
        } catch(UserNotFoundException $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_NOT_FOUND);
        }
    }

    public function healthCheck() {
        try {
            DB::connection()->getPdo();
            return response()->json([
                'database' => 'Connected',
                'status' => 'healthy'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Application online',
                'database' => 'Not connected',
                'error' => $e->getMessage(),
                'status' => 'unhealthy'
            ], 503);
        }
    }
}
