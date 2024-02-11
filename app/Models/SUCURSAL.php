<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;

class SUCURSAL extends Model
{
    use HasFactory;
    use Notifiable;
    protected $table = 'SUCURSALES';

    public function reportes(){
        return $this->hasMany(REPORTE::class);
    }

    public function odts(){
        return $this->hasMany(ODT::class);
    }
    public function routeNotificationForMail()
    {
        return $this->EMAIL; // Reemplaza 'email_personalizado' con el nombre real de la columna que contiene las direcciones de correo electrónico en tu tabla
    }
}
