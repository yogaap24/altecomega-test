<?php

namespace Database\Factories\Table;

use App\Models\Entity\Author;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entity\Book>
 */
class BookTableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        $authors = Author::all();
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'publish_date' => $this->faker->date,
            'author_id' => $authors->random()->id,
        ];
    }
}
