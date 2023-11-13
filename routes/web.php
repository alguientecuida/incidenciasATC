<?php

use Illuminate\Support\Facades\Route;
use App\Models\USUARIO;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\USUARIOS;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\REPORTESCONTROLLERS;
use App\Models\REPORTE;
use App\Http\Controllers\SUCURSALCONTROLLERS;
use App\Http\Controllers\TIPO_FALLASCONTROLLERS;
use App\Http\Controllers\ODTSController;
use App\Http\Middleware\Encargado;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
//RUTA QUE GENERA EL PDF
Route::get('/odt/generar/pdf/{id}', [ODTSController::class, 'generarPDF'])->name('pdf_odt')->middleware(['S:Soporte,Jefe Tecnico,Administracion,Tecnico']);

Route::get('/', function () {
    return USUARIO::all();
});


//RUTAS DE PAGINA
Route::get('/login', [HomeController::class, 'login'])->name('login');




Route::get('/logout' , [USUARIOS::class, 'logout'])->name('logout');

//POST INCIO DE SESION
Route::post('/USUARIO/LOGIN',[USUARIOS::class, 'login'])->name('USUARIO.LOGIN');
//POST AGREGAR REPORTE.
Route::post('/almacenar/reporte', [REPORTESCONTROLLERS::class, 'store'])->name('agregar.reporte')->middleware(['S:Soporte,Encargado,Jefe Tecnico,Administracion']);

//SELECT SUCURSALES EN AGREGAR REPORTE.
Route::get('/agregar_reporte', [HomeController::class, 'agregar_reporte'])->name('Agregar Reporte')->middleware(['S:Soporte,Encargado,Jefe Tecnico,Administracion']);
Route::get('/agregar_reporte', [SUCURSALCONTROLLERS::class, 'index'])->name('Agregar Reporte')->middleware(['S:Soporte,Encargado,Jefe Tecnico,Administracion']);


//REPORTE LISTAR
//GENERAL
Route::get('/reportes', [HomeController::class, 'listarTodosReportes'])->name('Reportes General');
Route::get('/reportes', [REPORTESCONTROLLERS::class, 'mostrarAllReportes'])->name('Reportes General');
//FINALIZADOS
Route::get('/reportes/finalizados',[HomeController::class, 'reportesFinalizados'])->name('Reportes Finalizados')->middleware(['S:Soporte,Encargado,Jefe Tecnico,Administracion,Operador,Tecnico']);
Route::get('/reportes/finalizados',[REPORTESCONTROLLERS::class, 'reportesFinalizados'])->name('Reportes Finalizados')->middleware(['S:Soporte,Encargado,Jefe Tecnico,Administracion,Operador,Tecnico']);
//DERIVADOS A SOPORTE
Route::get('/reportes/derivados/soporte',[HomeController::class, 'reportesSoporte'])->name('Reportes Derivado a Soporte')->middleware(['S:Soporte,Encargado,Jefe Tecnico,Administracion,Operador,Tecnico']);
Route::get('/reportes/derivados/soporte',[REPORTESCONTROLLERS::class, 'reportesSoporte'])->name('Reportes Derivado a Soporte')->middleware(['S:Soporte,Encargado,Jefe Tecnico,Administracion,Operador,Tecnico']);
//DERIVADO A JEFE TECNICO
//DERIVADOS A SOPORTE
Route::get('/reportes/derivados/jefe/tecnicos',[HomeController::class, 'reportesJTecnico'])->name('Reportes Derivado a Jefe Tecnico')->middleware(['S:Soporte,Encargado,Jefe Tecnico,Administracion,Operador,Tecnico']);
Route::get('/reportes/derivados/jefe/tecnicos',[REPORTESCONTROLLERS::class, 'reportesJTecnico'])->name('Reportes Derivado a Jefe Tecnico')->middleware(['S:Soporte,Encargado,Jefe Tecnico,Administracion,Operador,Tecnico']);
//DETALLE REPORTE
Route::get('/detalle/reporte/{id}', [HomeController::class, 'detalleReporte'])->name('Detalle Reporte')->middleware(['S:Soporte,Encargado,Jefe Tecnico,Administracion,Operador,Tecnico']);
Route::get('/detalle/reporte/{id}', [REPORTESCONTROLLERS::class, 'detalleReporte'])->name('Detalle Reporte')->middleware(['S:Soporte,Encargado,Jefe Tecnico,Administracion,Operador,Tecnico']);
//AGREGAR REVISION
Route::get('/agregar/revision/{id}', [HomeController::class, 'agregarRevision'])->name('Agregar Revisión')->middleware(['S:Soporte,Jefe Tecnico,Administracion']);
Route::get('/agregar/revision/{id}', [REPORTESCONTROLLERS::class, 'edit'])->name('Agregar Revisión')->middleware(['S:Soporte,Jefe Tecnico,Administracion']);
//POST AGREGAR REVISION
Route::post('/agregar/revision/listo/{id}', [REPORTESCONTROLLERS::class, 'agregarRevision'])->name('agregar.revision')->middleware(['S:Soporte,Jefe Tecnico,Administracion,Tecnico']);

