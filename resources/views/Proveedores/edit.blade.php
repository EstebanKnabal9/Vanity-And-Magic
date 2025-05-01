@extends('Layout.Plantilla')

@section('titulomain')
Editar Proveedor
@endsection

@section('contenido')
<div class="container-formulario">
    <div class="card formulario">
        <h2>Editar Proveedor</h2>
        <form action="{{ route('proveedores.update', $proveedor->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $proveedor->nombre) }}" required>
                @error('nombre')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="identificacion">Identificación</label>
                <input type="text" id="identificacion" name="identificacion" value="{{ old('identificacion', $proveedor->identificacion) }}" required>
                @error('identificacion')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4" placeholder="Descripción del proveedor..."></textarea>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono" value="{{ old('telefono', $proveedor->telefono) }}">
                @error('telefono')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="correo">Correo</label>
                <input type="email" id="correo" name="correo" value="{{ old('correo', $proveedor->correo) }}">
                @error('correo')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion" value="{{ old('direccion', $proveedor->direccion) }}">
                @error('direccion')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required>
                    <option value="1" {{ $proveedor->estado == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $proveedor->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
                @error('estado')
                    <div class="error">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <button type="submit">Actualizar Proveedor</button>
            </div>
        </form>
    </div>
</div>
@endsection
