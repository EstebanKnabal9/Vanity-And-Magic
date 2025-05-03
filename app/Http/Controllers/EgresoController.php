<?php

namespace App\Http\Controllers;

use App\Models\Egreso;
use App\Models\Producto;
use App\Models\Proveedor;
use App\Models\Movimiento; // Importación añadida
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class EgresoController extends Controller
{
    public function index()
    {
        $egresos = Egreso::with(['producto', 'proveedor', 'movimiento'])
            ->latest()
            ->paginate(10); // Paginación añadida
        
        return view('Egresos.index', compact('egresos'));
    }

    public function create()
    {
        $productos = Producto::where('estado', 1)->get(); // Solo productos activos
        $proveedores = Proveedor::where('estado', 1)->get();
        
        return view('Egresos.create', compact('productos', 'proveedores'));
    }
    
    public function store(Request $request)
{
    $validated = $request->validate([
        'producto_id'    => 'required|exists:productos,id',
        'cantidad'       => 'required|numeric|min:0.01',
        'costo_unitario' => 'required|numeric|min:0',
        'costo_total' => 'required|numeric|min:0',
        'tipo_egreso'   => 'required|in:venta,devolucion_proveedor,ajuste_negativo,consumo_interno',
        'documento'      => 'nullable|string|max:50',
        'proveedor_id'   => 'nullable|required_if:tipo_egreso,devolucion_proveedor|exists:proveedores,id',
        'observacion'    => 'nullable|string|max:255',
        'fecha_egreso'   => 'required|date',
    ]);

    DB::transaction(function () use ($validated) {
        $producto = Producto::findOrFail($validated['producto_id']);
        
        if (in_array($validated['tipo_egreso'], ['venta', 'consumo_interno'])) {
            if ($producto->stock_actual < $validated['cantidad']) {
                throw ValidationException::withMessages([
                    'cantidad' => "Stock insuficiente. Disponible: {$producto->stock_actual}"
                ]);
            }
        }

        $egreso = Egreso::create([
            'producto_id' => $validated['producto_id'],
            'proveedor_id' => $validated['proveedor_id'] ?? null,
            'cantidad' => $validated['cantidad'],
            'costo_unitario' => $validated['costo_unitario'],
            'costo_total' => $validated['cantidad'] * $validated['costo_unitario'],
            'tipo_egreso' => $validated['tipo_egreso'],
            'documento' => $validated['documento'] ?? null,
            'observacion' => $validated['observacion'] ?? null,
            'fecha_egreso' => $validated['fecha_egreso']
        ]);

        Movimiento::create([
            'producto_id' => $validated['producto_id'],
            'tipo' => 'egreso',
            'cantidad' => $validated['cantidad'],
            'precio_unitario' => $validated['costo_unitario'],
            'documento' => $validated['documento'] ?? null,
            'egreso_id' => $egreso->id,
            'observacion' => $validated['observacion'] ?? null,
            'created_at' => $validated['fecha_egreso']
        ]);

        // Actualizar stock si es necesario
        if (in_array($validated['tipo_egreso'], ['venta', 'consumo_interno'])) {
            $producto->decrement('stock_actual', $validated['cantidad']);
        }
    });

    return redirect()->route('egresos.index')
        ->with('success', 'Egreso registrado correctamente.');
}

    public function edit(Egreso $egreso)
    {
        $productos = Producto::where('estado', 1)->get();
        $proveedores = Proveedor::where('estado', 1)->get();
        
        return view('Egresos.edit', [
            'egreso' => $egreso->load('movimiento'),
            'productos' => $productos,
            'proveedores' => $proveedores
        ]);
    }

    public function update(Request $request, Egreso $egreso)
    {
        $validated = $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'cantidad' => 'required|numeric|min:0.01',
            'costo_unitario' => 'required|numeric|min:0',
            'tipo_egreso' => 'required|in:venta,devolucion_proveedor,ajuste_negativo,consumo_interno',
            'documento' => 'nullable|string|max:50',
            'proveedor_id' => 'nullable|required_if:tipo_egreso,devolucion_proveedor|exists:proveedores,id',
            'observacion' => 'nullable|string|max:255',
            'fecha_egreso' => 'required|date',
        ]);

        $validated['costo_total'] = $validated['cantidad'] * $validated['costo_unitario'];

        DB::transaction(function () use ($validated, $egreso) {
            // Actualizar el egreso
            $egreso->update($validated);
            
            // Actualizar el movimiento relacionado
            $egreso->movimiento()->update([
                'producto_id' => $validated['producto_id'],
                'cantidad' => $validated['cantidad'],
                'precio_unitario' => $validated['costo_unitario'],
                'documento' => $validated['documento'] ?? null,
                'observacion' => $validated['observacion'] ?? null,
                'created_at' => $validated['fecha_egreso']
            ]);
        });

        return redirect()->route('egresos.index')
            ->with('success', 'Egreso actualizado correctamente.');
    }

    public function destroy(Egreso $egreso)
    {
        DB::transaction(function () use ($egreso) {
            // Eliminar el movimiento primero
            $egreso->movimiento()->delete();
            // Luego eliminar el egreso
            $egreso->delete();
        });

        return redirect()->route('egresos.index')
            ->with('success', 'Egreso eliminado correctamente.');
    }
}