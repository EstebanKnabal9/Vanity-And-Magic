<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EgresoController;

// Página inicial: login o welcome si está autenticado
Route::get('/', function () {
    if (Auth::check()) {
        return view('welcome');
    }
    return redirect()->route('login');
});

// Rutas protegidas: solo para usuarios autenticados
Route::middleware(['auth'])->group(function () {
    // Panel de inicio
    Route::get('/panel', function () {
        return view('Inicio.inicio');
    })->name('panel.inicio');

    // CRUDS
    Route::resource('categorias', CategoriaController::class);
    Route::resource('subcategorias', SubcategoriaController::class);
    Route::resource('productos', ProductosController::class);
    Route::resource('proveedores', ProveedorController::class);
    Route::resource('ingresos', IngresoController::class);
    Route::resource('egresos', EgresoController::class);
});

// Rutas de autenticación
require __DIR__.'/auth.php';
