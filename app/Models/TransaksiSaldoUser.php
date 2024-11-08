<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TransaksiSaldoUser extends Model
{
    /** @use HasFactory<\Database\Factories\TransaksiSaldoUserFactory> */
    use HasFactory;

    protected $table = 'transaksi_saldo_user';

    protected $fillable = [
        'id_user',
        'keterangan',
        'arus_transaksi',
        'nominal',
        'bukti_transaksi',
        'status',
        'id_validator',
        'validated_at',
    ];

    protected function casts(): array
    {
        return [
            'validated_at' => 'datetime'
        ];
    }

    // Custom Accessors
    public function getNominalRibuanAttribute(): string
    {
        return number_format($this->nominal, 0, ',', '.');
    }
    public function getSaldoRibuanAttribute(): string
    {
        return number_format($this->saldo, 0, ',', '.');
    }

    // scopes
    public function scopeStatus(Builder $query, string $status = 'pending')
    {
        if ($status === 'pending') {
            return $query->where('status', 'pending');
        } elseif ($status === 'rejected') {
            return $query->where('status', 'rejected');
        } elseif ($status === 'validated') {
            return $query->where('status', 'validated');
        } elseif ($status === 'history') {
            return $query->where('status', 'validated')->orWhere('status', 'rejected');
        } else {
            return $query;
        }
    }
    public function scopeSearch(Builder $query, $keyword)
    {
        return $query->whereHas('user', function ($query) use ($keyword) {
            $query->where('name', 'like', '%' . $keyword . '%');
        })->orWhere('keterangan', 'like', '%' . $keyword . '%');
    }
    public function scopeArusTransaksi(Builder $query, string $arus = null)
    {
        if ($arus === 'pemasukan') {
            return $query->where('arus_transaksi', 'pemasukan');
        } elseif ($arus === 'pengeluaran') {
            return $query->where('arus_transaksi', 'pengeluaran');
        } else {
            return $query;
        }
    }
    // rentangNominal
    public function scopeRentangNominal(Builder $query, int $rentang)
    {
        if ($rentang === 1) {
            return $query->whereBetween('nominal', [0, 500000]);
        } elseif ($rentang === 2) {
            return $query->whereBetween('nominal', [500000, 1000000]);
        } elseif ($rentang === 3) {
            return $query->whereBetween('nominal', [1000000, 2000000]);
        } elseif ($rentang === 4) {
            return $query->whereBetween('nominal', [2000000, 5000000]);
        } elseif ($rentang === 5) {
            return $query->whereBetween('nominal', [5000000, 10000000]);
        } elseif ($rentang === 6) {
            return $query->where('nominal', '>=', 10000000);
        } else {
            return $query;
        }
    }

    // Relationships
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user');
    }
    public function validator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_validator');
    }
}
