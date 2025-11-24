<?php

namespace App\Services;

use App\Jobs\UpdateAuthorBooksCount;
use App\Models\Book;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class BookService
{
    /**
     * Obtener todos los libros
     */
    public function getAll(): Collection
    {
        return Book::with('author')->get();
    }

    /**
     * Obtener un libro por ID
     */
    public function find(int $id): Book
    {
        $book = Book::with('author')->find($id);

        if (!$book) {
            throw new ModelNotFoundException("Book not found");
        }

        return $book;
    }

    /**
     * Crear un nuevo libro
     */
    public function store(array $data): Book
    {
        $book = Book::create($data);

        UpdateAuthorBooksCount::dispatch($book->id_author);

        return $book;
    }

    /**
     * Actualizar un libro existente
     */
    public function update(int $id, array $data): Book
    {
        $book = $this->find($id);

        if (!$book) {
            throw new ModelNotFoundException("Book not found");
        }

        $book->update($data);

        return $book;
    }

    /**
     * Eliminar un libro
     */
    public function delete(int $id): bool
    {
        $book = $this->find($id);

        if (!$book) {
            throw new ModelNotFoundException("Book not found");
        }

        return $book->delete();
    }
}
