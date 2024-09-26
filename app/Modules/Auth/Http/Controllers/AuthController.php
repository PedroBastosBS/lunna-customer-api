<?php

namespace App\Modules\Auth\Http\Controllers;

use App\Http\Requests\AuthRequest;
use App\Modules\Auth\Mappers\AuthMapper;
use Exception;
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
        try{ 
            $user = auth()->user();
        if(empty($user)){
            throw new Exception('Nenhum usuário esta autenticado!');
        }
        return response()->json(AuthMapper::fromUserToUserAuthDTO($user), Response::HTTP_OK);
        } catch (Exception $e) {
            return response()->json(['error' => $e->getMessage()],Response::HTTP_INTERNAL_SERVER_ERROR);
        }
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