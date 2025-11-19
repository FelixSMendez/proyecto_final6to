<?php

namespace App\Http\Controllers;

use App\Models\DetalleProducto;
use App\Models\TipoProducto;
use App\Models\Marca;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
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
        return view('catalogo.index', compact('detalles', 'tipos', 'marcas'));
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
}
