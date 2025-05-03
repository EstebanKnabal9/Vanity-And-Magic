@extends('Layout.Plantilla')

@section('titulomain')
Categorias / Editar
@endsection

@section('contenido')
<div class="container-formulario">
    <div class="card formulario">
        <h2>Editar Categoria</h2>
        <form action="{{ route('categorias.update', $categoria->id) }}" method="POST">
            @csrf
            @method('PUT') <!-- Esto es necesario para que se realice una actualización en lugar de una creación -->

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $categoria->nombre) }}" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <input type="text" id="descripcion" name="descripcion" value="{{ old('descripcion', $categoria->descripcion) }}">
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required>
                    <option value="1" {{ $categoria->estado == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $categoria->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Guardar Cambios</button>
            </div>
        </form>
    </div>
</div>
@endsection
