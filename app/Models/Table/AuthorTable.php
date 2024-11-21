<?php

namespace App\Models\Table;

use App\Models\Entity\Author;

class AuthorTable extends Author
{
    public function books()
    {
        return $this->hasMany(BookTable::class, 'author_id');
    }
}
