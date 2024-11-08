<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Nasabah extends Model
{
    /** @use HasFactory<\Database\Factories\NasabahFactory> */
    use HasFactory;

    protected $table = 'nasabah';

    protected $fillable = [
        'id_motor',
        'nama',
        'alamat',
        'no_hp',
        'utang',
        'hapus_buku',
        'kredit_lunas',
    ];

    // Custom Accessors
    public function getUtangRibuanAttribute(): string
    {
        return number_format($this->utang, 0, ',', '.');
    }

    // Scopes
    public function scopeRentangUtang(Builder $query, int $rentang)
    {
        if ($rentang === 1) {
            return $query->whereBetween('utang', [0, 5000000]);
        } elseif ($rentang === 2) {
            return $query->whereBetween('utang', [5000000, 10000000]);
        } elseif ($rentang === 3) {
            return $query->whereBetween('utang', [10000000, 20000000]);
        } elseif ($rentang === 4) {
            return $query->whereBetween('utang', [20000000, 50000000]);
        } elseif ($rentang === 5) {
            return $query->whereBetween('utang', [50000000, 100000000]);
        } elseif ($rentang === 6) {
            return $query->where('utang', '>=', 100000000);
        } else {
            return $query;
        }
    }
    public function scopeSearch(Builder $query, string $search)
    {
        return $query->where('nama', 'like', '%' . $search . '%')
            ->orWhere('alamat', 'like', '%' . $search . '%')
            ->orWhere('no_hp', 'like', '%' . $search . '%');
    }
    public function scopeIsLelangNotSelesai(Builder $query)
    {
        return $query->whereHas('motor.lelang', function ($query) {
            $query->where('status_lelang', '!=', 'selesai');
        })->with('motor.lelang');
    }


    public function motor(): BelongsTo
    {
        return $this->belongsTo(Motor::class, 'id_motor');
    }
}
