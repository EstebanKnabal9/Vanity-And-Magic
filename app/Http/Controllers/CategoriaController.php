<?php

namespace App\Http\Controllers;

use App\Models\Categoria;
use Illuminate\Http\Request;

class CategoriaController extends Controller
{
    public function index()
    {   
        $categorias = Categoria::all();
        return view('Categorias.index', compact('categorias'));
    }    

    public function create()
    {
        return view('Categorias.create');
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
        'nombre' => 'required|max:255',
        'descripcion' => 'nullable',
        'estado' => 'required|boolean',
    ]);

        $categoria = new Categoria();
        $categoria->nombre = $validatedData['nombre'];
        $categoria->descripcion = $validatedData['descripcion'];
        $categoria->estado = $validatedData['estado'];
        $categoria->save();
        return redirect()->route('categorias.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    public function edit(Categoria $categoria)
    {
        // Pasamos la categoría al formulario de edición
        return view('Categorias.edit', compact('categoria'));
    }

    public function update(Request $request, Categoria $categoria)
    {
        // Validamos los datos recibidos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'estado' => 'required|boolean',
        ]);

        // Actualizamos los campos de la categoría
        $categoria->nombre = $validatedData['nombre'];
        $categoria->descripcion = $validatedData['descripcion'];
        $categoria->estado = $validatedData['estado'];
        $categoria->save();

        // Redirigimos al índice de categorías
        return redirect()->route('categorias.index');
    }

    public function destroy($id)
    {
        $categoria = Categoria::findOrFail($id);
        $categoria->delete();
        return redirect()->route('categorias.index');
    }
}
