<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\USUARIO;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Models\ODT; 
use App\Models\EMPLEADO;
use App\Models\REPORTE;

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
        $reportes = REPORTE::all();
        return view('layouts.vistas_reportes.reportes_general', ['reportes' => $reportes]);
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
        $odt = ODT::find($id);
        $empleado = EMPLEADO::where('ID_SUCURSAL', $odt->sucursal->ID)->where('NRO_EMERGENCIA', '1')->first();
        return view('layouts.odts.cerrar_odt', ['id'=>$id, 'empleado'=>$empleado]);
    }

    public function reportesTecnicos(){
        return view('layouts.vistas_reportes.reportes_tecnicos');
    }

    public function reportesDCliente(){
        return view('layouts.vistas_reportes.reportes_dCliente');
    }

    public function reasignarODT($id){
        $id = $id;
        return view('layouts.odts.reasignar_odt', ['id' => $id]);
    }

    public function reportesLocales(){
        return view('layouts.vistas_reportes.fallas_locales');
    }
}
