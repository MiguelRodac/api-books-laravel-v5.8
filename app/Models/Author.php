<?php

namespace App\Models;

use App\Models\Book;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Author extends Model
{
    /**
     * Table name
     */
    protected $table = 'authors';

    /**
     * Primary key
     */
    protected $primaryKey = 'id_author';

    /**
     * Campos que se pueden asignar masivamente.
     */
    protected $fillable = [
        'name',
        'email',
        'bio',
    ];

    /**
     * Relación: un autor puede tener muchos libros.
     */
    public function books(): HasMany
    {
        return $this->hasMany(Book::class, 'id_author', 'id_author');
    }
}
