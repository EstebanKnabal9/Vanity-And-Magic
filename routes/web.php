<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoriaController;
use App\Http\Controllers\SubcategoriaController;
use App\Http\Controllers\ProductosController;
use App\Http\Controllers\ProveedorController;
use App\Http\Controllers\IngresoController;
use App\Http\Controllers\EgresoController;

Route::get('/', function () {
    return view('welcome');
});

//INICIO
Route::get('/panel', function () {
    return view('Inicio.inicio');
})->name('panel.inicio');

// CRUD de Categorías
Route::resource('categorias', CategoriaController::class);

// CRUD de Subcategorías
Route::resource('subcategorias', SubcategoriaController::class);

// CRUD de Productos
Route::resource('productos', ProductosController::class);

//CRUD de Proveedores
Route::resource('proveedores', ProveedorController::class);

//CRUD de Ingresos
Route::resource('ingresos', IngresoController::class);

//CRUD de Egresos
Route::resource('egresos', EgresoController::class);
