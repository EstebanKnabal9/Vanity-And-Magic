@extends('Layout.Plantilla')

@section('titulomain')
<a href="{{ route('egresos.index') }}">Egresos</a> /
<span>Agregar</span>
@endsection

@section('contenido')
<div class="container-formulario">
    <div class="card formulario">
        <h2>Registrar Egreso</h2>
        <form action="{{ route('egresos.store') }}" method="POST">
            @csrf

            <div class="form-group">
                <label for="producto_id">Producto</label>
                <select id="producto_id" name="producto_id" required>
                    <option value="">Selecciona un producto</option>
                    @foreach ($productos as $producto)
                        <option value="{{ $producto->id }}"
                                data-stock="{{ $producto->stock }}"
                                {{ old('producto_id') == $producto->id ? 'selected' : '' }}>
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
                <label for="cantidad">Cantidad a Vender</label>
                <input type="number" id="cantidad" name="cantidad" required min="1"
                       value="{{ old('cantidad') }}">
            </div>

            <div class="form-group">
                <label for="costo_unitario">Costo Unitario</label>
                <input type="number" step="0.01" id="costo_unitario" name="costo_unitario" required min="0"
                       value="{{ old('costo_unitario') }}">
            </div>

            <div class="form-group">
                <label for="costo_total">Costo Total</label>
                <input type="number" step="0.01" id="costo_total" name="costo_total" readonly>
            </div>

            <div class="form-group">
                <label for="tipo_egreso">Tipo de Egreso</label>
                <select id="tipo_egreso" name="tipo_egreso" required>
                    <option value="">Seleccione tipo</option>
                    <option value="venta" {{ old('tipo_egreso') == 'venta' ? 'selected' : '' }}>Venta</option>
                    <option value="devolucion_proveedor" {{ old('tipo_egreso') == 'devolucion_proveedor' ? 'selected' : '' }}>Devolución al Proveedor</option>
                    <option value="ajuste_negativo" {{ old('tipo_egreso') == 'ajuste_negativo' ? 'selected' : '' }}>Ajuste Negativo</option>
                    <option value="consumo_interno" {{ old('tipo_egreso') == 'consumo_interno' ? 'selected' : '' }}>Consumo Interno</option>
                </select>
            </div>

            <div class="form-group" id="proveedor-group">
                <label for="proveedor_id">Proveedor</label>
                <select id="proveedor_id" name="proveedor_id">
                    <option value="">Seleccione un proveedor</option>
                    @foreach ($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}"
                            {{ old('proveedor_id') == $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="documento">Documento</label>
                <input type="text" id="documento" name="documento" readonly value="{{ old('documento') }}">
            </div>

            <div class="form-group">
                <label for="observacion">Observación</label>
                <textarea id="observacion" name="observacion" rows="4">{{ old('observacion') }}</textarea>
            </div>

            <div class="form-group">
                <label for="fecha_egreso">Fecha de Egreso</label>
                <input type="date" id="fecha_egreso" name="fecha_egreso" required
                       value="{{ old('fecha_egreso', date('Y-m-d')) }}">
            </div>

            <div class="form-group">
                <button type="submit">Guardar Egreso / Venta</button>
            </div>
        </form>
    </div>
</div>

<script>
    const cantidad = document.getElementById('cantidad');
    const costoUnitario = document.getElementById('costo_unitario');
    const costoTotal = document.getElementById('costo_total');
    const tipoEgreso = document.getElementById('tipo_egreso');
    const documento = document.getElementById('documento');
    const proveedorGroup = document.getElementById('proveedor-group');
    const proveedorSelect = document.getElementById('proveedor_id');
    const productoSelect = document.getElementById('producto_id');
    const stockActual = document.getElementById('stock_actual');
    const form = document.querySelector('form');

    function actualizarCostoTotal() {
        const cant = parseFloat(cantidad.value) || 0;
        const unitario = parseFloat(costoUnitario.value) || 0;
        costoTotal.value = (cant * unitario).toFixed(2);
    }

    function generarDocumento() {
        const tipo = tipoEgreso.value;
        const fecha = new Date().toISOString().split('T')[0];
        let prefijo = '';
        if (tipo === 'venta') {
            prefijo = 'VENTA-' + fecha;
        } else if (tipo === 'ajuste_negativo') {
            prefijo = 'AJUSTE-' + fecha;
        } else if (tipo === 'consumo_interno') {
            prefijo = 'INTERNO-' + fecha;
        } else if (tipo === 'devolucion_proveedor') {
            prefijo = 'DEVOLUCION-' + fecha;
        }
        documento.value = prefijo;
    }

    function toggleProveedorField() {
        if (tipoEgreso.value === 'devolucion_proveedor') {
            proveedorGroup.style.display = 'block';
            proveedorSelect.setAttribute('required', 'required');
        } else {
            proveedorGroup.style.display = 'none';
            proveedorSelect.removeAttribute('required');
        }
    }

    productoSelect.addEventListener('change', function () {
        const selectedOption = this.options[this.selectedIndex];
        const stock = selectedOption.getAttribute('data-stock');
        stockActual.value = stock ?? '';
    });

    cantidad.addEventListener('input', actualizarCostoTotal);
    costoUnitario.addEventListener('input', actualizarCostoTotal);

    tipoEgreso.addEventListener('change', () => {
        generarDocumento();
        toggleProveedorField();
    });

    // Validación antes de enviar el formulario
    form.addEventListener('submit', function (e) {
        const cant = parseFloat(cantidad.value);
        const stock = parseFloat(stockActual.value);

        if (cant > stock) {
            e.preventDefault();
            alert('La cantidad ingresada supera el stock disponible.');
        }
    });

    // Inicialización
    window.addEventListener('DOMContentLoaded', () => {
        actualizarCostoTotal();
        generarDocumento();
        toggleProveedorField();

        const selectedOption = productoSelect.selectedOptions[0];
        const stock = selectedOption?.getAttribute('data-stock');
        if (stock) {
            stockActual.value = stock;
        }
    });
</script>
@endsection
