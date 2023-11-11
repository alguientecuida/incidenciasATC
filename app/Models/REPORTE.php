<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\REPORTE;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;


class REPORTE extends Model
{
    use HasFactory;
    protected $table = 'REPORTES';
    public $timestamps = false;
    protected $primaryKey = 'ID_Reporte';

    public function USUARIO(): BelongsTo{
        return $this->belongsTo(USUARIO::class, 'ID_Usuario', 'ID');
    }
    public function tipos_fallas(){
        return $this->belongsToMany(TIPO_FALLA::class,'REPORTES_FALLAS','ID_Reporte','ID_Falla');
    }

    public function revisiones(){
        return $this->belongsTo(REVISION::class, 'ID_Reporte', 'ID_Reporte');
    }

    public function sucursal(): BelongsTo{
        return $this->belongsTo(SUCURSAL::class, 'ID_Sucursal', 'ID');
    }

    public function odts(){
        return $this->belongsTo(ODT::class, 'ID_Reporte', 'ID_Reporte');
    }
}
