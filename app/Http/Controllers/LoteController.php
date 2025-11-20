<?php

namespace App\Http\Controllers;

use App\Models\Lote;
use App\Models\DetalleProducto;
use App\Models\Sucursal;
use App\Models\Proveedor;
use App\Models\Inventario;
use Illuminate\Http\Request;

class LoteController extends Controller
{
    // ✅ Listar lotes
    public function index()
    {
        $lotes = Lote::with('detalleProducto.producto', 'sucursal', 'proveedor')
            ->paginate(15);

        return view('lote.index', compact('lotes'));
    }

    // ✅ Crear formulario
    public function create()
    {
        $detallesProducto = DetalleProducto::with('producto')->get();
        $sucursales = Sucursal::all();
        $proveedores = Proveedor::all();

        return view('lote.create', compact('detallesProducto', 'sucursales', 'proveedores'));
    }

    // ✅ Guardar lote (CREA/ACTUALIZA INVENTARIO AUTOMÁTICAMENTE)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'id_detalleproducto' => 'required|exists:detalleproducto,id',
            'id_sucursal' => 'required|exists:sucursal,id',
            'id_proveedor' => 'required|exists:proveedor,id',
            'cantidad' => 'required|integer|min:1',
            'costoUnidad' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'fechaCaducidad' => 'required|date|after:today',
            'fechaEntrada' => 'required|date',
            'codLote' => 'required|string|unique:lote,codLote',
            'descripcion' => 'nullable|string|max:200',
        ]);

        $validated['cantidad_actual'] = $validated['cantidad'];

        // Crear lote
        $lote = Lote::create($validated);

        // Buscar o crear inventario
        $inventario = Inventario::where('id_detalleproducto', $validated['id_detalleproducto'])
            ->where('id_sucursal', $validated['id_sucursal'])
            ->first();

        if ($inventario) {
            // Actualizar stock actual
            $inventario->update([
                'stock_actual' => $inventario->stock_actual + $validated['cantidad'],
                'existencia' => $inventario->existencia + $validated['cantidad'],
            ]);
        } else {
            // Crear inventario nuevo
            Inventario::create([
                'id_detalleproducto' => $validated['id_detalleproducto'],
                'id_sucursal' => $validated['id_sucursal'],
                'stock_actual' => $validated['cantidad'],
                'existencia' => $validated['cantidad'],
                'stock_minimo' => 5,
                'stock_maximo' => 100,
            ]);
        }

        return redirect()->route('lote.index')
            ->with('success', 'Lote creado y stock actualizado correctamente');
    }

    // ✅ Editar
    public function edit(Lote $lote)
    {
        $detallesProducto = DetalleProducto::with('producto')->get();
        $sucursales = Sucursal::all();
        $proveedores = Proveedor::all();

        return view('lote.edit', compact('lote', 'detallesProducto', 'sucursales', 'proveedores'));
    }

    // ✅ Actualizar
    public function update(Request $request, Lote $lote)
    {
        $validated = $request->validate([
            'id_detalleproducto' => 'required|exists:detalleproducto,id',
            'id_sucursal' => 'required|exists:sucursal,id',
            'id_proveedor' => 'required|exists:proveedor,id',
            'cantidad' => 'required|integer|min:1',
            'cantidad_actual' => 'required|integer|min:0',
            'costoUnidad' => 'required|numeric|min:0',
            'precio_venta' => 'required|numeric|min:0',
            'fechaCaducidad' => 'required|date',
            'fechaEntrada' => 'required|date',
            'codLote' => 'required|string|unique:lote,codLote,' . $lote->id,
            'descripcion' => 'nullable|string|max:200',
        ]);

        // Calcular diferencia de cantidad
        $diferencia = $validated['cantidad'] - $lote->cantidad;

        $lote->update($validated);

        // Actualizar inventario si cambió la cantidad
        if ($diferencia != 0) {
            $inventario = Inventario::where('id_detalleproducto', $lote->id_detalleproducto)
                ->where('id_sucursal', $lote->id_sucursal)
                ->first();

            if ($inventario) {
                $inventario->update([
                    'stock_actual' => max(0, $inventario->stock_actual + $diferencia),
                    'existencia' => max(0, $inventario->existencia + $diferencia),
                ]);
            }
        }

        return redirect()->route('lote.index')
            ->with('success', 'Lote actualizado correctamente');
    }

    // ✅ Eliminar
    public function destroy(Lote $lote)
    {
        // Restar del inventario
        $inventario = Inventario::where('id_detalleproducto', $lote->id_detalleproducto)
            ->where('id_sucursal', $lote->id_sucursal)
            ->first();

        if ($inventario) {
            $inventario->update([
                'stock_actual' => max(0, $inventario->stock_actual - $lote->cantidad),
                'existencia' => max(0, $inventario->existencia - $lote->cantidad),
            ]);
        }

        $lote->delete();

        return redirect()->route('lote.index')
            ->with('success', 'Lote eliminado e inventario actualizado');
    }

    // ✅ Ver detalle
    public function show(Lote $lote)
    {
        $lote->load('detalleProducto.producto', 'sucursal', 'proveedor');

        return view('lote.show', compact('lote'));
    }

    // ✅ Lotes por vencer (próximos 30 días)
    public function porVencer()
    {
        $lotes = Lote::whereRaw('DATEDIFF(fechaCaducidad, CURDATE()) <= 30')
            ->with('detalleProducto.producto', 'sucursal')
            ->get();

        return view('lote.por-vencer', compact('lotes'));
    }
}
