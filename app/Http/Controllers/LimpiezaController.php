<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class LimpiezaController extends Controller
{
    public function index()
    {
        $totalVentas = Venta::count();

        $correctos = Venta::where('estado_limpieza', 'Correcto')->count();
        $corregidos = Venta::where('estado_limpieza', 'Corregido')->count();
        $revision = Venta::where('estado_limpieza', 'Requiere revisión')->count();

        $porcentajeCalidad = $totalVentas > 0
            ? round((($correctos + $corregidos) / $totalVentas) * 100, 1)
            : 0;

        $cantidadVacia = Venta::whereNull('cantidad')->count();
        $totalVacio = Venta::whereNull('total')->count();
        $fechaVacia = Venta::whereNull('fecha')->count();

        $idsDuplicados = Venta::select('id_venta')
            ->whereNotNull('id_venta')
            ->where('id_venta', '!=', '')
            ->groupBy('id_venta')
            ->havingRaw('COUNT(*) > 1')
            ->pluck('id_venta')
            ->toArray();

        $duplicados = count($idsDuplicados);

        $ventasObservadas = Venta::whereIn('estado_limpieza', ['Corregido', 'Requiere revisión'])
            ->orderBy('id')
            ->take(15)
            ->get();

        return view('limpieza.index', compact(
            'totalVentas',
            'correctos',
            'corregidos',
            'revision',
            'porcentajeCalidad',
            'cantidadVacia',
            'totalVacio',
            'fechaVacia',
            'duplicados',
            'ventasObservadas'
        ));
    }

    public function procesar()
    {
        if (Venta::count() === 0) {
            return back()->with('error', 'No hay registros de ventas para limpiar. Primero importa un archivo CSV.');
        }

        $registrosCorrectos = 0;
        $registrosCorregidos = 0;
        $registrosRevision = 0;

        DB::transaction(function () use (
            &$registrosCorrectos,
            &$registrosCorregidos,
            &$registrosRevision
        ) {
            $idsDuplicados = Venta::select('id_venta')
                ->whereNotNull('id_venta')
                ->where('id_venta', '!=', '')
                ->groupBy('id_venta')
                ->havingRaw('COUNT(*) > 1')
                ->pluck('id_venta')
                ->toArray();

            $ventas = Venta::orderBy('id')->get();

            foreach ($ventas as $venta) {
                $observaciones = [];
                $corregido = false;
                $requiereRevision = false;

                if (empty($venta->id_venta)) {
                    $observaciones[] = 'ID de venta vacío';
                    $requiereRevision = true;
                }

                if (!empty($venta->id_venta) && in_array($venta->id_venta, $idsDuplicados)) {
                    $observaciones[] = 'ID de venta duplicado';
                    $requiereRevision = true;
                }

                if (empty($venta->fecha)) {
                    $observaciones[] = 'Fecha vacía o inválida';
                    $requiereRevision = true;
                }

                if (empty($venta->producto)) {
                    $observaciones[] = 'Producto vacío';
                    $requiereRevision = true;
                }

                if (empty($venta->categoria)) {
                    $observaciones[] = 'Categoría vacía';
                    $requiereRevision = true;
                }

                if (is_null($venta->cantidad) || $venta->cantidad <= 0) {
                    $observaciones[] = 'Cantidad vacía o inválida';
                    $requiereRevision = true;
                }

                if (is_null($venta->precio_unitario) || $venta->precio_unitario <= 0) {
                    $observaciones[] = 'Precio unitario vacío o inválido';
                    $requiereRevision = true;
                }

                if (empty($venta->region)) {
                    $observaciones[] = 'Región vacía';
                    $requiereRevision = true;
                }

                if (
                    !is_null($venta->cantidad)
                    && $venta->cantidad > 0
                    && !is_null($venta->precio_unitario)
                    && $venta->precio_unitario > 0
                ) {
                    $totalCalculado = round($venta->cantidad * $venta->precio_unitario, 2);

                    if (is_null($venta->total)) {
                        $venta->total = $totalCalculado;
                        $observaciones[] = 'Total calculado automáticamente';
                        $corregido = true;
                    } else {
                        $totalActual = round((float) $venta->total, 2);

                        if (abs($totalCalculado - $totalActual) > 0.01) {
                            $venta->total = $totalCalculado;
                            $observaciones[] = 'Total corregido por inconsistencia';
                            $corregido = true;
                        }
                    }
                } else {
                    if (is_null($venta->total)) {
                        $observaciones[] = 'Total vacío y no se puede calcular';
                        $requiereRevision = true;
                    }
                }

                if ($requiereRevision) {
                    $estado = 'Requiere revisión';
                    $registrosRevision++;
                } elseif ($corregido) {
                    $estado = 'Corregido';
                    $registrosCorregidos++;
                } else {
                    $estado = 'Correcto';
                    $registrosCorrectos++;
                }

                $venta->estado_limpieza = $estado;
                $venta->observaciones = count($observaciones) > 0
                    ? implode('; ', $observaciones)
                    : 'Sin observaciones';

                $venta->save();
            }
        });

        return redirect()
            ->back()
            ->with('success', 'Proceso de limpieza ejecutado correctamente.')
            ->with('resumen_limpieza', [
                'correctos' => $registrosCorrectos,
                'corregidos' => $registrosCorregidos,
                'revision' => $registrosRevision,
            ]);
    }
}