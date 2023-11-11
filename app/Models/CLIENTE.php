<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CLIENTE extends Model
{
    use HasFactory;
    protected $table = 'CLIENTES';
    public $timestamps = false;
    
}
