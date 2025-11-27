<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\TipoProducto;
use Illuminate\Http\Request;
use App\Models\DetalleProducto;
use App\Models\Marca;
use Illuminate\Support\Facades\Auth;

class ProductoController extends Controller
{
    public function indice()
    {
        $productos = Producto::with('tipoProducto')->paginate(10);
        return view('productos.index', compact('productos'));
    }

    public function create()
    {
        $tipos = TipoProducto::all();
        return view('productos.create', compact('tipos'));
    }


    /**
     * Mostrar catálogo (por DetalleProducto)
     */

    public function index(Request $request)
    {
        $query = DetalleProducto::with(['producto', 'marca', 'tipoMedida', 'producto.tipoProducto', 'precios']);

        // Filtro por tipo (en tabla producto)
        if ($request->filled('tipo')) {
            $query->whereHas('producto', function ($q) use ($request) {
                $q->where('id_tipoProducto', $request->tipo);
            });
        }

        // Filtro por marca (directo en detalleproducto)
        if ($request->filled('marca')) {
            $query->where('id_marca', $request->marca);
        }

        // Búsqueda por nombre o descripción
        if ($request->filled('buscar')) {
            $query->where(function ($q) use ($request) {
                $q->where('descripcion', 'like', '%' . $request->buscar . '%')
                  ->orWhereHas('producto', function ($subQ) use ($request) {
                      $subQ->where('nombre', 'like', '%' . $request->buscar . '%');
                  });
            });
        }

        // Ordenar
        $orden = $request->get('orden', 'reciente');
        switch ($orden) {
            case 'precio_asc':
                $query->orderBy('id', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('id', 'desc');
                break;
            case 'nombre':
                $query->whereHas('producto', function ($q) {
                    $q->orderBy('nombre', 'asc');
                });
                break;
            default:
                $query->orderBy('id', 'desc');
        }

        // Paginación
        $detalles = $query->paginate(12);

        // Obtener opciones de filtro
        $tipos = TipoProducto::all();
        $marcas = Marca::all();
        $showLoginOptions = true;
        $clienteLat = null;
        $clienteLng = null;

        if (Auth::guard('cliente')->check()) {
            $usuarioCliente = Auth::guard('cliente')->user();   // modelo UsuarioCliente
            $cliente        = $usuarioCliente->cliente;          // relación hacia Cliente

            if ($cliente && $cliente->latitud && $cliente->longitud) {
                $clienteLat = $cliente->latitud;
                $clienteLng = $cliente->longitud;
            }
        }

    return view('catalogo.index', compact('detalles', 'tipos', 'marcas', 'clienteLat', 'clienteLng'));
    }

    public function edit(Producto $producto)
    {
        $tipos = TipoProducto::all();
        return view('productos.edit', compact( 'producto', 'tipos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'id_tipoProducto' => 'required|exists:tipoproducto,id',
        ]);

        Producto::create($request->all());
        return redirect()->route('productos.index')->with('success', 'Producto creado exitosamente');
    }

    /**
     * Mostrar detalle de producto
     */
    public function show($id)
    {
        $detalle = DetalleProducto::with(['producto', 'marca', 'tipoMedida', 'producto.tipoProducto', 'precios'])->findOrFail($id);
        
        // Productos similares (mismo tipo)
        $productosSimilares = DetalleProducto::with(['producto', 'marca', 'precios'])
            ->whereHas('producto', function ($q) use ($detalle) {
                $q->where('id_tipoProducto', $detalle->producto->id_tipoProducto)
                  ->where('id', '!=', $detalle->id_producto);
            })
            ->limit(4)
            ->get();

        return view('catalogo.show', compact('detalle', 'productosSimilares'));
    }

    public function update(Request $request, Producto $producto)
    {
        $request->validate([
            'nombre' => 'required|string|max:100',
            'descripcion' => 'nullable|string|max:255',
            'id_tipoProducto' => 'required|exists:tipoproducto,id',
        ]);

        $producto->update($request->all());
        return redirect()->route('productos.index')->with('success', 'Producto actualizado correctamente');
    }

    public function destroy(Producto $producto)
    {
        $producto->delete();
        return redirect()->route('productos.index')->with('success', 'Producto eliminado correctamente');
    }


}
