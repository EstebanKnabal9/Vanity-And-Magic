@extends('Layout.Plantilla')

@section('titulomain')
<a href="{{ route('egresos.index') }}">Egresos</a> / 
<span>Egreso {{ $egreso->documento }}</span>
@endsection

@section('contenido')

<section class="container-cards">

    <div class="card-show">
        <div class="cabecera">            
            <h2>Egreso: {{ $egreso->documento }}</h2>                      
        </div>
        <ul>
            <li><strong>Producto:</strong> {{ $egreso->producto->nombre ?? 'N/A' }}</li>
            <li><strong>Proveedor:</strong> {{ $egreso->proveedor->nombre ?? 'N/A' }}</li>
            <li><strong>Cantidad:</strong> {{ $egreso->cantidad }}</li>
            <li><strong>Costo Unitario:</strong> {{ $egreso->costo_unitario }}</li>
            <li><strong>Costo Total:</strong> {{ $egreso->costo_total }}</li>
            <li><strong>Tipo de Egreso:</strong> {{ ucfirst(str_replace('_', ' ', $egreso->tipo_egreso)) }}</li>
            <li><strong>Fecha de Egreso:</strong> {{ $egreso->fecha_egreso }}</li>
            <li><strong>Observación:</strong> {{ $egreso->observacion ?? 'Sin observaciones' }}</li>
        </ul>
    </div>

</section>

@endsection
