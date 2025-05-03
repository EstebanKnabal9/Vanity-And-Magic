@extends('Layout.Plantilla')

@section('titulomain')
Subcategoría
@endsection

@section('contenido')

<section class="container-tabla">
    <nav class="nav-botones">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('subcategorias.create') }}" class="nav-link btn-agregar">Agregar Subcategoría</a>
            </li>
        </ul>
    </nav>

    <table>
        <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Descripción</th>
                <th>Estado</th>
                <th>Categoria</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody class="tabla-subcategorias">
            @foreach ($subcategorias as $subcategoria)
                <tr>
                    <td></td>
                    <td>{{ $subcategoria->nombre }}</td>
                    <td>{{ $subcategoria->descripcion }}</td>
                    <td>{{ $subcategoria->estado ? 'Activo' : 'Inactivo' }}</td>
                    <td>{{ $subcategoria->categoria->nombre ?? 'Sin Categoría' }}</td>
                    <td>
                        <a href="{{ route('subcategorias.edit', $subcategoria->id) }}">
                            <img src="{{ asset('img/edit.png') }}" alt="Editar">
                        </a>

                        <form action="{{ route('subcategorias.destroy', $subcategoria->id) }}" method="POST" onsubmit="return confirmarEliminacion()" style="display:inline;">
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
        return confirm('¿Seguro deseas eliminar?');
    }
</script>

@endsection
