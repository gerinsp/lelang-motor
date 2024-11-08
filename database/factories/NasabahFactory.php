<?php

namespace Database\Factories;

use App\Models\Motor;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Nasabah>
 */
class NasabahFactory extends Factory
{
    // Static variable for unique id
    protected static ?int $id = 1;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_motor' => static::$id++,
            'nama' => fake()->name(),
            'alamat' => fake()->address(),
            'no_hp' => fake()->numerify('08##########'),
            'utang' => fake()->numberBetween(100000, 100000000),
            'hapus_buku' => fake()->boolean(),
            'kredit_lunas' => fake()->boolean(),
        ];
    }
}
