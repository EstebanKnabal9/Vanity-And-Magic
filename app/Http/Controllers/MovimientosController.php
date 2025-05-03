<?php

namespace App\Http\Controllers;

use App\Models\Movimiento;
use App\Models\Producto;
use App\Models\Ingreso;
use App\Models\Egreso;
use App\Models\Proveedor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class MovimientosController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Movimiento::with(['producto', 'ingreso', 'egreso'])
            ->orderBy('created_at', 'desc');

        // Filtros
        if ($request->filled('producto_id')) {
            $query->where('producto_id', $request->producto_id);
        }

        if ($request->filled('tipo')) {
            $query->where('tipo', $request->tipo);
        }

        if ($request->filled('fecha_inicio') && $request->filled('fecha_fin')) {
            $query->whereBetween('created_at', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ]);
        }

        $movimientos = $query->paginate(15);
        $productos = Producto::active()->get();

        return view('movimientos.index', compact('movimientos', 'productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // No se usa normalmente ya que los movimientos se crean
        // desde ingresos/egresos
        return redirect()->route('egresos.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Normalmente no se usa directamente, se crea desde Ingreso/Egreso
        return back()->with('error', 'Acción no permitida');
    }

    /**
     * Display the specified resource.
     */
    public function show(Movimiento $movimiento)
    {
        $movimiento->load(['producto', 'ingreso', 'egreso']);
        
        return view('movimientos.show', compact('movimiento'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Movimiento $movimiento)
    {
        // Los movimientos no deberían editarse directamente
        // Redirigir al ingreso/egreso relacionado
        if ($movimiento->ingreso_id) {
            return redirect()->route('ingresos.edit', $movimiento->ingreso_id);
        }
        
        if ($movimiento->egreso_id) {
            return redirect()->route('egresos.edit', $movimiento->egreso_id);
        }
        
        return back()->with('error', 'No se puede editar este movimiento directamente');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Movimiento $movimiento)
    {
        // Los movimientos no deberían actualizarse directamente
        return back()->with('error', 'Actualice el ingreso/egreso relacionado en lugar del movimiento');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Movimiento $movimiento)
    {
        DB::transaction(function () use ($movimiento) {
            // Eliminar el ingreso/egreso relacionado primero
            if ($movimiento->ingreso_id) {
                $movimiento->ingreso()->delete();
            } elseif ($movimiento->egreso_id) {
                $movimiento->egreso()->delete();
            }
            
            // Luego eliminar el movimiento
            $movimiento->delete();
        });

        return redirect()->route('movimientos.index')
            ->with('success', 'Movimiento y registro relacionado eliminados correctamente');
    }

    /**
     * Reporte de movimientos por producto
     */
    public function reporteProducto(Request $request)
    {
        $request->validate([
            'producto_id' => 'required|exists:productos,id',
            'fecha_inicio' => 'required|date',
            'fecha_fin' => 'required|date|after_or_equal:fecha_inicio'
        ]);

        $producto = Producto::with(['categoria', 'proveedor'])
            ->findOrFail($request->producto_id);

        $movimientos = Movimiento::where('producto_id', $request->producto_id)
            ->whereBetween('created_at', [
                Carbon::parse($request->fecha_inicio)->startOfDay(),
                Carbon::parse($request->fecha_fin)->endOfDay()
            ])
            ->orderBy('created_at', 'asc')
            ->get();

        $saldoInicial = Movimiento::where('producto_id', $request->producto_id)
            ->where('created_at', '<', $request->fecha_inicio)
            ->sum(DB::raw('CASE WHEN tipo = "ingreso" THEN cantidad ELSE -cantidad END'));

        return view('movimientos.reporte-producto', compact('producto', 'movimientos', 'saldoInicial'));
    }
}