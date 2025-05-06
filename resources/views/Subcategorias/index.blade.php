@extends('Layout.Plantilla')

@section('titulomain')
Subcategorías
@endsection

@section('contenido')

<!-- Estilo para quitar bordes visibles -->
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
                <a href="{{ route('subcategorias.create') }}" class="nav-link btn-agregar">Agregar Subcategoría</a>
            </li>
        </ul>
    </nav>

    <table class="min-w-full table-auto border-collapse tabla-sin-bordes text-sm">
        <thead class="bg-gray-200 text-gray-700">
            <tr>
                <th class="px-4 py-2"></th>
                <th class="px-4 py-2">Nombre</th>
                <th class="px-4 py-2">Descripción</th>
                <th class="px-4 py-2">Estado</th>
                <th class="px-4 py-2">Categoría</th>
                <th class="px-4 py-2 text-center align-middle">Opciones</th>
            </tr>
        </thead>
        <tbody class="text-gray-600">
            @foreach ($subcategorias as $subcategoria)
            <tr class="hover:bg-gray-100">
                <td class="px-4 py-2"></td>
                <td class="px-4 py-2">{{ $subcategoria->nombre }}</td>
                <td class="px-4 py-2">{{ $subcategoria->descripcion }}</td>
                <td class="px-4 py-2">{{ $subcategoria->estado ? 'Activo' : 'Inactivo' }}</td>
                <td class="px-4 py-2">{{ $subcategoria->categoria->nombre ?? 'Sin Categoría' }}</td>
                <td class="px-4 py-2 flex justify-center space-x-2">
                    <div style="display: flex; gap: 8px; align-items: center;">
                        <!-- Ver -->
                        <a href="{{ route('subcategorias.show', $subcategoria->id) }}" style="text-decoration: none;">
                            <img src="{{ asset('img/VerIcono.png') }}" alt="Ver" style="width: 42px; height: 42px; display: block;">
                        </a>

                        <!-- Editar -->
                        <a href="{{ route('subcategorias.edit', $subcategoria->id) }}" style="text-decoration: none;">
                            <img src="{{ asset('img/EditarIcono.png') }}" alt="Editar" style="width: 42px; height: 42px; display: block;">
                        </a>

                        <!-- Eliminar -->
                        <form action="{{ route('subcategorias.destroy', $subcategoria->id) }}" method="POST" onsubmit="return confirmarEliminacion()" style="margin: 0;">
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
