<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\BookRequest;
use App\Services\BookService;
use App\Traits\ApiResponse;
use App\Traits\ForbidsExtraFieldsTiny;
use Symfony\Component\HttpFoundation\JsonResponse;

class BookController extends Controller
{
    use ApiResponse;
    use ForbidsExtraFieldsTiny;

    protected BookService $bookService;

    public function __construct(BookService $bookService)
    {
        $this->bookService = $bookService;
    }

    public function index(): JsonResponse
    {
        try {
            $books = $this->bookService->getAll();
            return $this->success(
                $books->isEmpty() ? 'Sin libros para mostrar' : 'Libros obtenidos correctamente',
                200,
                $books
            );
        } catch (\Exception $e) {
            return $this->error('Error al obtener libros', 500, $e->getMessage());
        }
    }

    public function show($id): JsonResponse
    {
        try {
            $validator = $this->validatedIdRequest($id);
            if ($validator->fails()) {
                return $this->error('ID inválido o no existe', 422, $validator->errors());
            }

            $book = $this->bookService->find($id);
            if (!$book) {
                return $this->error('Libro no encontrado', 404);
            }

            return $this->success('Libro obtenido correctamente', 200, $book);
        } catch (\Exception $e) {
            return $this->error('Error al obtener libro', 500, $e->getMessage());
        }
    }

    public function store(BookRequest $request): JsonResponse
    {
        try {
            $book = $this->bookService->store($request->validated());
            return $this->success('Libro creado correctamente', 201, $book);
        } catch (\Exception $e) {
            return $this->error('Error al crear libro', 500, $e->getMessage());
        }
    }

    public function update(BookRequest $request, $id): JsonResponse
    {
        try {
            $validator = $this->validatedIdRequest($id);
            if ($validator->fails()) {
                return $this->error('ID inválido o no existe', 422, $validator->errors());
            }

            $book = $this->bookService->update($id, $request->validated());
            if (!$book) {
                return $this->error('Libro no encontrado o no se pudo actualizar', 404);
            }

            return $this->success('Libro actualizado correctamente', 200, $book);
        } catch (\Exception $e) {
            return $this->error('Error al actualizar libro', 500, $e->getMessage());
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $validator = $this->validatedIdRequest($id);
            if ($validator->fails()) {
                return $this->error('ID inválido o no existe', 422, $validator->errors());
            }

            $deleted = $this->bookService->delete($id);
            if (!$deleted) {
                return $this->error('No se pudo eliminar el libro', 404);
            }

            return $this->success('Libro eliminado correctamente', 200);
        } catch (\Exception $e) {
            return $this->error('Error al eliminar libro', 500, $e->getMessage());
        }
    }
}
