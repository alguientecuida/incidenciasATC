<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ASIGNACION extends Model
{
    use HasFactory;
    protected $table = 'ASIGNACIONES';
    public $timestamps = false;
    protected $primaryKey = 'ID_asignacion';

    
    public function odt(){
        return $this->hasMany(ODT::class, 'ID_odt', 'ID_asignacion');
    }

    public function USUARIO(){
        return $this->hasMany(USUARIO::class, 'ID_Usuario', 'ID');
    }
}
