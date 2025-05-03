@extends('Layout.Plantilla')

@section('titulomain')
<a href="{{ route('subcategorias.index') }}">Subcategorías</a> /
<span>Agregar </span>
@endsection

@section('contenido')
  {{-- mostrar formulario para crear nueva categoria --}}
  <div class= "container-formulario">
    <div class="card formulario">
        <h2>Crear Nueva Subcategoría</h2>
        <form action="{{route('subcategorias.store')}}" method="POST" id="crearCategoriaForm">
            @csrf
            <div class="form-group">
                <label for="nombre">Nombre de la Subcategoría</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>
            <div class="form-group">
                <label for="descripcion">Descripción</label>
                <textarea id="descripcion" name="descripcion" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="id_categoria">Categoría</label>
                <select id="id_categoria" name="id_categoria" required>
                    <option value=""> Selecciona una categoría </option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria->id }}">{{ $categoria->nombre }}</option>
                    @endforeach
                </select>
            </div>
            
            <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>
            <div class="form-group">
                <button type="submit">Guardar Subcategoría</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('crearSubCategoriaForm').addEventListener('submit', function(event) {
        console.log('Formulario enviado!');
        const formData = new FormData(this);
        for (const [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }
        // Si quieres evitar que el formulario se envíe inmediatamente para depurar,
        // puedes agregar: event.preventDefault();
    });
</script>

@endsection