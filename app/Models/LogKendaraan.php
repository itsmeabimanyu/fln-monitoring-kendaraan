<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LogKendaraan extends Model
{
    protected $fillable = [
        'kendaraan_id',
        'driver_id',
        'tujuan',
        'keterangan',
        'penumpang',
        'status'
    ];

    // Relasi ke kendaraan
    public function kendaraan()
    {
        return $this->belongsTo(Kendaraan::class);
    }

    // Relasi ke supir
    public function driver()
    {
        return $this->belongsTo(Supir::class);
    }
}
