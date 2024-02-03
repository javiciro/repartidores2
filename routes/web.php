<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ConductoresController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\ReportesController;
use App\Http\Controllers\PlacaController;
use  Illuminate\Support\Facades\Mail;
use App\Mail\enviarCorreo;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\PermisoController;
use App\Http\Controllers\AsignarController;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Controllers\TesoreriaController;



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

Route::get('/', function () {
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');
    Route::resource('/roles', RolesController::class)->names('roles');//accede a la clase y todos los metodos que hay en los roles, como create etc
    Route::resource('/permisos',PermisoController::class)->names('permisos');//accede a las clases y todos  sus metodos
    Route::resource('/usuarios',AsignarController::class)->names('asignar');
    Route::resource('/tesoreria',TesoreriaController::class)->names('tesoreria');
    Route::get('/conductores/create', [ConductoresController::class, 'create'])->name('conductores.create'); //esta muestra el formulario de create para hacer regristro de un clienete
    Route::get('/conductores', [ConductoresController::class, 'index'])->name('conductores.index');
    Route::post('/conductores', [ConductoresController::class, 'store'])->name('conductores.store');  // esta hace el regristro del cleiente en la base de datos
    Route::get('/reportes', [ReportesController::class, 'index'])->name('reportes.index');
    Route::resource('agregarPlaca', PlacaController::class)->except(['show']);
    Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
    Route::patch('/tesoreria/editar-estado/{id}', [TesoreriaController::class, 'editarEstado'])->name('tesoreria.editar-estado');
    Route::get('/tesoreria/cambiar-estado/{id}', [TesoreriaController::class, 'cambiarEstado']);
    Route::get('/entregas/envio-correo', [ConductoresController::class, 'store'])->name('entregas.envio-correo');
    Route::get('/profile',[UsuarioController::class,'profiles']);
    Route::get('/reportes/diario', [ReportesController::class, 'diario'])->name('reportes.diario');
    Route::get('/reportes/mensual', [ReportesController::class, 'mensual'])->name('reportes.mensual');
    Route::get('/reportes/anual', [ReportesController::class, 'anual'])->name('reportes.anual');


});






