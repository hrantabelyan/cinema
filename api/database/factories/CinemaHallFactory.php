<?php

namespace Database\Factories;

use App\Models\Color;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\CinemaHall>
 */
class CinemaHallFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' => Str::uuid(),
            'name' => $this->faker->name,
            'color_id' => Color::all()->random()->id,
            'number_of_rows' => $this->faker->numberBetween(10, 20),
            'number_of_columns' => $this->faker->numberBetween(5, 20),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
