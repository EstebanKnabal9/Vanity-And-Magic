@extends('Layout.Plantilla')

@section('titulomain')
<a href="{{ route('subcategorias.index') }}">Subcategorías</a> / 
<span>Subcategoría {{ $subcategoria->nombre }}</span>
@endsection

@section('contenido')

<section class="container-cards">

    <div class="card-show">
        <div class="cabecera">            
            <h2>Subcategoría: {{ $subcategoria->nombre }}</h2>                      
        </div>
        <ul>
            <li><strong>Descripción:</strong> {{ $subcategoria->descripcion ?? 'Sin descripción' }}</li>
            <li><strong>Estado:</strong> {{ $subcategoria->estado ? 'Activo' : 'Inactivo' }}</li>
            <li><strong>Categoría:</strong> {{ $subcategoria->categoria->nombre ?? 'No asignada' }}</li>
        </ul>
    </div>

</section>

@endsection
