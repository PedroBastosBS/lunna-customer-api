<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Requests\AuthRequest;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Exceptions\JWTException;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'refresh']]);
    }

    public function login(AuthRequest $request)
    {
        
        $credentials = $request->only(['email', 'password']);
        if (!$token = Auth::guard('api')->attempt($credentials)) {
            return response()->json(['message' => 'E-mail ou senha incorretos. Verifique suas credenciais e tente novamente.'], Response::HTTP_UNAUTHORIZED);
        }

        return $this->respondWithToken($token);
    }
    public function me()
    {
        $user = auth()->user();
        return response()->json([
            'id' => $user->id,
            'name' => $user->name,
            'email' => $user->email,
        ]);
    }

    public function refresh()
    {
        try {
            $newToken = JWTAuth::parseToken()->refresh();
            return $this->respondWithToken($newToken);
        } catch (JWTException $e) {
            return response()->json(['error' => 'Não foi possível atualizar o token.'],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Desconectado com sucesso.']);
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'accessToken' => $token,
            'tokenType' => 'Bearer',
            'expiresIn' => auth()->factory()->getTTL() * 60,
        ]);
    }
}