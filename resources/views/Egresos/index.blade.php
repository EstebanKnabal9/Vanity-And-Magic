@extends('Layout.Plantilla')

@section('titulomain')
Egresos
@endsection

@section('contenido')

<section class="container-tabla">

    <nav class="nav-botones">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('egresos.create') }}" class="nav-link btn-agregar">Agregar Egreso</a>
            </li>
        </ul>
    </nav>

    <table>
        <thead>
            <tr>
                <th></th>
                <th>Producto</th>
                <th>Observación</th>
                <th>Proveedor</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Costo Total</th>
                <th>Tipo</th>
                <th>Documento</th>
                <th>Fecha</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody class="tabla-egresos">
            @foreach ($egresos as $egreso)
                <tr>
                    <td></td>
                    <td>{{ $egreso->producto->nombre ?? 'N/A' }}</td>
                    <td>{{ $egreso->observacion }}</td>
                    <td>{{ $egreso->proveedor->nombre ?? 'N/A' }}</td>
                    <td>{{ $egreso->cantidad }}</td>
                    <td>{{ $egreso->costo_unitario }}</td>
                    <td>{{ $egreso->costo_total }}</td>
                    <td>{{ ucfirst(str_replace('_', ' ', $egreso->tipo_egreso)) }}</td>
                    <td>{{ $egreso->documento }}</td>
                    <td>{{ $egreso->fecha_egreso }}</td>
                    <td>
                        {{-- Botón editar --}}
                        <a href="{{ route('egresos.edit', [$egreso->id]) }}">
                            <img src="{{ asset('img/edit.png') }}" alt="Editar">
                        </a>

                        {{-- Botón eliminar --}}
                        <form action="{{ route('egresos.destroy', [$egreso->id]) }}" method="POST" style="display:inline;" onsubmit="return confirmarEliminacion()">
                            @csrf
                            @method('DELETE')
                            <input type="image" src="{{ asset('img/delete.png') }}" alt="Eliminar">
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</section>

<script>
    function confirmarEliminacion() {
        return confirm('¿Seguro deseas eliminar este egreso?');
    }
</script>

@endsection
