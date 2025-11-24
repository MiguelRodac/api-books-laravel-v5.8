<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Services\UserService;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends Controller
{
    use ApiResponse;

    protected UserService $userService;

    public function __construct(UserService $userService)
    {
        $this->middleware('jwt.auth');
        $this->userService = $userService;
    }

    public function index(): JsonResponse
    {
        try {
            $users = $this->userService->getAll();
            return $this->success(
                $users->isEmpty() ? 'Sin usuarios para mostrar' : 'Usuarios obtenidos correctamente',
                200,
                $users
            );
        } catch (\Exception $e) {
            return $this->error('Error al obtener usuarios', 500, $e->getMessage());
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $user = $this->userService->find($id);

            if (!$user) return $this->error('Usuario no encontrado', 404);

            return $this->success('Usuario obtenido correctamente', 200, $user);
        } catch (\Exception $e) {
            return $this->error('Usuario no encontrado', 404, $e->getMessage());
        }
    }

    public function store(UserRequest $request): JsonResponse
    {
        try {
            $user = $this->userService->store($request->validated());

            if (!$user) return $this->error('Error al crear usuario', 500);

            return $this->success('Usuario creado correctamente', 201, $user);
        } catch (\Exception $e) {
            return $this->error('Error al crear usuario', 500, $e->getMessage());
        }
    }

    public function update(UserRequest $request, $id): JsonResponse
    {
        try {
            $user = $this->userService->update($id, $request->validated());

            if (!$user) return $this->error('Error al actualizar usuario', 404);

            return $this->success('Usuario actualizado correctamente', 200, $user);
        } catch (\Exception $e) {
            return $this->error('Error al actualizar usuario', 404, $e->getMessage());
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->userService->delete($id);

            if (!$deleted) return $this->error('Error al eliminar usuario', 404);

            return $this->success('Usuario eliminado correctamente', 200, $deleted);
        } catch (\Exception $e) {
            return $this->error('Error al eliminar usuario', 500, $e->getMessage());
        }
    }
}
