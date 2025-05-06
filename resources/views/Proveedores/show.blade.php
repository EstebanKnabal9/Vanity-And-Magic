@extends('Layout.Plantilla')

@section('titulomain')
    Proveedor: {{ $proveedor->nombre }}
@endsection

@section('contenido')
    <section class="container-cards">
        <div class="card-show">
            <div class="cabecera">
                <h2>{{ $proveedor->nombre }}</h2>
            </div>

            <div class="informacion">
                <p><strong>Identificación:</strong> {{ $proveedor->identificacion }}</p>
                <p><strong>Descripción:</strong> {{ $proveedor->descripcion ?? 'No disponible' }}</p>
                <p><strong>Teléfono:</strong> {{ $proveedor->telefono ?? 'No disponible' }}</p>
                <p><strong>Correo:</strong> {{ $proveedor->correo ?? 'No disponible' }}</p>
                <p><strong>Dirección:</strong> {{ $proveedor->direccion ?? 'No disponible' }}</p>
                <p><strong>Estado:</strong> {{ $proveedor->estado ? 'Activo' : 'Inactivo' }}</p>
            
    </section>

    <script>
        function confirmarEliminacion() {
            return confirm('¿Seguro que deseas eliminar este proveedor?');
        }
    </script>
@endsection
