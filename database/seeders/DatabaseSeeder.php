<?php

namespace Database\Seeders;

use App\Models\FotoMotor;
use App\Models\Lelang;
use App\Models\Motor;
use App\Models\Nasabah;
use App\Models\TransaksiSaldoUser;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $numberOfLelang = 100;
        User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@gmail.com',
            'is_admin' => true,
            'avatar' => 'admin-avatar.png',
            'password' => 'awsd'
        ]);
        User::factory()->create([
            'name' => 'user',
            'email' => 'user@gmail.com',
            'password' => 'awsd'
        ]);

        $users = User::factory(100)->create();

        TransaksiSaldoUser::factory(20)->create();

        Nasabah::factory($numberOfLelang)
            ->recycle(Motor::factory($numberOfLelang)->create())
            ->create();

        FotoMotor::factory($numberOfLelang * 3)->create();

        $lelang = Lelang::factory($numberOfLelang)->create();

        foreach ($lelang as $item) {
            $numberOfPeserta = random_int(1, 10);
            for ($i = 0; $i < $numberOfPeserta; $i++) {
                $userId = $users->random()->id;
                $item->pesertaLelang()->attach($userId, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $numberOfPenawaran = random_int(2, 5);
                for ($j = 0; $j < $numberOfPenawaran; $j++) {
                    $userId = $users->random()->id;
                    $item->penawaranLelang()->attach($userId, [
                        'penawaran' => random_int(100000, 100000000),
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
