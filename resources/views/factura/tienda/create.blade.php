@extends('layouts.app')

@section('content')

<div class="container py-5"> <h2 class="mb-4">🏪 Crear Factura - Venta en Tienda</h2>
text
<form action="{{ route('factura.tienda.store') }}" method="POST" id="formFacturaTienda">
    @csrf
    
    <div class="row">
        <!-- Seleccionar Cliente -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">👤 Seleccionar Cliente</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Cliente</label>
                        <select class="form-select" name="id_cliente" required>
                            <option value="">-- Seleccionar Cliente --</option>
                            @foreach($clientes as $cliente)
                                <option value="{{ $cliente->id }}">{{ $cliente->usuario }}</option>
                            @endforeach
                        </select>
                        @error('id_cliente')
                            <div class="alert alert-danger mt-2">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
            </div>
        </div>

        <!-- Datos del Vendedor -->
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header bg-success text-white">
                    <h5 class="mb-0">💼 Vendedor</h5>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="form-label fw-bold">Empleado</label>
                        <input type="text" class="form-control" value="{{ auth('employee')->user()->usuario }}" disabled>
                        <small class="text-muted">Autenticado como: <strong>{{ auth('employee')->user()->usuario }}</strong></small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Agregar Productos -->
    <div class="card mb-4">
        <div class="card-header bg-info text-white fw-bold">
            <h5 class="mb-0">📦 Agregar Productos</h5>
        </div>
        <div class="card-body">
            <div class="row mb-3">
                <div class="col-md-6">
                    <label class="form-label fw-bold">Producto</label>
                    <select class="form-select" id="selectProducto">
                        <option>-- Seleccionar Producto --</option>
                        @foreach(\App\Models\DetalleProducto::with('producto', 'marca')->get() as $producto)
                            <option value="{{ $producto->id }}" data-precio="{{ $producto->obtenerPrecio('minorista') }}">
                                {{ $producto->producto->nombre }} - {{ $producto->marca->nombre }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-3">
                    <label class="form-label fw-bold">Cantidad</label>
                    <input type="number" class="form-control" id="inputCantidad" min="1" value="1">
                </div>

                <div class="col-md-3 d-flex align-items-end">
                    <button type="button" class="btn btn-info w-100" id="btnAgregar">
                        <i class="fas fa-plus me-2"></i> Agregar
                    </button>
                </div>
            </div>
        </div>
    </div>

    <!-- Tabla de Productos Agregados -->
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark fw-bold">
            <h5 class="mb-0">🛒 Productos en la Factura</h5>
        </div>
        <div class="card-body">
            @if($errors->any())
                <div class="alert alert-danger">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <div class="table-responsive">
                <table class="table table-striped" id="tablaProductos">
                    <thead class="table-light">
                        <tr>
                            <th>Producto</th>
                            <th class="text-center">Precio</th>
                            <th class="text-center">Cantidad</th>
                            <th class="text-end">Subtotal</th>
                            <th class="text-center">Acción</th>
                        </tr>
                    </thead>
                    <tbody id="cuerpoTabla">
                        <tr class="text-muted text-center">
                            <td colspan="5">No hay productos agregados</td>
                        </tr>
                    </tbody>
                    <tfoot class="table-light">
                        <tr>
                            <td colspan="3" class="text-end fw-bold">TOTAL:</td>
                            <td class="text-end fw-bold">
                                <h5 class="mb-0 text-success" id="totalFactura">Q0.00</h5>
                            </td>
                            <td></td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </div>

    <!-- Botones de Acción -->
    <div class="row gap-2">
        <div class="col-md-4">
            <a href="{{ route('dashboard') }}" class="btn btn-secondary w-100">
                <i class="fas fa-times me-2"></i> Cancelar
            </a>
        </div>
        <div class="col-md-4">
            <button type="reset" class="btn btn-warning w-100" onclick="resetearFormulario()">
                <i class="fas fa-redo me-2"></i> Limpiar
            </button>
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-success w-100" id="btnEnviar" disabled>
                <i class="fas fa-check me-2"></i> Crear Factura y Pagar
            </button>
        </div>
    </div>

    <!-- Inputs hidden para enviar los datos -->
    <div id="hiddenInputs"></div>
</form>
</div> 
<script> 
let productos = []; 
document.getElementById('btnAgregar').addEventListener('click', function() 
{ 
    const select = document.getElementById('selectProducto'); 
    const cantidad = parseInt(document.getElementById('inputCantidad').value); 
    if (!select.value) 
        { 
            alert('Selecciona un producto'); 
            return; 
        } 
    if (!cantidad || cantidad < 1) 
        { 
            alert('Ingresa una cantidad válida'); 
            return; 
        } 
    const id = select.value; 
    const nombre = select.options[select.selectedIndex].text; 
    const precio = parseFloat(select.options[select.selectedIndex].dataset.precio); 
        // Evitar duplicados 
    if (productos.find(p => p.id === id)) 
        {
            alert('Este producto ya está agregado. Cambia la cantidad en la tabla.'); 
            return; 
        } 
    productos.push({ id_detalle: id, cantidad: cantidad, precio: precio, nombre: nombre }); 
    renderizarTabla(); 
    select.value = ''; 
    document.getElementById('inputCantidad').value = 1; 
}); 
function renderizarTabla() 
{ 
    const tbody = document.getElementById('cuerpoTabla'); 
    if (productos.length === 0) 
        { 
            tbody.innerHTML = '<tr class="text-muted text-center"><td colspan="5">No hay productos agregados</td></tr>'; 
            document.getElementById('totalFactura').textContent = 'Q0.00'; 
            document.getElementById('btnEnviar').disabled = true; return; 
        } 
    tbody.innerHTML = ''; 
    let total = 0; 
    productos.forEach((p, index) => { 
        const subtotal = p.precio * p.cantidad; total += subtotal; 
        tbody.innerHTML += ` <tr> <td> <small><strong>${p.nombre}</strong></small> </td> <td class="text-center"> <small>Q${p.precio.toFixed(2)}</small> </td> <td class="text-center"> <input type="number" min="1" value="${p.cantidad}" class="form-control form-control-sm" style="width: 70px; margin: 0 auto;" onchange="actualizarCantidad(${index}, this.value)"> </td> <td class="text-end"> <small><strong>Q${subtotal.toFixed(2)}</strong></small> </td> <td class="text-center"> <button type="button" class="btn btn-danger btn-sm" onclick="eliminarProducto(${index})"> <i class="fas fa-trash"></i> </button> </td> </tr> `; 
    }); 
    document.getElementById('totalFactura').textContent = 'Q' + total.toFixed(2); 
    document.getElementById('btnEnviar').disabled = false; 
    
    // Actualizar inputs 
    hidden actualizarInputsHidden(); 
    }
     
    function actualizarCantidad(index, nuevaCantidad) 
    { 
        nuevaCantidad = parseInt(nuevaCantidad); 
        if (nuevaCantidad < 1) 
        { 
            alert('La cantidad debe ser mayor a 0'); 
            renderizarTabla(); 
            return; 
            } 
            productos[index].cantidad = nuevaCantidad; 
            renderizarTabla(); 
            } 
            function eliminarProducto(index) 
            { productos.splice(index, 1); 
            renderizarTabla(); 
            } 
    function actualizarInputsHidden() 
        { 
            const hiddenDiv = document.getElementById('hiddenInputs'); 
            let html = ''; 
            productos.forEach((p, i) => { 
                html += ` <input type="hidden" name="productos[${i}][id_detalle]" value="${p.id_detalle}"> <input type="hidden" name="productos[${i}][cantidad]" value="${p.cantidad}"> `; 
            }); 
            hiddenDiv.innerHTML = html; 
        } 
    function resetearFormulario() 
        { 
            productos = []; 
            document.getElementById('formFacturaTienda').reset(); 
            renderizarTabla(); 
        } 
</script>
@endsection