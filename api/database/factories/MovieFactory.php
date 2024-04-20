<?php

namespace Database\Factories;

use App\Models\Movie;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Movie>
 */
class MovieFactory extends Factory
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
            'name' => $this->faker->sentence(3),
            'image_path' => $this->faker->image(public_path('storage/movies'), 768, 1024, null, false),
            'duration' => $this->faker->numberBetween(60, 180), // Random duration between 60 and 180 minutes
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
