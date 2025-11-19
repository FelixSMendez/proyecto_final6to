<?php

namespace App\Http\Controllers;

use App\Models\Producto;
use App\Models\TipoProducto;
use App\Models\Marca;
use Illuminate\Http\Request;

class ProductoController extends Controller
{
    /**
     * Mostrar catálogo de productos
     */
    public function index(Request $request)
    {
        $query = Producto::query();

        // Filtro por tipo
        if ($request->filled('tipo')) {
            $query->where('id_tipoProducto', $request->tipo);
        }

        // Filtro por marca
        if ($request->filled('marca')) {
            $query->where('id_marca', $request->marca);
        }

        // Búsqueda por nombre
        if ($request->filled('buscar')) {
            $query->where('nombre', 'like', '%' . $request->buscar . '%')
                  ->orWhere('descripcion', 'like', '%' . $request->buscar . '%');
        }

        // Ordenar
        $orden = $request->get('orden', 'reciente');
        switch ($orden) {
            case 'precio_asc':
                $query->orderBy('precio', 'asc');
                break;
            case 'precio_desc':
                $query->orderBy('precio', 'desc');
                break;
            case 'nombre':
                $query->orderBy('nombre', 'asc');
                break;
            default:
                $query->orderBy('id', 'desc');
        }

        // Paginar
        $productos = $query->paginate(12);

        // Obtener filtros
        $tipos = TipoProducto::all();
        $marcas = Marca::all();

        return view('catalogo.index', compact('productos', 'tipos', 'marcas'));
    }

    /**
     * Mostrar detalle de producto
     */
    public function show($id)
    {
        $producto = Producto::findOrFail($id);
        $productosSimilares = Producto::where('id_tipoProducto', $producto->id_tipo)
                                       ->where('id', '!=', $id)
                                       ->limit(4)
                                       ->get();

        return view('catalogo.show', compact('producto', 'productosSimilares'));
    }
}
