@extends('Layout.Plantilla')

@section('titulomain')
<a href="{{ route('productos.index') }}">Productos</a> /
<span>Agregar</span>
@endsection

@section('contenido')
<div class="container-formulario">
    <div class="card formulario">
        <h2>Crear Nuevo Producto</h2>
        <form action="{{ route('productos.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="nombre">Nombre del Producto</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="precio">Precio</label>
                <input type="number" step="0.01" id="precio" name="precio" required>
            </div>

            <div class="form-group">
                <label for="stock">Stock Inicial</label>
                <input type="number" id="stock" name="stock" required>
            </div>

            <div class="form-group">
                <label for="codigo">Código del Producto (SKU)</label>
                <input type="text" id="codigo" name="codigo">
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>

            <div class="form-group">
                <label for="categoria_id">Categoría</label>
                <select id="categoria_id" name="categoria_id" required>
                    <option value=""> Selecciona una categoría </option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="subcategoria_id">Subcategoría</label>
                <select id="subcategoria_id" name="subcategoria_id">
                    <option value=""> Seleccione una subcategoria </option>
                    @foreach($subcategorias as $subcategoria)
                        <option value="{{ $subcategoria->id }}">{{ $subcategoria->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Guardar Producto</button>
            </div>
        </form>
    </div>
</div>
@endsection