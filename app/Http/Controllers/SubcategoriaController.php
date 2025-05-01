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

    public function edit($id)
    {
        $subcategoria = Subcategoria::findOrFail($id);
        return view('Subcategorias.edit', compact('subcategoria'));
    }

    public function update(Request $request, $id)
    {
        $validatedData = $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable',
            'estado' => 'required|boolean',
            'id_categoria' => 'required|exists:categorias,id',
        ]);

        $subcategoria = Subcategoria::findOrFail($id);
        $subcategoria->update($validatedData);

        return redirect()->route('subcategorias.index');
    }

    public function destroy($id)
    {
        $subcategoria = Subcategoria::findOrFail($id);
        $subcategoria->delete();

        return redirect()->route('subcategorias.index');
    }
}
