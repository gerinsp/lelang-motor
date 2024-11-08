<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'is_admin',
        'avatar',
        'saldo',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // Accessors & Mutators
    // Accessors mengubah saldo menjadi ribuan
    protected function name(): Attribute
    {
        return Attribute::make(
            set: fn(string $value) => ucfirst(strtolower($value)),
        );
    }

    // Custom Accessors
    public function getSaldoRibuanAttribute(): string
    {
        return number_format($this->saldo, 0, ',', '.');
    }

    // scopes
    public function scopeSearch(Builder $query, string $search)
    {
        return $query->where('name', 'like', '%' . $search . '%')
            ->orWhere('email', 'like', '%' . $search . '%');
    }
    // searchLelang
    public function scopeSearchLelang(Builder $query, string $keyword)
    {
        return $query->whereHas('menangLelang.motor', function ($query) use ($keyword) {
            $query->where('nama', 'like', '%' . $keyword . '%');
        });
    }
    public function scopeStatus(Builder $query, string $status = 'all')
    {
        if ($status === 'admin') {
            return $query->where('is_admin', 1);
        } elseif ($status === 'user') {
            return $query->where('is_admin', 0);
        } else {
            return $query;
        }
    }
    public function scopeRentangSaldo(Builder $query, int $rentang)
    {
        if ($rentang === 1) {
            // return $query->where('saldo', '<=', 500000);
            return $query->whereBetween('saldo', [0, 500000]);
        } elseif ($rentang === 2) {
            return $query->whereBetween('saldo', [500000, 1000000]);
        } elseif ($rentang === 3) {
            return $query->whereBetween('saldo', [1000000, 2000000]);
        } elseif ($rentang === 4) {
            return $query->whereBetween('saldo', [2000000, 5000000]);
        } elseif ($rentang === 5) {
            return $query->whereBetween('saldo', [5000000, 10000000]);
        } elseif ($rentang === 6) {
            return $query->where('saldo', '>=', 10000000);
        } else {
            return $query;
        }
    }

    // Relationships
    public function transaksiSaldoUser(): HasMany
    {
        return $this->hasMany(TransaksiSaldoUser::class, 'id_user');
    }

    public function pesertaLelang(): BelongsToMany
    {
        return $this->belongsToMany(Lelang::class, 'peserta_lelang', 'id_user', 'id_lelang');
    }

    public function penawaranLelang(): BelongsToMany
    {
        return $this->belongsToMany(Lelang::class, 'penawaran_lelang', 'id_user', 'id_lelang')->withPivot('penawaran', 'created_at');
    }

    public function menangLelang(): HasMany
    {
        return $this->hasMany(Lelang::class, 'id_pemenang');
    }
}
