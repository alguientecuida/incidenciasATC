<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\USUARIO;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    //INCIO DE SESION:
    public function login(){
        return view('login');
    }

    public function agregar_reporte(){
        

        $user_auth = Auth::user();
        
        return view('layouts.agregar_reporte', compact('user_auth'));
    }


    public function listarTodosReportes(){
        return view('layouts.vistas_reportes.reportes_general');
    }

    public function detalleReporte(){
        return view('layouts.vistas_reportes.detalle_reporte');
    }

    public function agregarRevision(){
        return view('layouts.vistas_reportes.agregar_revision');
    }

    public function asignarODT(){
        return view('layouts.odts.asignar_odt');
    }
    public function listarODTS(){
        return view('layouts.odts.listar_odt');
    }

    public function crearODT(){
        return view('layouts.odts.crear_odt');
    }

    public function reportesFinalizados(){
        return view('layouts.vistas_reportes.reportes_finalizado');
    }

    public function reportesSoporte(){
        return view('layouts.vistas_reportes.reportes_soporte');
    }

    public function reportesJTecnico(){
        return view('layouts.vistas_reportes.reportes_jTecnico');
    }

    public function listarODTSTecnicos(){
        return view('layouts.odts.listar_odts_tecnicos');
    }

    public function cerrarODT($id){
        $id = $id;
        return view('layouts.odts.cerrar_odt', ['id'=>$id]);
    }
}
