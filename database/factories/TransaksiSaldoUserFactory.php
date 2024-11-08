<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\TransaksiSaldoUser>
 */
class TransaksiSaldoUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = fake()->randomElement(['pending', 'validated', 'rejected']);
        return [
            'id_user' => User::select('id')->inRandomOrder()->first()->id,
            'keterangan' => fake()->sentence(),
            'arus_transaksi' => fake()->randomElement(['pemasukan', 'pengeluaran']),
            'nominal' => fake()->numberBetween(100000, 10000000),
            'bukti_transaksi' => 'avatars/bukti.jpg',
            'status' => $status,
            'id_validator' => 1,
            'validated_at' => ($status !== 'pending') ? fake()->dateTimeBetween('-1 months', 'now') : null,
        ];
    }
}
