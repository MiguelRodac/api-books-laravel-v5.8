<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\AuthorRequest;
use App\Services\AuthorService;
use App\Traits\ApiResponse;
use Symfony\Component\HttpFoundation\JsonResponse;

class AuthorController extends Controller
{
    use ApiResponse;

    protected AuthorService $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->authorService = $authorService;
    }

    public function index(): JsonResponse
    {
        try {
            $authors = $this->authorService->getAll();
            return $this->success(
                $authors->isEmpty() ? 'Sin autores para mostrar' : 'Autores obtenidos correctamente',
                200,
                $authors
            );
        } catch (\Exception $e) {
            return $this->error('Error al obtener autores', 500, $e->getMessage());
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $author = $this->authorService->find($id);
            return $this->success('Autor obtenido correctamente', 200, $author);
        } catch (\Exception $e) {
            return $this->error('Autor no encontrado', 404, $e->getMessage());
        }
    }

    public function store(AuthorRequest $request): JsonResponse
    {
        try {
            $author = $this->authorService->store($request->validated());
            return $this->success('Autor creado correctamente', 201, $author);
        } catch (\Exception $e) {
            return $this->error('Error al crear autor', 500, $e->getMessage());
        }
    }

    public function update(AuthorRequest $request, $id): JsonResponse
    {
        try {
            $author = $this->authorService->update($id, $request->validated());
            return $this->success('Autor actualizado correctamente', 200, $author);
        } catch (\Exception $e) {
            return $this->error('Error al actualizar autor', 404, $e->getMessage());
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $deleted = $this->authorService->delete($id);
            return $this->success('Autor eliminado correctamente', 200, $deleted);
        } catch (\Exception $e) {
            return $this->error('Error al eliminar autor', 404, $e->getMessage());
        }
    }
}
