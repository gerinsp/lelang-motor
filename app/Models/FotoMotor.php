<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class FotoMotor extends Model
{
    /** @use HasFactory<\Database\Factories\FotoMotorFactory> */
    use HasFactory;

    protected $table = 'foto_motor';

    protected $fillable = [
        'id_motor',
        'src',
        'alt',
    ];

    public function motor(): BelongsTo
    {
        return $this->belongsTo(Motor::class, 'id_motor');
    }
}
