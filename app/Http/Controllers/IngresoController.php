<?php

namespace App\Http\Controllers;

use App\Models\Ingreso;
use App\Models\Producto;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class IngresoController extends Controller
{
    public function index()
    {
        // Cambié Producto::all() por Ingreso::all() para obtener los ingresos
        $ingresos = Ingreso::all(); 
        return view('Ingresos.index', compact('ingresos'));
    }

    // Método para crear un nuevo ingreso
    public function create()
    {
        // Pasando productos y proveedores a la vista
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        return view('Ingresos.create', compact('productos', 'proveedores'));
    }

    // Método para almacenar un nuevo ingreso
    public function store(Request $request)
    {
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.01',
            'precio_unitario' => 'required|numeric|min:0',
            'documento' => 'nullable|string'
        ]);
    
        DB::transaction(function () use ($validated) {
            $ingreso = Ingreso::create($validated + ['user_id' => auth()->id()]);
            
            Movimiento::create([
                'producto_id' => $validated['producto_id'],
                'tipo' => 'ingreso',
                'cantidad' => $validated['cantidad'],
                'precio_unitario' => $validated['precio_unitario'],
                'documento' => $validated['documento'],
                'ingreso_id' => $ingreso->id,
                // 'user_id' => auth()->id()
            ]);
        });
    
        return redirect()->route('ingresos.index')
            ->with('success', 'Ingreso registrado correctamente');
    }


    // Método para editar un ingreso existente
    public function edit($id)
    {
        // Obtener el ingreso a editar y productos y proveedores
        $ingreso = Ingreso::findOrFail($id);
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        return view('Ingresos.edit', compact('ingreso', 'productos', 'proveedores'));
    }

    // Método para actualizar un ingreso
    public function update(Request $request, $id)
    {
        $ingreso = Ingreso::findOrFail($id);

        // Validación de los datos
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:1',
            'costo_unitario' => 'required|numeric|min:0',
            'tipo_ingreso' => 'required|string|max:255',
            'documento' => 'nullable|string|max:255',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'observacion' => 'nullable|string|max:500',
            'fecha_ingreso' => 'required|date',
        ]);

        // Calcular el costo total
        $validated['costo_total'] = $validated['cantidad'] * $validated['costo_unitario'];

        // Actualizar el ingreso
        $ingreso->update($validated);

        return redirect()->route('ingresos.index')->with('success', 'Ingreso actualizado correctamente.');
    }

    // Método para eliminar un ingreso
    public function destroy($id)
    {
        $ingreso = Ingreso::findOrFail($id);
        $ingreso->delete();

        return redirect()->route('ingresos.index')->with('success', 'Ingreso eliminado correctamente.');
    }
}
