@extends('Layout.Plantilla')

@section('titulomain')
<a href="{{ route('productos.index') }}">Productos</a> / 
<span>Producto: {{ $producto->nombre }}</span>
@endsection

@section('contenido')

<section class="container-cards">

    <div class="card-show">
        <div class="cabecera">            
            <h2>{{ $producto->nombre }}</h2>                      
        </div>
        <ul>
            <li><strong>Descripción:</strong> {{ $producto->descripcion ?? 'Sin descripción' }}</li>
            <li><strong>Precio:</strong> ${{ number_format($producto->precio, 2) }}</li>
            <li><strong>Stock:</strong> {{ $producto->stock }}</li>
            <li><strong>Código:</strong> {{ $producto->codigo ?? 'No asignado' }}</li>
            <li><strong>Estado:</strong> {{ $producto->estado ? 'Activo' : 'Inactivo' }}</li>
            <li><strong>Categoría:</strong> {{ $producto->categoria->nombre ?? 'No asignada' }}</li>
            <li><strong>Subcategoría:</strong> {{ $producto->subcategoria->nombre ?? 'No asignada' }}</li>
        </ul>
    </div>

</section>

@endsection

