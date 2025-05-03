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
                        <option value="{{ $producto->id }}"
                                data-stock="{{ $producto->stock }}">
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="stock_actual">Stock Actual</label>
                <input type="number" id="stock_actual" name="stock_actual" readonly>
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad a Ingresar</label>
                <input type="number" id="cantidad" name="cantidad" required min="1"
                       value="{{ old('cantidad') }}">
            </div>

            <div class="form-group">
                <label for="costo_unitario">Costo Unitario de Producto</label>
                <input type="number" step="0.01" id="costo_unitario" name="costo_unitario" required min="0">
            </div>

            <div class="form-group">
                <label for="costo_total">Costo Total de la Compra</label>
                <input type="number" step="0.01" id="costo_total" readonly>
            </div>

            <div class="form-group">
                <label for="tipo_ingreso">Tipo de Ingreso / Compra</label>
                <select id="tipo_ingreso" name="tipo_ingreso" required>
                    <option value="compra">Compra</option>
                    <option value="ajuste">Ajuste</option>
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
    const productoSelect = document.getElementById('producto_id');
    const stockActual = document.getElementById('stock_actual');

    function actualizarCostoTotal() {
        const cant = parseFloat(cantidad.value) || 0;
        const unitario = parseFloat(costoUnitario.value) || 0;
        costoTotal.value = (cant * unitario).toFixed(2);
    }

    function generarDocumento() {
        const tipo = tipoIngreso.value;
        const fecha = new Date().toISOString().split('T')[0];
        let prefijo = '';
        if (tipo === 'compra') {
            prefijo = 'FAC-' + fecha;
        } else if (tipo === 'ajuste') {
            prefijo = 'AJUSTE-' + fecha;
        }
        documento.value = prefijo;
    }

    productoSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const stock = selectedOption.getAttribute('data-stock');
        if (stock !== null) {
            stockActual.value = stock;
        } else {
            stockActual.value = '';
        }
    });

    cantidad.addEventListener('input', actualizarCostoTotal);
    costoUnitario.addEventListener('input', actualizarCostoTotal);
    tipoIngreso.addEventListener('change', generarDocumento);

    window.addEventListener('DOMContentLoaded', () => {
        actualizarCostoTotal();
        generarDocumento();

        const selectedOption = productoSelect.selectedOptions[0];
        const stock = selectedOption?.getAttribute('data-stock');
        if (stock) {
            stockActual.value = stock;
        }
    });
</script>
@endsection
