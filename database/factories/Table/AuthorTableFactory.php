<?php

namespace Database\Factories\Table;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Entity\Author>
 */
class AuthorTableFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'bio' => $this->faker->paragraph,
            'birth_date' => $this->faker->date,
        ];
    }
}
