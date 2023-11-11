<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class ODT extends Model
{
    use HasFactory;
    protected $table = 'ODTS';
    public $timestamps = false;
    protected $primaryKey = 'ID_odt';

    public function reportes():BelongsTo{
        return $this->belongsTo(REPORTE::class);
    }

    public function usuarios(){
        return $this->belongsTo(USUARIO::class, 'ID_Usuario', 'ID');
    }

    public function sucursal(){
        return $this->belongsTo(SUCURSAL::class, 'ID_sucursal', 'ID');
    }

    public function usuarioAsig(){
        return $this->belongsToMany(USUARIO::class,'ASIGNACIONES','ID_odt','ID_usuario');
    }

    public function files(){
        return $this->hasMany(IMAGEN_ODT::class, 'ID_odt', 'ID_odt');
    }
}
