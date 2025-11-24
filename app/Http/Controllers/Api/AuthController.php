<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\JsonResponse;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{
    use ApiResponse;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('auth:api')->except(['register', 'login']);
        $this->userService = $userService;
    }

    public function register(UserRequest $request): JsonResponse
    {
        $user = $this->userService->store($request->validated());

        if (!$user) return $this->error('Error al crear usuario', 500);

        $token = JWTAuth::fromUser($user);

        return $this->success('Usuario registrado correctamente', 201, [
            'token' => $token,
            'user'  => $user,
        ]);
    }

    public function login(Request $request): JsonResponse
    {
        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        $guard = auth('api');

        $credentials = $request->only(['email', 'password']);

        if (!$token = JWTAuth::attempt($credentials)) {
            return $this->error('Credenciales inválidas', 401);
        }

        return $this->success('Inicio de sesión correcto', 200, [
            'token'      => $token,
            'token_type' => 'bearer',
            'expires_in' => $guard->factory()->getTTL() * 60,
            'user'       => auth('api')->user(),
        ]);
    }

    public function me(): JsonResponse
    {
        return $this->success('Usuario autenticado', 200, auth('api')->user());
    }

    public function logout(): JsonResponse
    {
        JWTAuth::invalidate(JWTAuth::getToken());
        return $this->success('Sesión cerrada correctamente', 200);
    }

    public function refresh(): JsonResponse
    {
        /** @var \Tymon\JWTAuth\JWTGuard $guard */
        $guard = auth('api');

        $newToken = JWTAuth::refresh(JWTAuth::getToken());

        return $this->success('Token refrescado correctamente', 200, [
            'token'      => $newToken,
            'token_type' => 'bearer',
            'expires_in' => $guard->factory()->getTTL() * 60,
        ]);
    }
}
