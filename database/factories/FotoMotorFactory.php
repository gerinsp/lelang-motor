<?php

namespace Database\Factories;

use App\Models\Motor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\FotoMotor>
 */
class FotoMotorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_motor' => Motor::select('id')->inRandomOrder()->first()->id,
            'src' => fake()->imageUrl(),
            'alt' => fake()->sentence(),
        ];
    }
}
