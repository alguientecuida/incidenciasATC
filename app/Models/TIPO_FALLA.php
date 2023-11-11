<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TIPO_FALLA extends Model
{
    use HasFactory;
    protected $table = 'TIPOS_FALLAS';
    protected $primaryKey = 'ID_Falla';
    public $timestamps = false;

    public function reportes(){
        return $this->belongsToMany(REPORTE::class,'REPORTES_FALLAS','ID_Falla','ID_Reporte');
    }
}
