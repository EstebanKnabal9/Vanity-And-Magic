@extends('Layout.Plantilla')

@section('titulomain')
Categorias
@endsection

@section('contenido')

<section class="container-tabla">

    <nav class="nav-botones">
        <ul class="nav-menu">
            <li class="nav-item">
                <a href="{{route('categorias.create')}}" class="nav-link btn-agregar">Agregar Categoria</a>
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
         <td>{{$categoria->nombre}}</td>
         <td>{{$categoria->descripcion}}</td>
         <td>{{$categoria->estado}}</td>
            <td >
                {{-- <a href="{{route('categoria.show',[$categoria->id])}}">
                   <img src="img/view.png" alt="">
                </a> --}}

                   <a href="{{route('categorias.edit',[$categoria->id])}}">
                   <img src="img/edit.png" alt="">
                   </a>

                    <form action="{{route('categorias.destroy',[$categoria->id])}}" method="POST" onsubmit="return confimarEliminacion()">

                    @method('DELETE')
                    <input type="image"src="img/delete.png"></input>

                     </form>

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