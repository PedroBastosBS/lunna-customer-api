<?php
declare(strict_types=1);

namespace App\Modules\User\Http\Controllers;

use App\Modules\User\DTOS\UserDTO;
use App\Modules\User\Http\Requests\UserCreateRequest;
use App\Modules\User\Services\UserService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class UserController extends Controller
{
    public function __construct(private UserService $userService)
    {
        $this->userService = $userService;
    }

    public function save(UserCreateRequest $request): JsonResponse
    {
        try {
            return response()->json($this->userService->save(UserDTO::new($request)), Response::HTTP_CREATED);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

}