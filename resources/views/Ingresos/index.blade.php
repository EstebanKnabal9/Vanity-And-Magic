@extends('Layout.Plantilla')

@section('titulomain')
Ingresos / Compras
@endsection

@section('contenido')

<!-- Estilo personalizado para quitar todos los bordes de la tabla -->
<style>
    .tabla-sin-bordes th,
    .tabla-sin-bordes td {
        border: none !important;
    }
</style>

<section class="container-tabla">
    <nav class="nav-botones mb-4">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('ingresos.create') }}" class="nav-link btn-agregar">Agregar Ingreso / Compra</a>
            </li>
        </ul>
    </nav>

    <table class="min-w-full table-auto border-collapse tabla-sin-bordes text-sm">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="px-4 py-2">Producto</th>
                <th class="px-4 py-2">Documento</th>
                <th class="px-4 py-2">Cantidad</th>
                <th class="px-4 py-2">Costo Unitario</th>
                <th class="px-4 py-2">Costo Total</th>
                <th class="px-4 py-2">Tipo de Ingreso</th>
                <th class="px-4 py-2">Observación</th>
                <th class="px-4 py-2">Proveedor</th>
                <th class="px-4 py-2">Fecha de Ingreso</th>
                <th class="px-4 py-2 text-center align-middle">Opciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600">
            @foreach ($ingresos as $ingreso)
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2">{{ $ingreso->producto->nombre }}</td>
                <td class="px-4 py-2">{{ $ingreso->documento }}</td>
                <td class="px-4 py-2">{{ $ingreso->cantidad }}</td>
                <td class="px-4 py-2">{{ $ingreso->costo_unitario }}</td>
                <td class="px-4 py-2">{{ $ingreso->costo_total }}</td>
                <td class="px-4 py-2">{{ $ingreso->tipo_ingreso }}</td>
                <td class="px-4 py-2">{{ $ingreso->observacion }}</td>
                <td class="px-4 py-2">{{ $ingreso->proveedor->nombre ?? 'Sin proveedor' }}</td>
                <td class="px-4 py-2">{{ $ingreso->fecha_ingreso }}</td>
                <td class="px-4 py-2 flex justify-center space-x-2">
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <!-- Botón de ver -->
                        <a href="{{ route('ingresos.show', $ingreso->id) }}" style="text-decoration: none;">
                            <img src="{{ asset('img/VerIcono.png') }}" alt="Ver" style="width: 42px; height: 42px; display: block;">
                        </a>

                        <!-- Botón de editar -->
                        <a href="{{ route('ingresos.edit', $ingreso->id) }}" style="text-decoration: none;">
                            <img src="{{ asset('img/EditarIcono.png') }}" alt="Editar" style="width: 42px; height: 42px; display: block;">
                        </a>

                        <!-- Botón de eliminar -->
                        <form action="{{ route('ingresos.destroy', $ingreso->id) }}" method="POST" onsubmit="return confirmarEliminacion()" style="margin: 0; text-decoration: none;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: none; border: none; padding: 0; cursor: pointer;">
                                <img src="{{ asset('img/EliminarIcono.png') }}" alt="Eliminar" style="width: 42px; height: 42px; display: block;">
                            </button>
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
