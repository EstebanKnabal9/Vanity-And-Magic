@extends('Layout.Plantilla')

@section('titulomain')
<a href="{{ route('proveedores.index') }}">Proveedores</a> /
<span>Agregar</span>
@endsection

@section('contenido')
<div class="container-formulario">
    <div class="card formulario">
        <h2>Crear Nuevo Proveedor</h2>
        <form action="{{ route('proveedores.store') }}" method="POST" id="crearProveedorForm">
            @csrf

            <div class="form-group">
                <label for="nombre">Nombre del Proveedor</label>
                <input type="text" id="nombre" name="nombre" required>
            </div>

            <div class="form-group">
                <label for="identificacion">Identificación</label>
                <input type="text" id="identificacion" name="identificacion" required>
            </div>

            <div class="form-group">
                <label for="telefono">Teléfono</label>
                <input type="text" id="telefono" name="telefono">
            </div>

            <div class="form-group">
                <label for="correo">Correo Electrónico</label>
                <input type="email" id="correo" name="correo">
            </div>

            <div class="form-group">
                <label for="direccion">Dirección</label>
                <input type="text" id="direccion" name="direccion">
            </div>

            <div class="form-group">
                <label for="estado">Estado</label>
                <select id="estado" name="estado" required>
                    <option value="1">Activo</option>
                    <option value="0">Inactivo</option>
                </select>
            </div>

            <div class="form-group">
                <button type="submit">Guardar Proveedor</button>
            </div>
        </form>
    </div>
</div>

<script>
    document.getElementById('crearProveedorForm').addEventListener('submit', function(event) {
        console.log('Formulario enviado!');
        const formData = new FormData(this);
        for (const [key, value] of formData.entries()) {
            console.log(`${key}: ${value}`);
        }
    });
</script>
@endsection
