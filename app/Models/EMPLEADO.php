<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EMPLEADO extends Model
{
    use HasFactory;
    protected $table = 'EMPLEADOS';
    public $timestamps = false;
    protected $primaryKey = 'ID_EMPLEADO';
}
