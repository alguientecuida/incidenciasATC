<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\REPORTE;
use App\Models\REVISION;
use App\Models\TIPO_FALLA;
use App\Models\SUCURSAL;
use App\Models\USUARIO;
use App\Models\ASIGNACION;
use App\Models\ODT;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class REPORTESCONTROLLERS extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //

        // Obtiene la fecha y hora actual en Chile
        $fecha = Carbon::now('America/Santiago');

        // Puedes formatear la fecha y hora según tus necesidades
        $fechaY = $fecha->format('Y-m-d H:i:s');

        $reporte = new REPORTE();
        $reporte->Fecha = $fechaY;
        $reporte->ID_Usuario = session('usuario')['ID'];
        $reporte->ID_Sucursal = $request->input('sucursal');

        $reporte->save();


        foreach ($request->input('tipos', []) as $i => $ID) {
            $tipo = $request->input('tipos',[$i]);
            $tipoID = $tipo[$i];
            $tipoSelect = TIPO_FALLA::findOrFail($tipoID);
            $tipoSelect->reportes()->syncWithoutDetaching([$reporte->ID_Reporte]);

            //echo($tipoSelect .'<br>');
        }
 
        $observacion = $request->observacion;

        $revision = new REVISION();
        $revision->Fecha = $fechaY;
        $revision->Observacion = $observacion;
        $revision->Estado = 'DS';
        $revision->ID_Usuario = session('usuario')['ID'];
        $revision->ID_Reporte = $reporte->ID_Reporte;

        $revision->save();

        return redirect()->route('Reportes General')->withErrors('1');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $reporte = REPORTE::find($id);
        $revision = REVISION::select('*')->where('ID_Reporte', $reporte->ID_Reporte)->orderBy('Fecha', 'desc')->first();

        return view('layouts.vistas_reportes.agregar_revision', ['reporte'=>$reporte, 'revision'=>$revision]);
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    /*
    GENERAR TICKET ALEATORIO PARA UN FUTURO...
    public function TICKETS(){
        $longitud = 7; // Longitud deseada para el número alfanumérico
        $caracteres = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'; // Caracteres permitidos

        $numeroTicket = '';
        for ($i = 0; $i < $longitud; $i++) {
            $numeroTicket .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        // Puedes guardar el número de ticket en la base de datos aquí si es necesario
        // Por ejemplo, si tienes una tabla de tickets, puedes crear un nuevo registro con este número.

        // Devolver el número de ticket como respuesta
        dd($numeroTicket);
    }
*/
    public function seleccion(Request $request){
        $sucursal = $request->input('sucursal');
        dd();
    }

    public function mostrarAllReportes(){
        $reportes = REPORTE::all();
        $sucursales = SUCURSAL::all();
        //$revision = REVISION::select('Fecha', 'Estado')->where('ID_Reporte', $reportes->ID_Reporte)->orderBy('Fecha', 'desc')->first();

        return view('layouts.vistas_reportes.reportes_general', ['reportes' => $reportes, 'sucursales' => $sucursales]);
        //dd($reportes);
    }

    public function relaciones(){
        $reporte = REPORTE::find(4);
        $sucursal = $reporte->revisiones->Fecha;
        dd($sucursal);
    }

    public function detalleReporte($id){
        $reporte = REPORTE::find($id);
        $detalles = REVISION::select('*')->where('ID_Reporte', $reporte->ID_Reporte)->orderBy('Fecha', 'desc')->get();
        return view('layouts.vistas_reportes.detalle_reporte', ['reporte'=>$reporte, 'detalles'=>$detalles]);
        //dd($detalles);
    }

    public function agregarRevision(Request $request, $id_rep){
         // Obtiene la fecha y hora actual en Chile
         $fecha = Carbon::now('America/Santiago');

         // Puedes formatear la fecha y hora según tus necesidades
         $fechaY = $fecha->format('Y-m-d H:i:s');

        $revision = new REVISION();
        $revision->Fecha = $fechaY;
        $revision->Observacion = $request->observacion;
        $revision->Estado = $request->estado;
        $revision->ID_Usuario = session('usuario')['ID'];
        $revision->ID_Reporte = $id_rep;

        $revision->save();
        $reporte = REPORTE::find($id_rep);
        $detalles = REVISION::where('ID_Reporte', $reporte->ID_Reporte)->orderBy('Fecha', 'desc')->get();

        if($revision->Estado == 'DT'){
            $tecnicos = USUARIO::where('ESTADO', 'Activado')->where('TIPO', 'Tecnico')->orWhere('TIPO', 'Soporte')->orWhere('TIPO', 'Jefe Tecnico')->orWhere('NOMBRE', 'Ronald Montilla Andara')->get();
            return view('layouts.odts.asignar_odt', ['tecnicos'=>$tecnicos, 'reporte'=>$reporte, ]);
        }else{
            return redirect()->route('Detalle Reporte', $reporte->ID_Reporte);
        }
        
    }

    public function crearODTRep(Request $request, $id_rep){
        $reporte = REPORTE::find($id_rep);
        // Obtiene la fecha y hora actual en Chile
        $fecha = Carbon::now('America/Santiago');
        // Puedes formatear la fecha y hora según tus necesidades
        $fechaY = $fecha->format('Y-m-d H:i:s');
        $ultimoodt = ODT::latest('ID_odt')->first();
        $odt = new ODT();
        $odt->Fecha_creacion = $fechaY;
        $odt->Numero_odt = $ultimoodt ? $ultimoodt->Numero_odt + 1 : 1;
        $odt->ID_usuario = session('usuario')['ID'];
        $odt->Estado = 'A';
        $odt->Fecha_inicio = $fechaY;
        $odt->ID_sucursal = $reporte->ID_Sucursal;
        $odt->Tipo_trabajo = 'MC';
        $odt->ID_reporte = $id_rep;

        $odt->save();

        $asignacion = new ASIGNACION();
        $asignacion->ID_odt = $odt->ID_odt;
        $asignacion->ID_usuario = $request->tecnico;
        $asignacion->Fecha = $fechaY;

        $asignacion->save();

        return redirect()->route("ODT'S")->withErrors('1');
    }

    public function reportesFinalizados(){
        //$reportes = DB::table('REPORTES')->join('REVISIONES', 'REPORTES.ID_Reporte', '=', 'REVISIONES.ID_Reporte')->where('REVISIONES.Estado', '=', 'F')->select('REPORTES.*')->get();
        $reportes = REPORTE::whereHas('revisiones', function ($query) {
            $query->where('Estado', 'F');
        })->get();
        

    return view('layouts.vistas_reportes.reportes_finalizado', ['reportes' => $reportes]);
    }

    public function reportesSoporte(){
        //$reportes = DB::table('REPORTES')->join('REVISIONES', 'REPORTES.ID_Reporte', '=', 'REVISIONES.ID_Reporte')->where('REVISIONES.Estado', '=', 'F')->select('REPORTES.*')->get();
        //$reportes = REPORTE::whereHas('revisiones', function ($query) {
        //    $query->where('Estado', 'DS');
        //})->latest('ID_Reporte')->first()->get();

        $reportes = REPORTE::select('reportes.*')
    ->join('revisiones', function ($join) {
        $join->on('reportes.ID_Reporte', '=', 'revisiones.ID_Reporte')
            ->whereRaw('revisiones.Fecha = (SELECT MAX(Fecha) FROM revisiones WHERE ID_Reporte = reportes.ID_Reporte)')
            ->where('revisiones.Estado', '=', 'DS');
    })
    ->get();


    return view('layouts.vistas_reportes.reportes_soporte', ['reportes' => $reportes]);
    //return dd($reportes);
    }

    public function reportesJTecnico(){
        //$reportes = DB::table('REPORTES')->join('REVISIONES', 'REPORTES.ID_Reporte', '=', 'REVISIONES.ID_Reporte')->where('REVISIONES.Estado', '=', 'F')->select('REPORTES.*')->get();
        //$reportes = REPORTE::whereHas('revisiones', function ($query) {
        //    $query->where('Estado', 'DS');
        //})->latest('ID_Reporte')->first()->get();

        $reportes = REPORTE::select('reportes.*')
    ->join('revisiones', function ($join) {
        $join->on('reportes.ID_Reporte', '=', 'revisiones.ID_Reporte')
            ->whereRaw('revisiones.Fecha = (SELECT MAX(Fecha) FROM revisiones WHERE ID_Reporte = reportes.ID_Reporte)')
            ->where('revisiones.Estado', '=', 'DJT');
    })
    ->get();


    return view('layouts.vistas_reportes.reportes_jTecnico', ['reportes' => $reportes]);
    //return dd($reportes);
    }

    
    
}
