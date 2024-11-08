<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Motor>
 */
class MotorFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $merks = ['Honda', 'Yamaha', 'Kawasaki', 'Suzuki', 'Vespa', 'KTM', 'Benelli', 'TVS', 'Royal Enfield', 'SYM', 'Harley-Davidson'];
        $merk = fake()->randomElement($merks);

        if ($merk === 'Honda') {
            $jenises = ['Beat', 'Vario', 'PCX', 'CBR Series', 'Supra', 'CRF'];
        } elseif ($merk === 'Yamaha') {
            $jenises = ['NMAX', 'Aerox', 'R15', 'XMAX', 'Mio', 'MT'];
        } elseif ($merk === 'Kawasaki') {
            $jenises = ['Ninja', 'KLX', 'W', 'Versys'];
        } elseif ($merk === 'Suzuki') {
            $jenises = ['Satria F150', 'GSX-R150', 'GSX-S150', 'Nex II'];
        } elseif ($merk === 'Vespa') {
            $jenises = ['Sprint', 'Primavera', 'GTS'];
        } elseif ($merk === 'KTM') {
            $jenises = ['Duke', 'RC', 'EXC'];
        } elseif ($merk === 'Benelli') {
            $jenises = ['TNT', 'Leoncino', 'TRK'];
        } elseif ($merk === 'TVS') {
            $jenises = ['Apache', 'Neo', 'Ntorq'];
        } elseif ($merk === 'Royal Enfield') {
            $jenises = ['Clasic 350', 'Meteor 350', 'Himalayan'];
        } elseif ($merk === 'SYM') {
            $jenises = ['Jet', 'Cruisym', 'DRG BT'];
        } elseif ($merk === 'Harley-Davidson') {
            $jenises = ['Iron 883', 'Street Glide', 'Fat Boy'];
        } else {
            $jenises = ['X-Migration'];
        }
        $jenis = fake()->randomElement($jenises);

        return [
            'nama' => $merk . ' ' . $jenis,
            'keterangan' => fake()->sentence(),
            'tahun_pembuatan' => fake()->dateTimeBetween('-10 year', 'now')->format('Y'),
            'merk' => $merk,
            'jenis' => $jenis,
            'kapasitas_mesin' => fake()->randomElement([110, 125, 150, 250, 500, 1000]),
            'bahan_bakar' => 'Bensin',
            'odometer' => fake()->numberBetween(100, 1000),
            'nomor_rangka' => fake()->bothify('??#??#####??#####'),
            'nomor_mesin' => fake()->bothify('??##?#######'),
            'nomor_polisi' => strtoupper(fake()->bothify('? #### ??')),
            'warna' => fake()->randomElement(['Hijau', 'Merah', 'Putih', 'Hitam', 'Kuning', 'Biru']),
            'stnk' => fake()->boolean(),
            'masa_berlaku_stnk' => fake()->dateTimeBetween('now', '+4 year')->format('Y-m-d'),
            'bpkb' => fake()->boolean(),
            'faktur' => fake()->boolean(),
            'foto_kopi_ktp' => fake()->boolean(),
            'kwitansi_blanko' => fake()->boolean(),
            'form_a' => fake()->boolean(),
        ];
    }
}
