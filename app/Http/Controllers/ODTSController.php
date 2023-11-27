<?php

namespace App\Http\Controllers;

use App\Models\ODT;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\REPORTE;
use App\Models\REVISION;
use App\Models\TIPO_FALLA;
use App\Models\SUCURSAL;
use App\Models\USUARIO;
use App\Models\ASIGNACION;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use App\Models\IMAGEN_ODT;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use Illuminate\Support\Str;
use App\Models\CLIENTE;
use App\Models\EMPLEADO;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Http\Requests\CreateODTRequest;


class ODTSController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $odts = ODT::all();

        return view('layouts.odts.listar_odt')->with('odts', $odts);
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
    }

    /**
     * Display the specified resource.
     */
    public function show(ODT $oDT)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id_odt)
    {
        //
        $odt = ODT::find($id_odt);
        $asignacion = ASIGNACION::where('ID_odt', $odt->ID_odt)->first();
        $tecnicos = USUARIO::where('ESTADO', 'Activado')->where('TIPO', 'Tecnico')->orWhere('TIPO', 'Soporte')->orWhere('TIPO', 'Jefe Tecnico')->orWhere('NOMBRE', 'Ronald Montilla Andara')->get();
        return view('layouts.odts.reasignar_odt', ['odt' => $odt, 'asignacion'=>$asignacion, 'tecnicos' => $tecnicos]);
        //return dd($odt, $asignacion);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $ID_asignacion)
    {
        //
        $asignacion = ASIGNACION::find($ID_asignacion);
        $asignacion->ID_usuario = $request->tecnico;

        $asignacion->save();

        return redirect()->route("ODT'S")->withErrors('2');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ODT $oDT)
    {
        //
    }

    public function crearODT(){
        $sucursales = DB::table('sucursales')
        ->select('ID', 'NOMBRE_SUCURSAL')
        ->where('NOMBRE_SUCURSAL', '<>', '-')
        ->orderBy('NOMBRE_SUCURSAL', 'asc')
        ->get();
        $tecnicos = USUARIO::where('TIPO', 'Tecnico')->get();

        return view('layouts.odts.crear_odt', ['tecnicos'=>$tecnicos, 'sucursales'=>$sucursales, ]);
    }

    public function ODTsTecnicos(){
        $odts = ODT::select('ODTS.*')
    ->join('ASIGNACIONES', 'ODTS.ID_odt', '=', 'ASIGNACIONES.ID_odt')
    ->join('USUARIOS', 'ASIGNACIONES.ID_usuario', '=', 'USUARIOS.ID')
    ->where('USUARIOS.ID', '=', session('usuario')['ID'])
    ->get();
    return view('layouts.odts.listar_odts_tecnicos', ['odts'=> $odts]);
    }

   public function estadoEnProceso($id_odt){
    $odt = ODT::find($id_odt);
    $fecha = Carbon::now('America/Santiago');
        // Puedes formatear la fecha y hora según tus necesidades
    $fechaY = $fecha->format('Y-m-d H:i:s');
    $odt->Estado = 'EP';
    $odt->Fecha_inicio = $fechaY;

    $odt->save();

    $odts = ODT::select('ODTS.*')
    ->join('ASIGNACIONES', 'ODTS.ID_odt', '=', 'ASIGNACIONES.ID_odt')
    ->join('USUARIOS', 'ASIGNACIONES.ID_usuario', '=', 'USUARIOS.ID')
    ->where('USUARIOS.ID', '=', session('usuario')['ID'])
    ->get();
    return redirect()->route("ODT'S Tecnicos", ['odts' => $odts])->withErrors('2');
   }

//SUBIR IMAGENES
   public function imagenODT(Request $request, $id_odt){

    $request->validate([
        'file' => 'required|image'
    ]);
        /*$imagenes = $request->file('file')->store('public/imagenesODT');
        $url = Storage::url($imagenes);

        /*IMAGEN_ODT::create([
            'url' => $url,
            'ID_odt' => $id_odt
        ]);*/

    $request->validate([
        'file' => 'required|image'
    ]);
    $nombre = Str::random(10) . $request->file('file')->getClientOriginalName();
    $ruta = storage_path() . '\app\public\imagenesODT/' . $nombre;

    Image::make($request->file('file'))->resize(400, null, function ($constraint) {
        $constraint->aspectRatio();
    })->save($ruta);

    IMAGEN_ODT::create([
        'url' => '/storage/imagenesODT/' . $nombre,
        'ID_odt' => $id_odt
    ]);
   }

   public function cerrarODT(Request $request, $id){
    $odt = ODT::find($id);
    $fecha = Carbon::now('America/Santiago');
    // Puedes formatear la fecha y hora según tus necesidades
    $fechaY = $fecha->format('Y-m-d H:i:s');

    $odt->Fecha_cierre = $fechaY;
    $odt->Detalle_cierre = $request->detalle;
    $odt->Estado = 'F';
    $odt->persona_contacto = $request->nombre_contacto;
    $odt->numero_contacto = $request->numero_contacto;

    $odt->save();

    if($odt->ID_reporte != NULL){
        $reporte = REPORTE::find($odt->ID_reporte);

        $revision = New REVISION();

        $revision->Fecha = $fechaY;
        $revision->Observacion = $odt->Detalle_cierre;
        $revision->Estado = 'F';
        $revision->ID_Usuario = session('usuario')['ID'];
        $revision->ID_Reporte = $reporte->ID_Reporte;

        $revision->save();
        $odts = ODT::select('ODTS.*')
            ->join('ASIGNACIONES', 'ODTS.ID_odt', '=', 'ASIGNACIONES.ID_odt')
            ->join('USUARIOS', 'ASIGNACIONES.ID_usuario', '=', 'USUARIOS.ID')
            ->where('USUARIOS.ID', '=', session('usuario')['ID'])
            ->get();
        return redirect()->route("ODT'S Tecnicos", ['odts' => $odts])->withErrors('3');
    }else{

    

        $odts = ODT::select('ODTS.*')
            ->join('ASIGNACIONES', 'ODTS.ID_odt', '=', 'ASIGNACIONES.ID_odt')
            ->join('USUARIOS', 'ASIGNACIONES.ID_usuario', '=', 'USUARIOS.ID')
            ->where('USUARIOS.ID', '=', session('usuario')['ID'])
            ->get();
        return redirect()->route("ODT'S Tecnicos", ['odts' => $odts])->withErrors('3');
    }
   }

   public function generarPDF($id){
    $odt = ODT::find($id);
    $sucursal = SUCURSAL::where('ID', $odt->ID_sucursal)->get();
    $cliente = CLIENTE::find($odt->sucursal->ID_CLIENTE);
    $empleado = EMPLEADO::where('ID_SUCURSAL', $odt->sucursal->ID)->where('NRO_EMERGENCIA', '1')->first();
    $imagenes = IMAGEN_ODT::select('url')->where('ID_odt', $id)->get();
    $rutasImagenes = $imagenes->pluck('url')->map(function ($url) {
        return public_path($url);
    })->toArray();
    $logo = public_path('img/LogoPDF.jpg');
    //return $rutasImagenes;
    $pdf = Pdf::loadView('layouts.odts.pdf_odt', ['odt' => $odt, 'logo' => $logo, 'empleado' => $empleado, 'cliente' => $cliente, 'imagenes' => $rutasImagenes]);
    
    
    return $pdf->stream();
    
   }

   public function generarODT(CreateODTRequest $request){
    $fecha = Carbon::now('America/Santiago');
    // Puedes formatear la fecha y hora según tus necesidades
    $fechaY = $fecha->format('Y-m-d H:i:s');
    $ultimoodt = ODT::latest('ID_odt')->first();
    $odt = new ODT();
    $odt->Fecha_creacion = $fechaY;
    $odt->Numero_odt = $ultimoodt ? $ultimoodt->Numero_odt + 1 : 1;
    $odt->ID_usuario = session('usuario')['ID'];
    $odt->Estado = 'A';
    $odt->Fecha_inicio = $request->Fecha_inicio;
    $odt->ID_sucursal = $request->sucursal;
    $odt->Tipo_trabajo = $request->trabajo;

    $odt->save();

    $asignacion = new ASIGNACION();
    $asignacion->ID_odt = $odt->ID_odt;
    $asignacion->ID_usuario = $request->tecnico;
    $asignacion->Fecha = $fechaY;

    $asignacion->save();

    return redirect()->route("ODT'S");
   }

   public function estadoEnCamino($id){
    $odt = ODT::find($id);

    $odt->Estado = 'EC';

    $odt->save();
    return back()->withErrors('2');
   }
}