//ODTS:

//ASIGANAR ODT A TECNICOS
Route::get('/asignar/odt', [HomeController::class, 'asignarODT'])->name('Asignar ODT')->middleware(['S:Soporte,Jefe Tecnico,Administracion,Tecnico']);
//POST PARA ASIGNAR ODT
Route::post('/asignar/odt/generando/{id}', [REPORTESCONTROLLERS::class, 'crearODTRep'])->name('asignar.odt')->middleware(['S:Soporte,Jefe Tecnico,Administracion,Tecnico']);
//LISTAR ODT
Route::get('/odts', [HomeController::class, 'listarODTS'])->name("ODT'S")->middleware(['S:Soporte,Jefe Tecnico,Administracion,Tecnico']); 
Route::get('/odts', [ODTSController::class, 'index'])->name("ODT'S")->middleware(['S:Soporte,Jefe Tecnico,Administracion,Tecnico']);

//CREAR ODT
Route::get('/crear/odt', [ODTSController::class, 'crearODT'])->name("Crear ODT")->middleware(['S:Jefe Tecnico']);
Route::post('/generar/odt/sin/reporte', [ODTSController::class, 'generarODT'])->name('crear.odt')->middleware(['S:Jefe Tecnico']);

//ODTS POR TECNICO
Route::get('/odts/tecnicos', [HomeController::class, 'listarODTSTecnicos'])->name("ODT'S Tecnicos")->middleware(['S:Soporte,Jefe Tecnico,Administracion,Tecnico']); 
Route::get('/odts/tecnicos', [ODTSController::class, 'ODTsTecnicos'])->name("ODT'S Tecnicos")->middleware(['S:Soporte,Jefe Tecnico,Administracion,Tecnico']);

//ODTS CAMBIAR EN PROCESO
Route::get('/odts/cambio/estado/{id}', [ODTSController::class, 'estadoEnProceso'])->name("cambiar.proceso")->middleware(['S:Soporte,Jefe Tecnico,Administracion,Tecnico']);

//ODTS CERRAR
Route::get('/odt/cerrar/{id}', [HomeController::class, 'cerrarODT'])->name('Cerrar ODT')->middleware(['S:Soporte,Jefe Tecnico,Administracion,Tecnico']);
Route::post('/odt/cerrar/imagenes/{id}', [ODTSController::class, 'imagenODT'])->name('guardar.imagen')->middleware(['S:Soporte,Jefe Tecnico,Administracion,Tecnico']);
Route::post('/odt/cerrar/detalle/{id}', [ODTSController::class, 'cerrarODT'])->name('cerrar.odt')->middleware(['S:Soporte,Jefe Tecnico,Administracion,Tecnico']);


//PRUEBA RELACIONES
Route::get('/relaciones', [REPORTESCONTROLLERS::class, 'relaciones']);


//PRUEBA GENERAR NUMERO DE TICKET ALEATORIO

//Route::get('/prueba',[REPORTESCONTROLLERS::class, 'TICKETS']);







