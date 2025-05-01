@extends('Layout.Plantilla')

@section('titulomain')
<a href="{{ route('ingresos.index') }}">Ingresos</a> / Editar Ingreso
@endsection

@section('contenido')
<div class="container-formulario">
    <div class="card formulario">
        <h2>Editar Ingreso</h2>
        <form action="{{ route('ingresos.update', $ingreso->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="producto_id">Producto</label>
                <select name="producto_id" id="producto_id" required>
                    @foreach($productos as $producto)
                        <option value="{{ $producto->id }}" {{ $ingreso->producto_id == $producto->id ? 'selected' : '' }}>
                            {{ $producto->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="cantidad">Cantidad</label>
                <input type="number" name="cantidad" id="cantidad" value="{{ old('cantidad', $ingreso->cantidad) }}" required min="1">
            </div>

            <div class="form-group">
                <label for="costo_unitario">Costo Unitario</label>
                <input type="number" name="costo_unitario" id="costo_unitario" step="0.01" value="{{ old('costo_unitario', $ingreso->costo_unitario) }}" required>
            </div>

            <div class="form-group">
                <label for="tipo_ingreso">Tipo de Ingreso</label>
                <input type="text" name="tipo_ingreso" id="tipo_ingreso" value="{{ old('tipo_ingreso', $ingreso->tipo_ingreso) }}" required>
            </div>

            <div class="form-group">
                <label for="documento">Documento</label>
                <input type="text" name="documento" id="documento" value="{{ old('documento', $ingreso->documento) }}">
            </div>

            <div class="form-group">
                <label for="proveedor_id">Proveedor (opcional)</label>
                <select name="proveedor_id" id="proveedor_id">
                    <option value="">-- Seleccionar --</option>
                    @foreach($proveedores as $proveedor)
                        <option value="{{ $proveedor->id }}" {{ $ingreso->proveedor_id == $proveedor->id ? 'selected' : '' }}>
                            {{ $proveedor->nombre }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="observacion">Observación</label>
                <textarea name="observacion" id="observacion" rows="3">{{ old('observacion', $ingreso->observacion) }}</textarea>
            </div>

            <div class="form-group">
                <label for="fecha_ingreso">Fecha de Ingreso</label>
                <input type="date" name="fecha_ingreso" id="fecha_ingreso"
                    value="{{ old('fecha_ingreso', \Carbon\Carbon::parse($ingreso->fecha_ingreso)->format('Y-m-d')) }}" required>
            </div>            

            <div class="form-group">
                <button type="submit">Actualizar Ingreso</button>
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

    cantidad.addEventListener('input', actualizarCostoTotal);
    costoUnitario.addEventListener('input', actualizarCostoTotal);
    tipoEgreso.addEventListener('change', () => {
        generarDocumento();
        toggleProveedorField();
    });

    window.addEventListener('DOMContentLoaded', () => {
        actualizarCostoTotal();
        generarDocumento();
        toggleProveedorField();
    });
</script>
@endsection
