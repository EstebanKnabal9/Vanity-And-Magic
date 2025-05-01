<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\Categoria;
use App\Models\Subcategoria;
use App\Models\Proveedor;
use Illuminate\Http\Request;

class ProductosController extends Controller
{
    // Llamado a Variables

    public function index()
    {
        $productos = Producto::all();
        return view('Productos.index', compact('productos'));
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }
    
    public function subcategoria()
    {
        return $this->belongsTo(Subcategoria::class, 'subcategoria_id');
    }

    public function proveedor()
    {
        return $this->belongsTo(Proveedor::class, 'subcategoria_id');
    }

    public function create()
    {
        $categorias = Categoria::all();
        $subcategorias = Subcategoria::all();
        return view('Productos.create', compact('categorias', 'subcategorias'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'codigo' => 'nullable|string|max:100|unique:productos,codigo',
            'estado' => 'required|boolean',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'nullable|exists:subcategorias,id',
        ]);

        Producto::create($validatedData);

        return redirect()->route('productos.index')->with('success', 'Producto creado correctamente.');
    }

    public function edit($id)
    {
        $producto = Producto::findOrFail($id); // Obtiene el producto por su id
        $categorias = Categoria::all(); // Obtiene todas las categorías
        $subcategorias = Subcategoria::all(); // Obtiene todas las subcategorías

        return view('Productos.edit', compact('producto', 'categorias', 'subcategorias')); // Pasa el producto, categorías y subcategorías a la vista
    }


    public function update(Request $request, $id)
    {
        $producto = Producto::findOrFail($id); // Encuentra el producto por su id
        
        // Valida los datos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'precio' => 'required|numeric|min:0',
            'stock' => 'required|integer|min:0',
            'codigo' => 'nullable|string|max:100|unique:productos,codigo,' . $producto->id,
            'estado' => 'required|boolean',
            'categoria_id' => 'required|exists:categorias,id',
            'subcategoria_id' => 'nullable|exists:subcategorias,id',
        ]);
    
        // Actualiza el producto con los datos validados
        $producto->update($validatedData);
    
        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente.');
    }


    public function destroy($id)
    {
        $producto = Producto::findOrFail($id);
        $producto->delete();

        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente.');
    }
}
