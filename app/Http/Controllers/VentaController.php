<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;

class VentaController extends Controller
{
    public function index(Request $request)
    {
        $query = Venta::query();

        if ($request->filled('fecha_inicio')) {
            $query->whereDate('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $query->whereDate('fecha', '<=', $request->fecha_fin);
        }

        if ($request->filled('producto')) {
            $query->where('producto', $request->producto);
        }

        if ($request->filled('categoria')) {
            $query->where('categoria', $request->categoria);
        }

        if ($request->filled('region')) {
            $query->where('region', $request->region);
        }

        if ($request->filled('estado_limpieza')) {
            $query->where('estado_limpieza', $request->estado_limpieza);
        }

        $totalRegistros = (clone $query)->count();
        $totalVendido = (clone $query)->sum('total');
        $cantidadVendida = (clone $query)->sum('cantidad');
        $promedioVenta = $totalRegistros > 0
            ? round($totalVendido / $totalRegistros, 2)
            : 0;

        $ventas = $query
            ->orderByDesc('fecha')
            ->orderByDesc('id')
            ->paginate(15)
            ->withQueryString();

        $productos = Venta::whereNotNull('producto')
            ->where('producto', '!=', '')
            ->select('producto')
            ->distinct()
            ->orderBy('producto')
            ->pluck('producto');

        $categorias = Venta::whereNotNull('categoria')
            ->where('categoria', '!=', '')
            ->select('categoria')
            ->distinct()
            ->orderBy('categoria')
            ->pluck('categoria');

        $regiones = Venta::whereNotNull('region')
            ->where('region', '!=', '')
            ->select('region')
            ->distinct()
            ->orderBy('region')
            ->pluck('region');

        return view('ventas.index', compact(
            'ventas',
            'productos',
            'categorias',
            'regiones',
            'totalRegistros',
            'totalVendido',
            'cantidadVendida',
            'promedioVenta'
        ));
    }
}