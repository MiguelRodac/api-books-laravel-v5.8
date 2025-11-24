<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Book extends Model
{
    /**
     * The table associated with the model.
     */
    protected $table = 'books';

    /**
     * The primary key associated with the table.
     */
    protected $primaryKey = 'id_book';

    protected $fillable = [
        'title',
        'description',
        'id_author',
        'published_at',
        'available',
    ];

    /**
     * Get the author that owns the book.
     */
    public function author()
    {
        return $this->belongsTo(Author::class, 'id_author', 'id_author');
    }
}
