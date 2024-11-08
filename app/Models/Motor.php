<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Motor extends Model
{
    /** @use HasFactory<\Database\Factories\MotorFactory> */
    use HasFactory;

    protected $table = 'motor';

    protected $fillable = [
        'nama',
        'keterangan',
        'tahun_pembuatan',
        'merk',
        'jenis',
        'kapasitas_mesin',
        'bahan_bakar',
        'odometer',
        'nomor_rangka',
        'nomor_mesin',
        'nomor_polisi',
        'warna',
        'stnk',
        'masa_berlaku_stnk',
        'bpkb',
        'faktur',
        'foto_kopi_ktp',
        'kwitansi_blanko',
        'form_a',
    ];

    public function nasabah(): HasOne
    {
        return $this->hasOne(Nasabah::class, 'id_motor');
    }

    public function fotoMotor(): HasMany
    {
        return $this->hasMany(FotoMotor::class, 'id_motor');
    }

    public function lelang(): HasOne
    {
        return $this->hasOne(Lelang::class, 'id_motor');
    }
}
