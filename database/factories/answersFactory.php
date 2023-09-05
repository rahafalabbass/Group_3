<?php

namespace Database\Factories;

use App\Models\Answers;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class answersFactory extends Factory
{
    protected $model = Answers::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'uuid' =>fake()->uuid(),
            'body'=>fake()->word(),
            'question_id'=>45,
            'is_correct'=>0,
            'reference' =>fake()->sentence()
        ];
    }
}
