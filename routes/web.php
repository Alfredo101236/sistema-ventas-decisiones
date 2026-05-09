<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ModuloController;
use App\Http\Controllers\UsuarioController;
use App\Http\Controllers\CsvController;
use App\Http\Controllers\LimpiezaController;
use App\Http\Controllers\VentaController;
use App\Http\Controllers\ReporteController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Ruta inicial
|--------------------------------------------------------------------------
*/

Route::get('/', function () {
    return redirect()->route('login');
});

/*
|--------------------------------------------------------------------------
| Autenticación
|--------------------------------------------------------------------------
*/

Route::get('/login', [AuthController::class, 'showLogin'])
    ->name('login');

Route::post('/login', [AuthController::class, 'login'])
    ->name('login.post');

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

/*
|--------------------------------------------------------------------------
| Redirección general según rol
|--------------------------------------------------------------------------
*/

Route::get('/dashboard', function () {
    $role = auth()->user()->role;

    return match ($role) {
        'administrador' => redirect()->route('admin.dashboard'),
        'analista' => redirect()->route('analista.dashboard'),
        'gerente' => redirect()->route('gerente.dashboard'),
        default => redirect()->route('login'),
    };
})->middleware('auth')->name('dashboard');

/*
|--------------------------------------------------------------------------
| Rutas del Administrador
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:administrador'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Gestión de usuarios
        |--------------------------------------------------------------------------
        */

        Route::get('/usuarios', [UsuarioController::class, 'index'])
            ->name('usuarios.index');

        Route::get('/usuarios/crear', [UsuarioController::class, 'create'])
            ->name('usuarios.create');

        Route::post('/usuarios', [UsuarioController::class, 'store'])
            ->name('usuarios.store');

        Route::get('/usuarios/{usuario}/editar', [UsuarioController::class, 'edit'])
            ->name('usuarios.edit');

        Route::put('/usuarios/{usuario}', [UsuarioController::class, 'update'])
            ->name('usuarios.update');

        Route::delete('/usuarios/{usuario}', [UsuarioController::class, 'destroy'])
            ->name('usuarios.destroy');

        /*
        |--------------------------------------------------------------------------
        | Carga de archivo CSV
        |--------------------------------------------------------------------------
        */

        Route::get('/cargar-csv', [CsvController::class, 'index'])
            ->name('csv.index');

        Route::post('/cargar-csv', [CsvController::class, 'store'])
            ->name('csv.store');

        /*
        |--------------------------------------------------------------------------
        | Limpieza de datos
        |--------------------------------------------------------------------------
        */

        Route::get('/limpieza', [LimpiezaController::class, 'index'])
            ->name('limpieza.index');

        Route::post('/limpieza/procesar', [LimpiezaController::class, 'procesar'])
            ->name('limpieza.procesar');

        /*
        |--------------------------------------------------------------------------
        | Ventas
        |--------------------------------------------------------------------------
        */

        Route::get('/ventas', [VentaController::class, 'index'])
            ->name('ventas.index');

        /*
        |--------------------------------------------------------------------------
        | Reportes
        |--------------------------------------------------------------------------
        */

        Route::get('/reportes', [ReporteController::class, 'index'])
            ->name('reportes.index');
    });

/*
|--------------------------------------------------------------------------
| Rutas del Analista de Ventas
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:analista'])
    ->prefix('analista')
    ->name('analista.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('analista.dashboard');
        })->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Limpieza de datos
        |--------------------------------------------------------------------------
        */

        Route::get('/limpieza', [LimpiezaController::class, 'index'])
            ->name('limpieza.index');

        Route::post('/limpieza/procesar', [LimpiezaController::class, 'procesar'])
            ->name('limpieza.procesar');

        /*
        |--------------------------------------------------------------------------
        | Ventas
        |--------------------------------------------------------------------------
        */

        Route::get('/ventas', [VentaController::class, 'index'])
            ->name('ventas.index');

        /*
        |--------------------------------------------------------------------------
        | Análisis descriptivo
        |--------------------------------------------------------------------------
        */

        Route::get('/analisis', [ModuloController::class, 'analisis'])
            ->name('analisis.index');

        /*
        |--------------------------------------------------------------------------
        | Consultas SQL
        |--------------------------------------------------------------------------
        */

        Route::get('/consultas-sql', [ModuloController::class, 'consultas'])
            ->name('consultas.index');

        /*
        |--------------------------------------------------------------------------
        | Predicción
        |--------------------------------------------------------------------------
        */

        Route::get('/prediccion', [ModuloController::class, 'prediccion'])
            ->name('prediccion.index');
    });

/*
|--------------------------------------------------------------------------
| Rutas del Gerente Comercial
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:gerente'])
    ->prefix('gerente')
    ->name('gerente.')
    ->group(function () {

        Route::get('/dashboard', function () {
            return view('gerente.dashboard');
        })->name('dashboard');

        /*
        |--------------------------------------------------------------------------
        | Análisis descriptivo
        |--------------------------------------------------------------------------
        */

        Route::get('/analisis', [ModuloController::class, 'analisis'])
            ->name('analisis.index');

        /*
        |--------------------------------------------------------------------------
        | Predicción
        |--------------------------------------------------------------------------
        */

        Route::get('/prediccion', [ModuloController::class, 'prediccion'])
            ->name('prediccion.index');

        /*
        |--------------------------------------------------------------------------
        | Propuestas de decisión
        |--------------------------------------------------------------------------
        */

        Route::get('/propuestas', [ModuloController::class, 'propuestas'])
            ->name('propuestas.index');

        /*
        |--------------------------------------------------------------------------
        | Reportes
        |--------------------------------------------------------------------------
        */

        Route::get('/reportes', [ReporteController::class, 'index'])
            ->name('reportes.index');
    });