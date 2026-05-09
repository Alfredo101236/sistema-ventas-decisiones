<?php

namespace App\Http\Controllers;

use App\Models\Venta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CsvController extends Controller
{
    public function index()
    {
        $totalVentas = Venta::count();
        $correctos = Venta::where('estado_limpieza', 'Correcto')->count();
        $revision = Venta::where('estado_limpieza', 'Requiere revisión')->count();
        $ultimasVentas = Venta::latest()->take(8)->get();

        return view('admin.csv.index', compact(
            'totalVentas',
            'correctos',
            'revision',
            'ultimasVentas'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'archivo_csv' => ['required', 'file', 'mimes:csv,txt'],
        ], [
            'archivo_csv.required' => 'Selecciona un archivo CSV.',
            'archivo_csv.file' => 'El archivo seleccionado no es válido.',
            'archivo_csv.mimes' => 'El archivo debe estar en formato CSV.',
        ]);

        $archivo = $request->file('archivo_csv');
        $ruta = $archivo->getRealPath();

        $contenido = file($ruta, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

        if (!$contenido || count($contenido) < 2) {
            return back()->with('error', 'El archivo no contiene registros suficientes para importar.');
        }

        $delimitador = $this->detectarDelimitador($contenido[0]);

        $encabezados = str_getcsv($contenido[0], $delimitador);
        $encabezados = array_map(fn ($h) => trim($this->limpiarBom($h)), $encabezados);

        $encabezadosEsperados = [
            'ID_Venta',
            'Fecha',
            'Producto',
            'Categoria',
            'Cantidad',
            'Precio_Unitario',
            'Total',
            'Region',
        ];

        if ($encabezados !== $encabezadosEsperados) {
            return back()->with('error', 'El archivo CSV no tiene las columnas esperadas. Verifica los encabezados.');
        }

        $registrosImportados = 0;
        $registrosCorrectos = 0;
        $registrosRevision = 0;
        $idsEncontrados = [];

        DB::transaction(function () use (
            $contenido,
            $delimitador,
            &$registrosImportados,
            &$registrosCorrectos,
            &$registrosRevision,
            &$idsEncontrados
        ) {
            Venta::truncate();

            foreach ($contenido as $indice => $linea) {
                if ($indice === 0) {
                    continue;
                }

                $fila = str_getcsv($linea, $delimitador);

                if (count($fila) < 8) {
                    continue;
                }

                $idVenta = trim($fila[0] ?? '');
                $fecha = $this->convertirFecha($fila[1] ?? null);
                $producto = trim($fila[2] ?? '');
                $categoria = trim($fila[3] ?? '');
                $cantidad = $this->convertirEntero($fila[4] ?? null);
                $precioUnitario = $this->convertirDecimal($fila[5] ?? null);
                $total = $this->convertirDecimal($fila[6] ?? null);
                $region = trim($fila[7] ?? '');

                $observaciones = [];

                if ($idVenta === '') {
                    $observaciones[] = 'ID de venta vacío';
                }

                if ($idVenta !== '' && in_array($idVenta, $idsEncontrados)) {
                    $observaciones[] = 'ID de venta duplicado';
                }

                if ($idVenta !== '') {
                    $idsEncontrados[] = $idVenta;
                }

                if (!$fecha) {
                    $observaciones[] = 'Fecha inválida o vacía';
                }

                if ($producto === '') {
                    $observaciones[] = 'Producto vacío';
                }

                if ($categoria === '') {
                    $observaciones[] = 'Categoría vacía';
                }

                if (is_null($cantidad)) {
                    $observaciones[] = 'Cantidad vacía o inválida';
                }

                if (is_null($precioUnitario)) {
                    $observaciones[] = 'Precio unitario vacío o inválido';
                }

                if (is_null($total)) {
                    $observaciones[] = 'Total vacío o inválido';
                }

                if ($region === '') {
                    $observaciones[] = 'Región vacía';
                }

                if (!is_null($cantidad) && !is_null($precioUnitario) && !is_null($total)) {
                    $totalCalculado = round($cantidad * $precioUnitario, 2);

                    if (abs($totalCalculado - $total) > 0.01) {
                        $observaciones[] = 'El total no coincide con cantidad por precio unitario';
                    }
                }

                $estado = count($observaciones) === 0 ? 'Correcto' : 'Requiere revisión';

                Venta::create([
                    'id_venta' => $idVenta,
                    'fecha' => $fecha,
                    'producto' => $producto,
                    'categoria' => $categoria,
                    'cantidad' => $cantidad,
                    'precio_unitario' => $precioUnitario,
                    'total' => $total,
                    'region' => $region,
                    'estado_limpieza' => $estado,
                    'observaciones' => count($observaciones) ? implode('; ', $observaciones) : 'Sin observaciones',
                ]);

                $registrosImportados++;

                if ($estado === 'Correcto') {
                    $registrosCorrectos++;
                } else {
                    $registrosRevision++;
                }
            }
        });

        return redirect()
            ->route('admin.csv.index')
            ->with('success', 'Archivo CSV importado correctamente.')
            ->with('resumen_importacion', [
                'importados' => $registrosImportados,
                'correctos' => $registrosCorrectos,
                'revision' => $registrosRevision,
            ]);
    }

    private function detectarDelimitador(string $linea): string
    {
        $comas = substr_count($linea, ',');
        $puntoComas = substr_count($linea, ';');

        return $puntoComas > $comas ? ';' : ',';
    }

    private function limpiarBom(string $texto): string
    {
        return preg_replace('/^\xEF\xBB\xBF/', '', $texto);
    }

    private function convertirFecha(?string $valor): ?string
    {
        $valor = trim((string) $valor);

        if ($valor === '') {
            return null;
        }

        $formatos = ['Y-m-d', 'd/m/Y', 'm/d/Y', 'd-m-Y', 'Y/m/d'];

        foreach ($formatos as $formato) {
            try {
                return Carbon::createFromFormat($formato, $valor)->format('Y-m-d');
            } catch (\Exception $e) {
                continue;
            }
        }

        try {
            return Carbon::parse($valor)->format('Y-m-d');
        } catch (\Exception $e) {
            return null;
        }
    }

    private function convertirEntero(?string $valor): ?int
    {
        $valor = trim((string) $valor);

        if ($valor === '') {
            return null;
        }

        $valor = str_replace(',', '', $valor);

        return is_numeric($valor) ? (int) $valor : null;
    }

    private function convertirDecimal(?string $valor): ?float
    {
        $valor = trim((string) $valor);

        if ($valor === '') {
            return null;
        }

        $valor = str_replace(['$', ','], '', $valor);

        return is_numeric($valor) ? round((float) $valor, 2) : null;
    }
}