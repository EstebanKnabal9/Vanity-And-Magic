@extends('Layout.Plantilla')

@section('titulomain')
Ingresos / Compras
@endsection

@section('contenido')

<section class="container-tabla">
    <nav class="nav-botones">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('ingresos.create') }}" class="nav-link btn-agregar">Agregar Ingreso / Compra</a>
            </li>
        </ul>
    </nav>

    <table>
        <thead>
            <tr>
                <th>Producto</th>
                <th>Documento</th>
                <th>Cantidad</th>
                <th>Costo Unitario</th>
                <th>Costo Total</th>
                <th>Tipo de Ingreso</th>
                <th>Proveedor</th>
                <th>Fecha de Ingreso</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody class="tabla-ingresos">
            @foreach ($ingresos as $ingreso)
            <tr>
                <td>{{ $ingreso->producto->nombre }}</td>
                <td>{{ $ingreso->documento }}</td>
                <td>{{ $ingreso->cantidad }}</td>
                <td>{{ $ingreso->costo_unitario }}</td>
                <td>{{ $ingreso->costo_total }}</td>
                <td>{{ $ingreso->tipo_ingreso }}</td>
                <td>{{ $ingreso->proveedor->nombre ?? 'Sin proveedor' }}</td>
                <td>{{ $ingreso->fecha_ingreso }}</td>
                <td>
                    <div class="botones-accion">
                        <a href="{{ route('ingresos.edit', $ingreso->id) }}">
                            <img src="{{ asset('img/edit.png') }}" alt="Editar">
                        </a>
                    </div>
                </td>
                <td>
                    <div>
                        <form action="{{ route('ingresos.destroy', $ingreso->id) }}" method="POST" onsubmit="return confirmarEliminacion()">
                            @csrf
                            @method('DELETE')
                            <input type="image" src="{{ asset('img/delete.png') }}" alt="Eliminar">
                        </form>
                    </div>
                </td>                                  
            </tr>
            @endforeach
        </tbody>
    </table>
</section>

<script>
    function confirmarEliminacion() {
        return confirm('¿Seguro deseas eliminar?');
    }
</script>

@endsection
