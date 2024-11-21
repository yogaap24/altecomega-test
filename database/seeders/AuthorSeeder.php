<?php

namespace Database\Seeders;

use App\Models\Entity\Author;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Author::factory(100)->create();
    }
}
