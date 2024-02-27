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
use App\Http\Middleware\RedirectIfSessionActive;
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
Route::get('/odt/generar/pdf/{id}', [ODTSController::class, 'generarPDF'])->name('pdf_odt')->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);

//Route::get('/', function () {
//    return USUARIO::all();
//});
Route::get('/', function () {
    Route::get('/reportes', [HomeController::class, 'listarTodosReportes'])->name('Reportes General')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
})->middleware('guest');


//RUTAS DE PAGINA
Route::get('/login', [HomeController::class, 'login'])->name('login');




Route::get('/logout' , [USUARIOS::class, 'logout'])->name('logout');

//POST INCIO DE SESION
Route::post('/USUARIO/LOGIN',[USUARIOS::class, 'login'])->name('USUARIO.LOGIN');
//POST AGREGAR REPORTE.
Route::post('/almacenar/reporte', [REPORTESCONTROLLERS::class, 'store'])->name('agregar.reporte')->middleware(['S:Soporte-I,Encargado,Soporte-J,Administrador']);

//SELECT SUCURSALES EN AGREGAR REPORTE.
Route::get('/agregar_reporte', [HomeController::class, 'agregar_reporte'])->name('Agregar Reporte')->middleware(['S:Soporte-I,Encargado,Soporte-J,Administrador']);
Route::get('/agregar_reporte', [SUCURSALCONTROLLERS::class, 'index'])->name('Agregar Reporte')->middleware(['S:Soporte-I,Encargado,Soporte-J,Administrador']);


//REPORTE LISTAR
//DERIVADO A Soporte-J
Route::get('/reportes/derivados/jefe/tecnicos',[HomeController::class, 'reportesJTecnico'])->name('Reportes Derivado a Jefe Tecnico')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
Route::get('/reportes/derivados/jefe/tecnicos',[REPORTESCONTROLLERS::class, 'reportesJTecnico'])->name('Reportes Derivado a Jefe Tecnico')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
//GENERAL
Route::get('/reportes', [HomeController::class, 'listarTodosReportes'])->name('Reportes General')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
Route::get('/reportes/buscar', [REPORTESCONTROLLERS::class, 'mostrarAllReportes'])->name('reportes.buscar')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
//FINALIZADOS
Route::get('/reportes/finalizados',[HomeController::class, 'reportesFinalizados'])->name('Reportes Finalizados')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
Route::get('/reportes/finalizados',[REPORTESCONTROLLERS::class, 'reportesFinalizados'])->name('Reportes Finalizados')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
//DERIVADOS A SOPORTE
Route::get('/reportes/derivados/soporte',[HomeController::class, 'reportesSoporte'])->name('Reportes Derivado a Soporte')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
Route::get('/reportes/derivados/soporte',[REPORTESCONTROLLERS::class, 'reportesSoporte'])->name('Reportes Derivado a Soporte')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);

//REPORTES LOCALES
Route::get('/reportes/locales', [HomeController::class, 'reportesLocales'])->name('Reportes Locales')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
Route::get('/reportes/locales', [REPORTESCONTROLLERS::class, 'reportesLocales'])->name('Reportes Locales')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);

//DERIVADO A TECNICOS
Route::get('/reportes/derivados/tecnicos',[HomeController::class, 'reportesTecnico'])->name('Reportes Derivado a Tecnicos')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
Route::get('/reportes/derivados/tecnicos',[REPORTESCONTROLLERS::class, 'reportesTecnicos'])->name('Reportes Derivado a Tecnicos')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);

