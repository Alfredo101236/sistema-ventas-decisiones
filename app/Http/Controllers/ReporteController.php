<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ReporteController extends Controller
{
    public function index(Request $request)
    {
        $base = Venta::query()
            ->whereIn('estado_limpieza', ['Correcto', 'Corregido']);

        if ($request->filled('fecha_inicio')) {
            $base->whereDate('fecha', '>=', $request->fecha_inicio);
        }

        if ($request->filled('fecha_fin')) {
            $base->whereDate('fecha', '<=', $request->fecha_fin);
        }

        $totalRegistros = (clone $base)->count();
        $ventasAcumuladas = (clone $base)->sum('total');
        $cantidadTotal = (clone $base)->sum('cantidad');

        $promedioVenta = $totalRegistros > 0
            ? round($ventasAcumuladas / $totalRegistros, 2)
            : 0;

        $productoTop = (clone $base)
            ->select(
                'producto',
                DB::raw('SUM(cantidad) as cantidad_total'),
                DB::raw('SUM(total) as ingreso_total')
            )
            ->whereNotNull('producto')
            ->where('producto', '!=', '')
            ->groupBy('producto')
            ->orderByDesc('cantidad_total')
            ->first();

        $categoriaTop = (clone $base)
            ->select(
                'categoria',
                DB::raw('SUM(total) as ingreso_total')
            )
            ->whereNotNull('categoria')
            ->where('categoria', '!=', '')
            ->groupBy('categoria')
            ->orderByDesc('ingreso_total')
            ->first();

        $regionTop = (clone $base)
            ->select(
                'region',
                DB::raw('SUM(total) as ingreso_total')
            )
            ->whereNotNull('region')
            ->where('region', '!=', '')
            ->groupBy('region')
            ->orderByDesc('ingreso_total')
            ->first();

        $ventasPorMes = (clone $base)
            ->selectRaw("strftime('%Y-%m', fecha) as periodo, SUM(total) as total")
            ->whereNotNull('fecha')
            ->groupBy('periodo')
            ->orderBy('periodo')
            ->get();

        $topProductos = (clone $base)
            ->select(
                'producto',
                DB::raw('SUM(cantidad) as cantidad_total'),
                DB::raw('SUM(total) as ingreso_total')
            )
            ->whereNotNull('producto')
            ->where('producto', '!=', '')
            ->groupBy('producto')
            ->orderByDesc('cantidad_total')
            ->limit(10)
            ->get();

        $productosBajaRotacion = (clone $base)
            ->select(
                'producto',
                DB::raw('SUM(cantidad) as cantidad_total'),
                DB::raw('SUM(total) as ingreso_total')
            )
            ->whereNotNull('producto')
            ->where('producto', '!=', '')
            ->groupBy('producto')
            ->orderBy('cantidad_total')
            ->limit(5)
            ->get();

        $ventasPorCategoria = (clone $base)
            ->select(
                'categoria',
                DB::raw('SUM(total) as total')
            )
            ->whereNotNull('categoria')
            ->where('categoria', '!=', '')
            ->groupBy('categoria')
            ->orderByDesc('total')
            ->get();

        $ventasPorRegion = (clone $base)
            ->select(
                'region',
                DB::raw('SUM(total) as total')
            )
            ->whereNotNull('region')
            ->where('region', '!=', '')
            ->groupBy('region')
            ->orderByDesc('total')
            ->get();

        $prediccion = 0;

        if ($ventasPorMes->count() >= 3) {
            $ultimosTresMeses = $ventasPorMes->take(-3);
            $prediccion = round($ultimosTresMeses->avg('total'), 2);
        }

        $propuestas = $this->generarPropuestas(
            $productoTop,
            $productosBajaRotacion,
            $categoriaTop,
            $regionTop,
            $prediccion
        );

        return view('reportes.index', compact(
            'totalRegistros',
            'ventasAcumuladas',
            'cantidadTotal',
            'promedioVenta',
            'productoTop',
            'categoriaTop',
            'regionTop',
            'ventasPorMes',
            'topProductos',
            'productosBajaRotacion',
            'ventasPorCategoria',
            'ventasPorRegion',
            'prediccion',
            'propuestas'
        ));
    }

    private function generarPropuestas($productoTop, $productosBajaRotacion, $categoriaTop, $regionTop, $prediccion): array
    {
        $propuestas = [];

        if ($productoTop) {
            $propuestas[] = [
                'situacion' => 'Alta demanda',
                'hallazgo' => 'El producto "' . $productoTop->producto . '" presenta la mayor cantidad vendida.',
                'decision' => 'Reforzar inventario y asegurar disponibilidad del producto.',
            ];
        }

        if ($productosBajaRotacion->count() > 0) {
            $productoBajo = $productosBajaRotacion->first();

            $propuestas[] = [
                'situacion' => 'Baja rotación',
                'hallazgo' => 'El producto "' . $productoBajo->producto . '" registra menor movimiento de ventas.',
                'decision' => 'Aplicar promociones, descuentos o revisar su permanencia en inventario.',
            ];
        }

        if ($categoriaTop) {
            $propuestas[] = [
                'situacion' => 'Categoría destacada',
                'hallazgo' => 'La categoría "' . $categoriaTop->categoria . '" genera el mayor ingreso.',
                'decision' => 'Priorizar productos similares dentro de esta categoría.',
            ];
        }

        if ($regionTop) {
            $propuestas[] = [
                'situacion' => 'Región con mejor desempeño',
                'hallazgo' => 'La región "' . $regionTop->region . '" concentra el mayor volumen de ventas.',
                'decision' => 'Reforzar estrategias comerciales y distribución en esta región.',
            ];
        }

        if ($prediccion > 0) {
            $propuestas[] = [
                'situacion' => 'Proyección de ventas',
                'hallazgo' => 'La estimación para el siguiente periodo es de $' . number_format($prediccion, 2) . '.',
                'decision' => 'Planificar inventario y promociones con base en la tendencia reciente.',
            ];
        }

        if (count($propuestas) === 0) {
            $propuestas[] = [
                'situacion' => 'Sin datos suficientes',
                'hallazgo' => 'No existen registros procesados para generar conclusiones.',
                'decision' => 'Importar y limpiar el archivo de ventas antes de generar reportes.',
            ];
        }

        return $propuestas;
    }
}
