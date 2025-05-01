@extends('Layout.Plantilla')
@section('titulomain')
<a href="{{ route('categoria.index') }}">Sub Categorías</a> / 
<span>Sub Categoría {{ $subcategoria->nombre }}</span>
@endsection
@section('contenido')

<section class="container-cards">

    <div class="card-show">
        <div class="cabecera">            
             <h2>{{$subcategoria->nombre}}</h2>                      
               
        </div>
        <p> {{$subcategoria->descripcion}}</p>
    </div>

</section>

@endsection