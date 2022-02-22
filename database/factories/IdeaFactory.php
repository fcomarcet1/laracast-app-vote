<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Idea>
 */
class IdeaFactory extends Factory
{

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //'user_id' => User::factory(),
            'user_id' => $this->faker->numberBetween(1, 20),
            'category_id' => $this->faker->numberBetween(1, 4), //'category_id' => Category::factory(),
            'status_id' => $this->faker->numberBetween(1, 5),
            'title' => ucwords($this->faker->words(4, true)),
            'description' => $this->faker->paragraph(5),
        ];
    }
}
