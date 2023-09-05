<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\question>
 */
class questionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' =>fake()->uuid(),
            'body'=>fake()->sentence(),
            'degree'=>2,
            'is-cycle'=>fake()->boolean(),
            'year'=>fake()->year($max = 'now'),
            'material_id'=>fake()->randomElement([1,2,3,4,5,6,7]),
            'is-master'=>fake()->boolean(),
        ];
    }
}