//DERIVADO A CLIENTE
Route::get('/reportes/derivados/clientes',[HomeController::class, 'reportesDClientes'])->name('Reportes Derivado a Clientes')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
Route::get('/reportes/derivados/clientes',[REPORTESCONTROLLERS::class, 'reportesDClientes'])->name('Reportes Derivado a Clientes')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
//FALLA LOCAL
Route::get('/repostes/falla/local', [HomeController::class, 'reportesLocales'])->name('Reportes Locales')->middleware(['S:Soporte-I,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
Route::get('/repostes/falla/local', [REPORTESCONTROLLERS::class, 'reportesLocales'])->name('Reportes Locales')->middleware(['S:Soporte-I,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
//FINALIZAR FALLA LOCAL
Route::post('/reportes/falla/local/finalizar/{id}', [REPORTESCONTROLLERS::class, 'localTerminado'])->name('finalizar_reporte')->middleware(['S:Soporte,Administrador']);

//DETALLE REPORTE
Route::get('/detalle/reporte/{id}', [HomeController::class, 'detalleReporte'])->name('Detalle Reporte')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
Route::get('/detalle/reporte/{id}', [REPORTESCONTROLLERS::class, 'detalleReporte'])->name('Detalle Reporte')->middleware(['S:Soporte,Encargado,Soporte-J,Administrador,Operador,Tecnico']);
//AGREGAR REVISION
Route::get('/agregar/revision/{id}', [HomeController::class, 'agregarRevision'])->name('Agregar Revisión')->middleware(['S:Soporte-I,Soporte-J,Administrador']);
Route::get('/agregar/revision/{id}', [REPORTESCONTROLLERS::class, 'edit'])->name('Agregar Revisión')->middleware(['S:Soporte-I,Soporte-J,Administrador']);
//POST AGREGAR REVISION
Route::post('/agregar/revision/listo/{id}', [REPORTESCONTROLLERS::class, 'agregarRevision'])->name('agregar.revision')->middleware(['S:Soporte-I,Soporte-J,Administrador,Tecnico']);

//ODTS:

//LISTAR ODT
Route::get('/odts', [HomeController::class, 'listarODTS'])->name("ODT'S")->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']); 
Route::get('/odts', [ODTSController::class, 'index'])->name("ODT'S")->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);

//CREAR ODT
Route::get('/crear/odt', [ODTSController::class, 'crearODT'])->name("Crear ODT")->middleware(['S:Soporte-J,Administrador']);
Route::post('/crear/odt/imagenes/{id}', [ODTSController::class, 'imagenIndODT'])->name('guardar.imagenInd')->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);
Route::post('/generar/odt/sin/reporte', [ODTSController::class, 'generarODT'])->name('crear.odt')->middleware(['S:Soporte-J,Administrador']);


//DETALLE DE ODT
Route::get('/odts/detalle/{id}', [ODTSController::class, 'detalleOdt'])->name("Detalle ODT")->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);


//ODTS POR TECNICO
Route::get('/odts/tecnicos', [HomeController::class, 'listarODTSTecnicos'])->name("ODT'S Tecnicos")->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']); 
Route::get('/odts/tecnicos', [ODTSController::class, 'ODTsTecnicos'])->name("ODT'S Tecnicos")->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);


//ODTS EN CAMINO
Route::get('/odt/cambio/estado/enCamino/{id}', [ODTSController::class, 'estadoEnCamino'])->name('en.camino')->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);

//ODTS CAMBIAR EN PROCESO
Route::get('/odts/cambio/estado/{id}', [ODTSController::class, 'estadoEnProceso'])->name("cambiar.proceso")->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);

//ODTS CERRAR
Route::get('/odt/cerrar/{id}', [HomeController::class, 'cerrarODT'])->name('Cerrar ODT')->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);
Route::post('/odt/cerrar/imagenes/{id}', [ODTSController::class, 'imagenODT'])->name('guardar.imagen')->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);
Route::post('/odt/cerrar/detalle/{id}', [ODTSController::class, 'cerrarODT'])->name('cerrar.odt')->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);


//ACTUALIZAR ASIGNACION ODT:
Route::get('/odt/reasignar/{id}', [ODTSController::class, 'edit'])->name('Reasignar ODT')->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);
//Route::get('/odt/reasignar/{id}', [HomeController::class, 'reasignarODT'])->name('Reasignar ODT')->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);
Route::post('/odt/reasignando/{id}', [ODTSController::class, 'update'])->name('reasignar.odt')->middleware(['S:Soporte,Soporte-J,Administrador,Tecnico']);

//PRUEBA RELACIONES
//Route::get('/relaciones', [REPORTESCONTROLLERS::class, 'relaciones']);

//Route::get('/puebaEmail', [REPORTESCONTROLLERS::class, 'pruebaEmail']);
//PRUEBA GENERAR NUMERO DE TICKET ALEATORIO

//Route::get('/prueba',[REPORTESCONTROLLERS::class, 'TICKETS']);

//PRUEBA ULTIMA ID ODT
//Route::get('/pruebaIDODT', [ODTSController::class, 'pruebaID']);






