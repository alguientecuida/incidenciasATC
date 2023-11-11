<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SUCURSAL extends Model
{
    use HasFactory;
    protected $table = 'SUCURSALES';

    public function reportes(){
        return $this->hasMany(REPORTE::class);
    }

    public function odts(){
        return $this->hasMany(ODT::class);
    }
}
