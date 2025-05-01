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
            'cantidad' => 'required|numeric|min:1',
            'costo_unitario' => 'required|numeric|min:0',
            'tipo_ingreso' => 'required|string|max:255',
            'proveedor_id' => 'nullable|exists:proveedores,id',
            'observacion' => 'nullable|string|max:500',
            'fecha_ingreso' => 'required|date',
        ]);
    
        // Calcular el costo total
        $validated['costo_total'] = $validated['cantidad'] * $validated['costo_unitario'];
    
        // Obtener fecha en formato YYYYMMDD
        $fecha = date('Ymd', strtotime($validated['fecha_ingreso']));
    
        // Contar ingresos existentes del mismo tipo
        $conteo = Ingreso::where('tipo_ingreso', $validated['tipo_ingreso'])->count() + 1;
    
        // Generar el campo 'documento'
        switch (strtolower($validated['tipo_ingreso'])) {
            case 'compra':
                $validated['documento'] = 'FAC-' . str_pad($conteo, 4, '0', STR_PAD_LEFT);
                break;
            case 'ajuste':
                $validated['documento'] = 'AJUSTE-' . $fecha . '-' . str_pad($conteo, 3, '0', STR_PAD_LEFT);
                break;
            case 'devolucion':
                $validated['documento'] = 'DEVOLUCION-' . $fecha . '-' . str_pad($conteo, 3, '0', STR_PAD_LEFT);
                break;
            default:
                $validated['documento'] = 'DOC-' . $fecha . '-' . uniqid();
                break;
    }

    Ingreso::create($validated);

    return redirect()->route('ingresos.index')->with('success', 'Ingreso registrado correctamente.');
    }


    // Método para editar un ingreso existente
    public function edit($id)
    {
        // Obtener el ingreso a editar y productos y proveedores
        $ingreso = Ingreso::findOrFail($id);
        $productos = Producto::all();
        $proveedores = Proveedor::all();
        return view('ingresos.edit', compact('ingreso', 'productos', 'proveedores'));
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
