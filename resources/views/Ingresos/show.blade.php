@extends('Layout.Plantilla')

@section('titulomain')
    Ingreso: {{ $ingreso->documento }}
@endsection

@section('contenido')
    <section class="container-cards">
        <div class="card-show">
            <div class="cabecera">
                <h2>Ingreso: {{ $ingreso->documento }}</h2>
            </div>

            <div class="informacion">
                <p><strong>Producto:</strong> {{ $ingreso->producto->nombre }}</p>
                <p><strong>Cantidad:</strong> {{ $ingreso->cantidad }}</p>
                <p><strong>Costo unitario:</strong> ${{ number_format($ingreso->costo_unitario, 2) }}</p>
                <p><strong>Costo total:</strong> ${{ number_format($ingreso->costo_total, 2) }}</p>
                <p><strong>Proveedor:</strong> {{ $ingreso->proveedor->nombre ?? 'No disponible' }}</p>
                <p><strong>Tipo de ingreso:</strong> {{ $ingreso->tipo_ingreso }}</p>
                <p><strong>Documento:</strong> {{ $ingreso->documento }}</p>
                <p><strong>Observación:</strong> {{ $ingreso->observacion ?? 'No disponible' }}</p>
                <p><strong>Fecha de ingreso:</strong> {{ \Carbon\Carbon::parse($ingreso->fecha_ingreso)->format('d/m/Y') }}</p>
            
    </section>

    <script>
        function confirmarEliminacion() {
            return confirm('¿Seguro que deseas eliminar este ingreso?');
        }
    </script>
@endsection
