<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticable;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Relations\BelongTo;


class USUARIO extends Authenticable
{
    use HasFactory;
    protected $table = 'USUARIOS';
    protected $fillable = [
        'USUARIO', 'NOMBRE', 'CONTRASE', 'PASS_HASH', 'TIPO'
    ];
    public $timestamps = false;
    public function REPORTES(){
        return $this->belongsTo(REPORTE::class);
    }

    public function revisiones(){
        return $this->belongsToMany(REVISION::class);
    }

    public function odts(){
        return $this->belongsToMany(ODT::class);
    }

    public function asignacion(){
        return $this->hasMany(ASIGNACION::class);
    }

    public function odtAsig(){
        return $this->belongsToMany(ODT::class,'ASIGNACIONES','ID','ID_odt');
    }
}
