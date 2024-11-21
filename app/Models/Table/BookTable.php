<?php

namespace App\Models\Table;

use App\Models\Entity\Book;

class BookTable extends Book
{

    public function getAuthorBookAttribute()
    {
        return [
            'id' => $this->author->id,
            'name' => $this->author->name
        ];
    }

    public function author()
    {
        return $this->belongsTo(AuthorTable::class, 'author_id');
    }
}
