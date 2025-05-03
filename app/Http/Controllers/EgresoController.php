<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class EgresoController extends Controller
{
    // Mostrar todos los egresos
    public function index()
    {
        $egresos = Egreso::with('producto', 'proveedor')->latest()->get();
        return view('Egresos.index', compact('egresos'));
    }

    // Mostrar formulario para crear un nuevo egreso
    public function create()
    {
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        return view('Egresos.create', compact('productos', 'proveedores'));
    }

    // Guardar un nuevo egreso
    public function store(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'costo_unitario' => 'required|numeric|min:0',
            'tipo_egreso' => 'required|in:venta,devolucion_proveedor,ajuste_negativo,consumo_interno',
            'fecha_egreso' => 'required|date',
        ]);

        $egreso = Egreso::create([
            'producto_id' => $request->producto_id,
            'proveedor_id' => $request->proveedor_id,
            'cantidad' => $request->cantidad,
            'costo_unitario' => $request->costo_unitario,
            'costo_total' => $request->cantidad * $request->costo_unitario,
            'tipo_egreso' => $request->tipo_egreso,
            'documento' => 'EGR-' . uniqid(),
            'observacion' => $request->observacion,
            'fecha_egreso' => $request->fecha_egreso,
        ]);

        return redirect()->route('egresos.index')->with('success', 'Egreso registrado correctamente.');
    }

    // Mostrar un egreso específico
    public function show(Egreso $egreso)
    {
        return view('egresos.show', compact('egreso'));
    }

    // Mostrar formulario para editar un egreso
    public function edit(Egreso $egreso)
    {
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        return view('Egresos.edit', compact('egreso', 'productos', 'proveedores'));
    }

    // Actualizar un egreso
    public function update(Request $request, Egreso $egreso)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|integer|min:1',
            'costo_unitario' => 'required|numeric|min:0',
            'tipo_egreso' => 'required|in:venta,devolucion_proveedor,ajuste_negativo,consumo_interno',
            'fecha_egreso' => 'required|date',
        ]);

        $egreso->update([
            'producto_id' => $request->producto_id,
            'proveedor_id' => $request->proveedor_id,
            'cantidad' => $request->cantidad,
            'costo_unitario' => $request->costo_unitario,
            'costo_total' => $request->cantidad * $request->costo_unitario,
            'tipo_egreso' => $request->tipo_egreso,
            'observacion' => $request->observacion,
            'fecha_egreso' => $request->fecha_egreso,
        ]);

        return redirect()->route('egresos.index')->with('success', 'Egreso actualizado correctamente.');
    }

    // Eliminar un egreso
    public function destroy(Egreso $egreso)
    {
        $egreso->delete();
        return redirect()->route('egresos.index')->with('success', 'Egreso eliminado.');
    }
}
