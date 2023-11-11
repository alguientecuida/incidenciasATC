<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class IMAGEN_ODT extends Model
{
    use HasFactory;
    protected $table = 'IMAGENES_ODTS';
    protected $primaryKey = 'ID_imagen';
    public $timestamps = false;
    protected $fillable = ['url', 'ID_odt'];

    public function odt(){
        return $this->belongsTo(ODT::class, 'ID_odt', 'ID_odt');
    }
}
