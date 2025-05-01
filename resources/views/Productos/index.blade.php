@extends('Layout.Plantilla')

@section('titulomain')
Productos
@endsection

@section('contenido')

<section class="container-tabla">
    <nav class="nav-botones">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('productos.create') }}" class="nav-link btn-agregar">Agregar Producto</a>
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
                <th>Subcategoria</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody class="tabla-productos">
            @foreach ($productos as $producto)
            <tr>
                <td></td>
                <td>{{ $producto->nombre }}</td>
                <td>{{ $producto->descripcion }}</td>
                <td>{{ $producto->estado ? 'Activo' : 'Inactivo' }}</td>
                <td>{{ $producto->categoria->nombre ?? 'Sin Categoría' }}</td>
                <td>{{ $producto->subcategoria->nombre ?? 'Sin Subcategoría' }}</td>
                <td>
                    <div class="botones-accion">
                        <a href="{{ route('productos.edit', $producto->id) }}">
                            <img src="{{ asset('img/edit.png') }}" alt="Editar">
                        </a>
                    </div>
                </td>
                <td>
                    <div>
                        <form action="{{ route('productos.destroy', $producto->id) }}" method="POST" onsubmit="return confirmarEliminacion()">
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
