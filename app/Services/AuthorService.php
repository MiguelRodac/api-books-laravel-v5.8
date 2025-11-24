<?php

namespace App\Services;

use App\Models\Author;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class AuthorService
{
    /**
     * Obtener todos los autores
     */
    public function getAll(): Collection
    {
        return Author::with('books')->get();
    }

    /**
     * Obtener un autor por ID
     */
    public function find(int $id): Author
    {
        $author = Author::with('books')->find($id);

        if (!$author) {
            throw new ModelNotFoundException("Author not found");
        }

        return $author;
    }

    /**
     * Crear un nuevo autor
     */
    public function store(array $data): Author
    {
        return Author::create($data);
    }

    /**
     * Actualizar un autor existente
     */
    public function update(int $id, array $data): Author
    {
        $author = $this->find($id);

        $author->update($data);

        return $author;
    }

    /**
     * Eliminar un autor
     */
    public function delete(int $id): bool
    {
        $author = $this->find($id);

        return $author->delete();
    }
}
