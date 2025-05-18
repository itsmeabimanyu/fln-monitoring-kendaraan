<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supir extends Model
{
    protected $fillable = [
        'nama',
        'telepon',
        'status_hadir'
    ];

    public function __toString()
    {
        return $this->nama;
    }
}
