<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Lelang extends Model
{
    /** @use HasFactory<\Database\Factories\LelangFactory> */
    use HasFactory;

    protected $table = 'lelang';

    protected $fillable = [
        'id_motor',
        'keterangan',
        'status_lelang',
        'waktu_mulai_lelang',
        'waktu_selesai_lelang',
        'harga_awal',
        'uang_jaminan',
        'id_pemenang',
        'penawaran_akhir',
        'bukti_pembayaran',
        'status_pembayaran',
        'id_validator',
        'validated_at',
    ];

    protected function casts(): array
    {
        return [
            'waktu_mulai_lelang' => 'datetime',
            'waktu_selesai_lelang' => 'datetime',
        ];
    }

    // Custom Accessors
    public function getPenawaranAkhirRibuanAttribute(): string
    {
        return number_format($this->penawaran_akhir, 0, ',', '.');
    }
    public function getHargaAwalRibuanAttribute(): string
    {
        return number_format($this->harga_awal, 0, ',', '.');
    }
    public function getUangJaminanRibuanAttribute(): string
    {
        return number_format($this->uang_jaminan, 0, ',', '.');
    }

    // Scopes
    public function scopeSearch(Builder $query, $keyword)
    {
        return $query->whereHas('pemenang', function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })->orWhereHas('motor', function ($query) use ($keyword) {
            $query->where('nama', 'like', '%' . $keyword . '%');
        })->orWhere('keterangan', 'like', '%' . $keyword . '%');
    }
    public function scopeWaktuLelang(Builder $query, string $waktuLelang)
    {
        if ($waktuLelang === 'all') {
            return $query->where('waktu_mulai_lelang', '>', Carbon::now());
        }
        if ($waktuLelang === 'today') {
            return $query->where('waktu_mulai_lelang', '>', Carbon::now())
                ->where('waktu_mulai_lelang', '<=', Carbon::now()->endOfDay());
        }
        if ($waktuLelang === 'tomorrow') {
            return $query->whereDate('waktu_mulai_lelang', '>', Carbon::now()->endOfDay());
        }
        return $query;
    }
    public function scopeStatusLelang(Builder $query, string $statusLelang)
    {
        if ($statusLelang === 'akan datang') {
            return $query->where('status_lelang', 'akan datang');
        }
        if ($statusLelang === 'berlangsung') {
            return $query->where('status_lelang', 'berlangsung');
        }
        if ($statusLelang === 'selesai') {
            return $query->where('status_lelang', 'selesai');
        }
        if ($statusLelang === 'positif') {
            return $query->whereIn('status_lelang', ['akan datang', 'berlangsung']);
        }
        return $query;
    }

    public function scopeStatusPembayaran(Builder $query, string $statusPembayaran)
    {
        if ($statusPembayaran === 'pending') {
            return $query->where('status_pembayaran', 'pending');
        }
        if ($statusPembayaran === 'validated') {
            return $query->where('status_pembayaran', 'validated');
        }
        if ($statusPembayaran === 'rejected') {
            return $query->where('status_pembayaran', 'rejected');
        }
        return $query;
    }
    public function scopeWhereTagihanLelang(Builder $query)
    {
        return $query->where('status_lelang', 'selesai')->where('status_pembayaran', 'pending');
    }
    public function scopePenawaranAkhir(Builder $query, int $rentang)
    {
        if ($rentang === 1) {
            return $query->whereBetween('penawaran_akhir', [0, 1000000]);
        } elseif ($rentang === 2) {
            return $query->whereBetween('penawaran_akhir', [1000000, 2000000]);
        } elseif ($rentang === 3) {
            return $query->whereBetween('penawaran_akhir', [2000000, 5000000]);
        } elseif ($rentang === 4) {
            return $query->whereBetween('penawaran_akhir', [5000000, 10000000]);
        } elseif ($rentang === 5) {
            return $query->where('penawaran_akhir', '>=', 10000000);
        } else {
            return $query;
        }
    }

    // Relationships
    public function motor(): BelongsTo
    {
        return $this->belongsTo(Motor::class, 'id_motor');
    }

    public function pesertaLelang(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'peserta_lelang', 'id_lelang', 'id_user');
    }

    public function penawaranLelang(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'penawaran_lelang', 'id_lelang', 'id_user')->withPivot('penawaran', 'created_at');
    }

    public function pemenang(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_pemenang');
    }
}
