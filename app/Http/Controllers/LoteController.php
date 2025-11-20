<?php
// app/Http/Controllers/LoteController.php
namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\DetalleProducto;
use App\Models\Sucursal;
use App\Models\Proveedor;
use App\Models\Inventario;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    // Listar lotes
    public function index()
    {
        $lotes = Lote::with(['detalleProducto.producto', 'sucursal', 'proveedor'])
                     ->paginate(15);
        return view('almacen.lotes.index', compact('lotes'));
    }

    // Crear lote
    public function create()
    {
        $detalleProductos = DetalleProducto::with('producto')->get();
        $sucursales = Sucursal::all();
        $proveedores = Proveedor::all();

        return view('almacen.lotes.create', compact('detalleProductos', 'sucursales', 'proveedores'));
    }

    // Guardar lote
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_detalleproducto' => 'required|exists:detalleproducto,id',
            'id_sucursal' => 'required|exists:sucursal,id',
            'id_proveedor' => 'required|exists:proveedor,id',
            'cantidad' => 'required|integer|min:1',
            'costoUnidad' => 'required|numeric|min:0.01',
            'precio_venta' => 'required|numeric|min:0.01',
            'fechaCaducidad' => 'required|date',
            'codLote' => 'required|string|unique:lote,codLote',
            'descripcion' => 'nullable|string|max:200'
        ]);

        try {
            // Crear el lote
            $lote = Lote::create([
                ...$validated,
                'fechaEntrada' => now(),
                'cantidad_actual' => $validated['cantidad']
            ]);

            // Actualizar inventario
            $inventario = Inventario::where('id_detalleproducto', $validated['id_detalleproducto'])
                                    ->where('id_sucursal', $validated['id_sucursal'])
                                    ->first();

            if ($inventario) {
                $inventario->increment('stock_actual', $validated['cantidad']);
                $inventario->increment('existencia', $validated['cantidad']);
            } else {
                Inventario::create([
                    'id_detalleproducto' => $validated['id_detalleproducto'],
                    'id_sucursal' => $validated['id_sucursal'],
                    'stock_actual' => $validated['cantidad'],
                    'existencia' => $validated['cantidad'],
                    'stock_minimo' => 5,
                    'stock_maximo' => 100
                ]);
            }

            return redirect()->route('almacen.lotes.index')
                           ->with('success', 'Lote ingresado exitosamente');

        } catch (\Exception $e) {
            return redirect()->back()
                           ->with('error', 'Error al ingresar lote: ' . $e->getMessage());
        }
    }

    // Ver detalle de lote
    public function show($id)
    {
        $lote = Lote::with(['detalleProducto.producto', 'sucursal', 'proveedor'])->findOrFail($id);
        return view('almacen.lotes.show', compact('lote'));
    }
}
