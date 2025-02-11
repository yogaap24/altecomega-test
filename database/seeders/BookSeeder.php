<?php

namespace Database\Seeders;

use App\Models\Entity\Book;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Book::factory(1000)->create();
    }
}
