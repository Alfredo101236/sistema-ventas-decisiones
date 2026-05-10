<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class AnalistaController extends Controller
{
    public function index()
    {
        /*
        |----------------------------------------------------------
        | DATOS GENERALES DEL DATASET
        |----------------------------------------------------------
        */

        $totalRegistros = DB::table('ventas')->count();

        $productos = DB::table('ventas')
            ->distinct('producto')
            ->count('producto');

        $categorias = DB::table('ventas')
            ->distinct('categoria')
            ->count('categoria');

        $regiones = DB::table('ventas')
            ->distinct('region')
            ->count('region');

        /*
        |----------------------------------------------------------
        | CALIDAD DE DATOS
        |----------------------------------------------------------
        */

        $registrosValidos = DB::table('ventas')
            ->whereNotNull('fecha')
            ->whereNotNull('producto')
            ->whereNotNull('categoria')
            ->whereNotNull('cantidad')
            ->whereNotNull('total')
            ->count();

        $registrosObservaciones = $totalRegistros - $registrosValidos;

        /*
        |----------------------------------------------------------
        | GRÁFICA DE CALIDAD (CIRCULAR YA EXISTENTE)
        |----------------------------------------------------------
        */

        /*
        |----------------------------------------------------------
        | NUEVAS GRÁFICAS (ANÁLISIS)
        |----------------------------------------------------------
        */

        // Ventas por mes (línea)
        $ventasPorMes = DB::table('ventas')
            ->select(DB::raw("strftime('%Y-%m', fecha) as mes"), DB::raw("SUM(total) as total"))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        // Top productos
        $topProductos = DB::table('ventas')
            ->select('producto', DB::raw('SUM(cantidad) as total'))
            ->groupBy('producto')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        // Ventas por categoría
        $ventasCategoria = DB::table('ventas')
            ->select('categoria', DB::raw('SUM(total) as total'))
            ->groupBy('categoria')
            ->get();

        // Ventas por región
        $ventasRegion = DB::table('ventas')
            ->select('region', DB::raw('SUM(total) as total'))
            ->groupBy('region')
            ->get();

        /*
        |----------------------------------------------------------
        | RETURN FINAL (TODO JUNTO)
        |----------------------------------------------------------
        */

        return view('analista.dashboard', compact(
            'totalRegistros',
            'productos',
            'categorias',
            'regiones',
            'registrosValidos',
            'registrosObservaciones',
            'ventasPorMes',
            'topProductos',
            'ventasCategoria',
            'ventasRegion'
        ));
    }
}