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
    return redirect()->route('categoria.index');
}

    /**
     * Display the specified resource.
     */
    public function show(Categoria $categoria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Categoria $categoria)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Categoria $categoria)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $categoria=Categoria::findOrFail($id);
        $categoria->delete();
        return redirect()->route('categoria.index');
    }
}
