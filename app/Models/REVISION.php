<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class REVISION extends Model
{
    use HasFactory;
    protected $table = 'REVISIONES';
    public $timestamps = false;
    protected $primaryKey = 'ID_Revisiones';

    public function reportes():BelongsTo{
        return $this->belongsTo(REPORTE::class);
    }
    public function usuarios(){
        return $this->belongsTo(USUARIO::class, 'ID_Usuario', 'ID');
    }
}
