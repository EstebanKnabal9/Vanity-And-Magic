<?php

namespace App\Http\Controllers;

use App\Models\Subcategoria;
use App\Models\Categoria;
use Illuminate\Http\Request;


class SubcategoriaController extends Controller
{
    public function index()
    {
        $subcategorias = Subcategoria::all();
        return view('Subcategorias.index', compact('subcategorias'));
    }

    public function categoria()
    {
        return $this->belongsTo(Categoria::class, 'categoria_id');
    }

    public function create()
    {
        $categorias = Categoria::all(); // Trae todas las categorías para el select
        return view('Subcategorias.create', compact('categorias'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'estado' => 'required|boolean',
            'id_categoria' => 'required|exists:categorias,id',
        ]);

        Subcategoria::create($validatedData);

        return redirect()->route('subcategorias.index');
    }

    public function show($id)
    {
        // Buscar la subcategoría por su ID
        $subcategoria = Subcategoria::with('categoria')->findOrFail($id);
    
        // Retornar la vista con los datos de la subcategoría
        return view('Subcategorias.show', compact('subcategoria'));
    }
    
    
        public function edit($id)
    {
        // Obtenemos la subcategoría a editar
        $subcategoria = Subcategoria::findOrFail($id);
        // Traemos todas las categorías para mostrarlas en el select
        $categorias = Categoria::all();
        return view('Subcategorias.edit', compact('subcategoria', 'categorias'));
    }
    
    public function update(Request $request, $id)
    {
        // Validamos los datos recibidos del formulario
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'estado' => 'required|boolean',
            'categoria_id' => 'required|exists:categorias,id', // Aseguramos que la categoría existe
        ]);
    
        // Obtenemos la subcategoría que vamos a actualizar
        $subcategoria = Subcategoria::findOrFail($id);
        // Actualizamos los datos
        $subcategoria->update($validatedData);
    
        // Redirigimos al índice de subcategorías
        return redirect()->route('subcategorias.index');
    }

    public function destroy($id)
    {
        $subcategoria = Subcategoria::findOrFail($id);
        $subcategoria->delete();

        return redirect()->route('subcategorias.index');
    }
}
