@extends('Layout.Plantilla')

@section('titulomain')
Productos / Editar
@endsection

@section('contenido')
<div class="container-formulario">
    <div class="card formulario">
        <h2>Editar Producto</h2>
        <form action="{{ route('productos.update', $producto->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="nombre">Nombre</label>
                <input type="text" id="nombre" name="nombre" value="{{ old('nombre', $producto->nombre) }}" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion">{{ old('descripcion', $producto->descripcion) }}</textarea>
            </div>

            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" id="precio" name="precio" value="{{ old('precio', $producto->precio) }}" required min="0">
            </div>

            <div class="form-group">
                <label for="stock">Stock</label>
                <input type="number" id="stock" name="stock" value="{{ old('stock', $producto->stock) }}" required min="0">
            </div>

            <div class="form-group">
                <label for="codigo">Código</label>
                <input type="text" id="codigo" name="codigo" value="{{ old('codigo', $producto->codigo) }}">
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required>
                    <option value="1" {{ $producto->estado == 1 ? 'selected' : '' }}>Activo</option>
                    <option value="0" {{ $producto->estado == 0 ? 'selected' : '' }}>Inactivo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="categoria_id">Categoría</label>
                <select id="categoria_id" name="categoria_id" required>
                    @foreach ($categorias as $categoria)
                        <option value="{{ $categoria->id }}" {{ $producto->categoria_id == $categoria->id ? 'selected' : '' }}>
                            {{ $categoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="subcategoria_id">Subcategoría</label>
                <select id="subcategoria_id" name="subcategoria_id">
                    <option value="">Selecciona una subcategoría</option>
                    @foreach ($subcategorias as $subcategoria)
                        <option value="{{ $subcategoria->id }}" {{ $producto->subcategoria_id == $subcategoria->id ? 'selected' : '' }}>
                            {{ $subcategoria->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Actualizar Producto</button>
            </div>
        </form>
    </div>
</div>
@endsection
