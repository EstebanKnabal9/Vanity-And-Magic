@extends('Layout.Plantilla')

@section('titulomain')
Proveedores
@endsection

@section('contenido')

<section class="container-tabla">
    <nav class="nav-botones">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{ route('proveedores.create') }}" class="nav-link btn-agregar">Agregar Proveedor</a>
            </li>
        </ul>
    </nav>

    <table>
        <thead>
            <tr>
                <th></th>
                <th>Nombre</th>
                <th>Identificación</th>
                <th>Descripción</th>
                <th>Direccion</th>
                <th>Telefono</th>
                <th>Correo</th>
                <th>Estado</th>
                <th>Opciones</th>
            </tr>
        </thead>
        <tbody class="tabla-proveedores">
            @foreach ($proveedores as $proveedor)
                <tr>
                    <td></td>
                    <td>{{ $proveedor->nombre }}</td>
                    <td>{{ $proveedor->identificacion }}</td>
                    <td>{{ $proveedor->descripcion }}</td>
                    <td>{{ $proveedor->direccion }}</td>
                    <td>{{ $proveedor->telefono }}</td>
                    <td> {{ $proveedor->correo }}</td>
                    <td>{{ $proveedor->estado ? 'Activo' : 'Inactivo' }}</td>
                    <td>
                        <a href="{{ route('proveedores.edit', $proveedor->id) }}">
                            <img src="{{ asset('img/edit.png') }}" alt="Editar">
                        </a>

                        <form action="{{ route('proveedores.destroy', $proveedor->id) }}" method="POST" onsubmit="return confirmarEliminacion()" style="display:inline;">
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
