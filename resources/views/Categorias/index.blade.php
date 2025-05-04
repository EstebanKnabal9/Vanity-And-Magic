@extends('Layout.Plantilla')

@section('titulomain')
Categorias
@endsection

@section('contenido')

<section class="container-tabla">

    <nav class="nav-botones">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('categorias.create') }}" class="nav-link btn-agregar">Agregar Categoria</a>
            </li>
        </ul>
    </nav>

    <table>
        <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Descripcion</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody class="tabla-categorias">
            @foreach ($categorias as $categoria)
                <tr>
                    <td></td>
                    <td>{{ $categoria->nombre }}</td>
                    <td>{{ $categoria->descripcion }}</td>
                    <td>{{ $categoria->estado }}</td>
                    <td>
                        {{-- Enlace para editar --}}
                        <a href="{{ route('categorias.edit', [$categoria->id]) }}">
                            <img src="img/edit.png" alt="Editar">
                        </a>

                        {{-- Formulario para eliminar --}}
                        <form action="{{ route('categorias.destroy', [$categoria->id]) }}" method="POST" onsubmit="return confimarEliminacion()">
                            @csrf
                            @method('DELETE')
                            <input type="image" src="img/delete.png" alt="Eliminar">
                        </form>

                        {{-- Script de confirmación --}}
                        <script>
                            function confimarEliminacion() {
                                return confirm('¿Seguro deseas eliminar?'); // Muestra el mensaje de confirmación
                            }
                        </script>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>

</section>

@endsection
