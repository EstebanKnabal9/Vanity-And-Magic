@extends('Layout.Plantilla')

@section('titulomain')
Proveedores
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
                <a href="{{ route('proveedores.create') }}" class="nav-link btn-agregar">Agregar Proveedor</a>
            </li>
        </ul>
    </nav>

    <table class="min-w-full table-auto border-collapse tabla-sin-bordes text-sm">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Identificación</th>
                <th class="px-4 py-2">Descripción</th>
                <th class="px-4 py-2">Dirección</th>
                <th class="px-4 py-2">Teléfono</th>
                <th class="px-4 py-2">Correo</th>
                <th class="px-4 py-2">Estado</th>
                <th class="px-4 py-2 text-center align-middle">Opciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600">
            @foreach ($proveedores as $proveedor)
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2">{{ $proveedor->nombre }}</td>
                <td class="px-4 py-2">{{ $proveedor->identificacion }}</td>
                <td class="px-4 py-2">{{ $proveedor->descripcion }}</td>
                <td class="px-4 py-2">{{ $proveedor->direccion }}</td>
                <td class="px-4 py-2">{{ $proveedor->telefono }}</td>
                <td class="px-4 py-2">{{ $proveedor->correo }}</td>
                <td class="px-4 py-2">{{ $proveedor->estado ? 'Activo' : 'Inactivo' }}</td>
                <td class="px-4 py-2 flex justify-center space-x-2">
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <!-- Ver -->
                        <a href="{{ route('proveedores.show', $proveedor->id) }}" style="text-decoration: none;">
                            <img src="{{ asset('img/VerIcono.png') }}" alt="Ver" style="width: 42px; height: 42px; display: block;">
                        </a>
                        <!-- Editar -->
                        <a href="{{ route('proveedores.edit', $proveedor->id) }}" style="text-decoration: none;">
                            <img src="{{ asset('img/EditarIcono.png') }}" alt="Editar" style="width: 42px; height: 42px; display: block;">
                        </a>
                        <!-- Eliminar -->
                        <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" onsubmit="return confirmarEliminacion()" style="margin: 0; text-decoration: none;">
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
