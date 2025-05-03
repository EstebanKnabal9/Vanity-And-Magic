@extends('Layout.Plantilla')

@section('titulomain')
<a href="{{ route('egresos.index') }}" class="btn btn-link"><i class="fas fa-arrow-left"></i> Egresos</a> /
<span>Agregar</span>
@endsection

@section('contenido')
@if($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<div class="container-formulario">
    <div class="card formulario shadow-sm">
        <div class="card-header bg-primary text-white">
            <h3 class="mb-0"><i class="fas fa-file-export"></i> Registrar Egreso</h3>
        </div>
        
        <div class="card-body">
            <form action="{{ route('egresos.store') }}" method="POST" id="form-egreso">
                @csrf

                <div class="form-group">
                    <label for="producto_id">Producto *</label>
                    <select id="producto_id" name="producto_id" required class="form-control select2">
                        <option value="">Selecciona un producto</option>
                        @foreach ($productos as $producto)
                            <option value="{{ $producto->id }}"
                                data-stock="{{ $producto->stock }}"
                                data-precio="{{ $producto->precio }}"
                                @selected(old('producto_id') == $producto->id)>
                                {{ $producto->nombre }} (Stock: {{ $producto->stock }})
                            </option>
                        @endforeach
                    </select>
                    <small id="stock-disponible" class="form-text text-muted"></small>
                </div>

                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label for="cantidad">Cantidad *</label>
                            <input type="number" name="cantidad" id="cantidad" min="1" step="1"
                                value="{{ old('cantidad') }}" required class="form-control">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <label for="costo_unitario">Costo Unitario *</label>
                        <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input type="number" step="0.01" min="0" id="costo_unitario" name="costo_unitario"
                                value="{{ old('costo_unitario') }}" required class="form-control">
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="costo_total">Costo Total</label>
                    <div class="input-group">
                        <span class="input-group-text">$</span>
                        <input type="number" step="0.01" id="costo_total" name="costo_total"
                            readonly class="form-control font-weight-bold">
                    </div>
                </div>

                <div class="form-group">
                    <label for="tipo_egreso">Tipo de Egreso *</label>
                    <select id="tipo_egreso" name="tipo_egreso" required class="form-control">
                        <option value="">Seleccione tipo</option>
                        <option value="venta" @selected(old('tipo_egreso') == 'venta')>Venta</option>
                        <option value="devolucion_proveedor" @selected(old('tipo_egreso') == 'devolucion_proveedor')>Devolución al Proveedor</option>
                        <option value="ajuste_negativo" @selected(old('tipo_egreso') == 'ajuste_negativo')>Ajuste Negativo</option>
                        <option value="consumo_interno" @selected(old('tipo_egreso') == 'consumo_interno')>Consumo Interno</option>
                    </select>
                </div>

                <div class="form-group" id="proveedor-group" style="display: none;">
                    <label for="proveedor_id">Proveedor *</label>
                    <select name="proveedor_id" id="proveedor_id" class="form-control select2">
                        <option value="">Seleccione proveedor</option>
                        @foreach($proveedores as $proveedor)
                            <option value="{{ $proveedor->id }}" @selected(old('proveedor_id') == $proveedor->id)>
                                {{ $proveedor->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="form-group">
                    <label for="documento">Documento</label>
                    <input type="text" id="documento" name="documento" value="{{ old('documento') }}"
                        readonly class="form-control bg-light">
                </div>

                <div class="form-group">
                    <label for="observacion">Observación</label>
                    <textarea name="observacion" id="observacion" rows="3"
                        class="form-control">{{ old('observacion') }}</textarea>
                </div>

                <div class="form-group">
                    <label for="fecha_egreso">Fecha de Egreso *</label>
                    <input type="date" name="fecha_egreso" id="fecha_egreso"
                        value="{{ old('fecha_egreso', date('Y-m-d')) }}" required class="form-control">
                </div>

                <button type="submit" class="btn btn-primary">Guardar Egreso</button>
            </form>
        </div>
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    $('.select2').select2({ width: '100%' });

    const cantidad = document.getElementById('cantidad');
    const costoUnitario = document.getElementById('costo_unitario');
    const costoTotal = document.getElementById('costo_total');
    const productoSelect = document.getElementById('producto_id');
    const tipoEgreso = document.getElementById('tipo_egreso');
    const documento = document.getElementById('documento');
    const proveedorGroup = document.getElementById('proveedor-group');
    const proveedorSelect = document.getElementById('proveedor_id');
    const stockDisponible = document.getElementById('stock-disponible');

    function actualizarCostoTotal() {
        const cantidadVal = parseFloat(cantidad.value) || 0;
        const precioVal = parseFloat(costoUnitario.value) || 0;
        costoTotal.value = (cantidadVal * precioVal).toFixed(2);
    }

    function actualizarDatosProducto() {
        const option = productoSelect.options[productoSelect.selectedIndex];
        const stock = option.getAttribute('data-stock') || 0;
        const precio = option.getAttribute('data-precio') || 0;

        stockDisponible.textContent = `Stock disponible: ${stock}`;
        costoUnitario.value = precio;
        actualizarCostoTotal();
    }

    function generarDocumento() {
        const tipo = tipoEgreso.value;
        const fecha = new Date().toISOString().slice(0, 10).replace(/-/g, '');
        const random = Math.random().toString(36).substr(2, 5).toUpperCase();

        const prefijos = {
            venta: 'VENTA',
            devolucion_proveedor: 'DEV',
            ajuste_negativo: 'AJUSTE',
            consumo_interno: 'CONS'
        };

        documento.value = prefijos[tipo] ? `${prefijos[tipo]}-${fecha}-${random}` : '';
    }

    function toggleProveedorField() {
        const mostrar = tipoEgreso.value === 'devolucion_proveedor';
        proveedorGroup.style.display = mostrar ? 'block' : 'none';
        proveedorSelect.required = mostrar;
    }

    document.getElementById('form-egreso').addEventListener('submit', function(e) {
        const tipo = tipoEgreso.value;
        const option = productoSelect.options[productoSelect.selectedIndex];
        const stock = parseFloat(option.getAttribute('data-stock')) || 0;
        const cant = parseFloat(cantidad.value) || 0;

        if (['venta', 'consumo_interno'].includes(tipo) && cant > stock) {
            e.preventDefault();
            alert(`La cantidad (${cant}) supera el stock disponible (${stock}).`);
        }
    });

    cantidad.addEventListener('input', actualizarCostoTotal);
    costoUnitario.addEventListener('input', actualizarCostoTotal);
    productoSelect.addEventListener('change', () => {
        actualizarDatosProducto();
        generarDocumento();
    });
    tipoEgreso.addEventListener('change', () => {
        generarDocumento();
        toggleProveedorField();
    });

    // Inicializar
    setTimeout(() => {
        if (productoSelect.selectedIndex > 0) actualizarDatosProducto();
        generarDocumento();
        toggleProveedorField();
    }, 100);
});
</script>
@endpush
@endsection
