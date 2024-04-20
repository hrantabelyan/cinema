<?php

namespace Database\Factories;

use App\Models\CinemaHall;
use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Screening>
 */
class ScreeningFactory extends Factory
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
            'cinema_hall_id' => CinemaHall::all()->random()->id,
            'movie_id' => Movie::all()->random()->id,
            'start_at' => $this->faker->dateTimeBetween('now', '+30 days'),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
