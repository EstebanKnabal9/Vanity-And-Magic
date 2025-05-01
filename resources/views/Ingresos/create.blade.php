@extends('Layout.Plantilla')

@section('titulomain')
<a href="{{ route('ingresos.index') }}">Ingresos Compras</a> /
<span>Agregar</span>
@endsection

@section('contenido')
<div class="container-formulario">
    <div class="card formulario">
        <h2>Crear Nuevo Ingreso</h2>
        <form action="{{ route('ingresos.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="producto_id">Producto</label>
                <select id="producto_id" name="producto_id" required>
                    <option value="">Selecciona un producto</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}">{{ $producto->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" id="cantidad" name="cantidad" required min="1">
            </div>

            <div class="form-group">
                <label for="costo_unitario">Costo Unitario</label>
                <input type="number" step="0.01" id="costo_unitario" name="costo_unitario" required min="0">
            </div>

            <div class="form-group">
                <label for="costo_total">Costo Total</label>
                <input type="number" step="0.01" id="costo_total" readonly>
            </div>

            <div class="form-group">
                <label for="tipo_ingreso">Tipo de Ingreso / Compra</label>
                <select id="tipo_ingreso" name="tipo_ingreso" required>
                    <option value="compra">Compra</option>
                    <option value="ajuste">Ajuste</option>
                    <option value="devolucion">Devolución</option>
                </select>
            </div>

            <div class="form-group">
                <label for="documento">Documento</label>
                <input type="text" id="documento" name="documento" readonly>
            </div>

            <div class="form-group">
                <label for="proveedor_id">Proveedor</label>
                <select id="proveedor_id" name="proveedor_id">
                    <option value="">Seleccione un proveedor</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}">{{ $proveedor->nombre }}</option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="observacion">Observación</label>
                <textarea id="observacion" name="observacion" rows="4"></textarea>
            </div>

            <div class="form-group">
                <label for="fecha_ingreso">Fecha de Ingreso</label>
                <input type="date" id="fecha_ingreso" name="fecha_ingreso" required>
            </div>

            <div class="form-group">
                <button type="submit">Guardar Ingreso / Compra</button>
            </div>
        </form>
    </div>
</div>

<script>
    const cantidad = document.getElementById('cantidad');
    const costoUnitario = document.getElementById('costo_unitario');
    const costoTotal = document.getElementById('costo_total');
    const tipoIngreso = document.getElementById('tipo_ingreso');
    const documento = document.getElementById('documento');

    function actualizarCostoTotal() {
        const cant = parseFloat(cantidad.value) || 0;
        const unitario = parseFloat(costoUnitario.value) || 0;
        costoTotal.value = (cant * unitario).toFixed(2);
    }

    function generarDocumento() {
        const tipo = tipoIngreso.value;
        const fecha = new Date().toISOString().split('T')[0]; // formato YYYY-MM-DD
        let prefijo = '';
        if (tipo === 'compra') {
            prefijo = 'FAC-' + fecha;
        } else if (tipo === 'ajuste') {
            prefijo = 'AJUSTE-' + fecha;
        } else if (tipo === 'devolucion') {
            prefijo = 'DEVOLUCION-' + fecha;
        }
        documento.value = prefijo;
    }

    cantidad.addEventListener('input', actualizarCostoTotal);
    costoUnitario.addEventListener('input', actualizarCostoTotal);
    tipoIngreso.addEventListener('change', generarDocumento);

    // Inicializar al cargar
    window.addEventListener('DOMContentLoaded', () => {
        actualizarCostoTotal();
        generarDocumento();
    });
</script>
@endsection
