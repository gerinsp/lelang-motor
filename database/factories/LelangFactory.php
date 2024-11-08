<?php

namespace Database\Factories;

use App\Models\Lelang;
use App\Models\Motor;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Lelang>
 */
class LelangFactory extends Factory
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
        $satu_jam_dari_sekarang = now()->hour + 1;
        $waktu_mulai_lelang = rand(0, 1) ? now()->setTime(rand($satu_jam_dari_sekarang, 23), rand(0, 59), rand(0, 59)) : now()->addDays(rand(1, 7))->setTime(rand(0, 23), rand(0, 59), rand(0, 59));
        $clone_waktu_mulai_lelang = clone $waktu_mulai_lelang;
        $waktu_selesai_lelang = $clone_waktu_mulai_lelang->addDays(rand(1, 7))->setTime(rand(0, 23), rand(0, 59), rand(0, 59));
        $clone_waktu_selesai_lelang = clone $waktu_selesai_lelang;
        $status_lelang = fake()->randomElement(['akan datang', 'berlangsung', 'selesai']);
        return [
            'id_motor' => static::$id++,
            'keterangan' => fake()->sentence(),
            'status_lelang' => $status_lelang,
            'waktu_mulai_lelang' => $waktu_mulai_lelang,
            'waktu_selesai_lelang' => $waktu_selesai_lelang,
            'harga_awal' => fake()->numberBetween(100000, 10000000),
            'uang_jaminan' => fake()->numberBetween(100000, 10000000),
            'id_pemenang' => ($status_lelang === 'selesai') ? User::select('id')->inRandomOrder()->first()->id : null,
            'penawaran_akhir' => ($status_lelang === 'selesai') ? fake()->numberBetween(100000, 10000000) : null,
            'bukti_pembayaran' => ($status_lelang !== 'pending') ? 'dev-bukti.jpeg' : null,
            'status_pembayaran' => ($status_lelang === 'akan datang') ? 'pending' : fake()->randomElement(['pending', 'validated', 'rejected']),
            'id_validator' => ($status_lelang !== 'pending') ? 1 : null,
            'validated_at' => ($status_lelang !== 'pending') ? $clone_waktu_selesai_lelang->addDays(rand(1, 2))->setTime(rand(0, 23), rand(0, 59), rand(0, 59)) : null,
        ];
    }
}
