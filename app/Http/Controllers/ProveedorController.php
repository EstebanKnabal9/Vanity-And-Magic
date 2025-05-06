<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Proveedor;  // Corregido: Importar el modelo Proveedor

class ProveedorController extends Controller
{
    public function index()
    {
        // Obtener todos los proveedores
        $proveedores = Proveedor::all();
        return view('Proveedores.index', compact('proveedores'));
    }

    public function create()
    {
        // Vista para crear un nuevo proveedor
        return view('Proveedores.create');
    }

    public function store(Request $request)
    {
        // Validación de datos
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'identificacion' => 'required|unique:proveedores,identificacion',
            'telefono' => 'nullable|max:20',
            'correo' => 'nullable|email|max:255',
            'direccion' => 'nullable|max:255',
            'estado' => 'required|boolean',
        ]);

        // Crear un nuevo proveedor
        Proveedor::create($validatedData);

        return redirect()->route('proveedores.index')->with('success', 'Proveedor creado correctamente.');
    }

    public function show($id)
    {
    // Buscar el proveedor por su ID
    $proveedor = Proveedor::findOrFail($id);

    // Retornar la vista con los datos del proveedor
    return view('Proveedores.show', compact('proveedor'));
    }

    public function edit($id)
    {   
        // Buscar el proveedor por ID
        $proveedor = Proveedor::findOrFail($id);
        return view('Proveedores.edit', compact('proveedor')); // Pasa el proveedor a la vista
    }


    public function update(Request $request, $id)
    {
        // Validación de datos para actualizar
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'identificacion' => 'required|unique:proveedores,identificacion,' . $id,
            'descripcion' => 'nullable|max:255', // Corregido
            'telefono' => 'nullable|max:20',
            'correo' => 'nullable|email|max:255',
            'direccion' => 'nullable|max:255',
            'estado' => 'required|boolean',
        ]);
    
        // Buscar el proveedor y actualizar
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->update($validatedData);
    
        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado correctamente.');
    }



    public function destroy($id)
    {
        // Buscar el proveedor por ID y eliminarlo
        $proveedor = Proveedor::findOrFail($id);
        $proveedor->delete();

        return redirect()->route('Proveedores.index')->with('success', 'Proveedor eliminado correctamente.');
    }
}
