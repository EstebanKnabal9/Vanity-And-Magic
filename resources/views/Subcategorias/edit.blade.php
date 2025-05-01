@extends('Layout.Plantilla')

@section('titulomain')
Subcategorias / Editar
@endsection

@section('contenido')
<div class="container-formulario">
    <div class="card formulario">
        <h2>Editar Subcategoria</h2>
        <form action="{{ route('subcategorias.update', $subcategoria->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Indicamos que es una actualización -->

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $subcategoria->nombre) }}" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion', $subcategoria->descripcion) }}">
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required>
                    <option value="1" {{ $subcategoria->estado == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $subcategoria->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="categoria_id">Categoría</label>
                <select id="categoria_id" name="categoria_id" required>
                    <option value="">Selecciona una categoría</option>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ $subcategoria->categoria_id == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
