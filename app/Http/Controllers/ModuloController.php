<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;


class ModuloController extends Controller
{
    private function vista(array $data)
    {
        return view('modulos.placeholder', $data);
    }

    public function usuarios()
    {
        return $this->vista([
            'titulo' => 'Gestión de usuarios',
            'subtitulo' => 'Administración de accesos y roles del sistema',
            'indicadores' => [
                ['label' => 'Usuarios registrados', 'valor' => '3', 'nota' => 'Roles activos', 'tipo' => 'success'],
                ['label' => 'Administradores', 'valor' => '1', 'nota' => 'Control general'],
                ['label' => 'Analistas', 'valor' => '1', 'nota' => 'Análisis de datos'],
                ['label' => 'Gerentes', 'valor' => '1', 'nota' => 'Toma de decisiones'],
            ],
            'panelTitulo' => 'Funciones de administración',
            'panelDescripcion' => 'Este módulo permitirá registrar, editar y consultar usuarios autorizados.',
            'acciones' => [
                ['titulo' => 'Registrar usuario', 'descripcion' => 'Crear accesos para usuarios autorizados.'],
                ['titulo' => 'Asignar rol', 'descripcion' => 'Definir permisos según el perfil del usuario.'],
                ['titulo' => 'Editar información', 'descripcion' => 'Actualizar nombre, correo y rol asignado.'],
                ['titulo' => 'Consultar usuarios', 'descripcion' => 'Revisar la lista de usuarios registrados.'],
            ],
            'estados' => [
                ['texto' => 'Módulo disponible', 'tipo' => 'success'],
                ['texto' => 'Roles definidos', 'tipo' => 'success'],
                ['texto' => 'Gestión detallada pendiente de implementar', 'tipo' => 'warning'],
            ],
            'uso' => 'Este módulo permite controlar quién puede acceder al sistema y qué funciones puede utilizar.',
            'mensaje' => 'Control de acceso',
            'filas' => [
                ['elemento' => 'Administrador', 'descripcion' => 'Gestiona usuarios, carga de datos y reportes.', 'estado' => 'Activo'],
                ['elemento' => 'Analista de Ventas', 'descripcion' => 'Revisa limpieza, consultas y análisis.', 'estado' => 'Activo'],
                ['elemento' => 'Gerente Comercial', 'descripcion' => 'Consulta indicadores, predicción y propuestas.', 'estado' => 'Activo'],
            ],
        ]);
    }

    public function cargarCsv()
    {
        return $this->vista([
            'titulo' => 'Carga de archivo de ventas',
            'subtitulo' => 'Importación del archivo comercial en formato CSV',
            'indicadores' => [
                ['label' => 'Archivo cargado', 'valor' => 'No', 'nota' => 'Carga requerida', 'tipo' => 'warning'],
                ['label' => 'Registros importados', 'valor' => '0', 'nota' => 'Sin datos'],
                ['label' => 'Formato esperado', 'valor' => 'CSV', 'nota' => 'Compatible'],
                ['label' => 'Estado', 'valor' => 'En espera', 'nota' => 'Pendiente', 'tipo' => 'warning'],
            ],
            'panelTitulo' => 'Proceso de importación',
            'panelDescripcion' => 'Este módulo permitirá cargar el archivo de ventas para iniciar el análisis.',
            'acciones' => [
                ['titulo' => 'Seleccionar archivo', 'descripcion' => 'Permitir la carga del archivo CSV.'],
                ['titulo' => 'Validar encabezados', 'descripcion' => 'Verificar que el archivo tenga las columnas requeridas.'],
                ['titulo' => 'Previsualizar datos', 'descripcion' => 'Mostrar una muestra antes de procesar.'],
                ['titulo' => 'Guardar información', 'descripcion' => 'Importar registros válidos a la base de datos.'],
            ],
            'estados' => [
                ['texto' => 'Módulo preparado', 'tipo' => 'success'],
                ['texto' => 'Archivo pendiente de carga', 'tipo' => 'warning'],
                ['texto' => 'Importación aún no ejecutada', 'tipo' => 'warning'],
            ],
            'uso' => 'La carga del archivo es el punto inicial para realizar limpieza, análisis, gráficas y predicción.',
            'mensaje' => 'Entrada de datos',
            'filas' => [
                ['elemento' => 'ID de venta', 'descripcion' => 'Identificador único del registro.', 'estado' => 'Requerido'],
                ['elemento' => 'Fecha', 'descripcion' => 'Fecha en que se realizó la venta.', 'estado' => 'Requerido'],
                ['elemento' => 'Total', 'descripcion' => 'Importe final de la venta.', 'estado' => 'Requerido'],
            ],
        ]);
    }

    public function limpieza()
    {
        return $this->vista([
            'titulo' => 'Limpieza de datos',
            'subtitulo' => 'Validación y preparación de registros de ventas',
            'indicadores' => [
                ['label' => 'Registros revisados', 'valor' => '0', 'nota' => 'Sin datos'],
                ['label' => 'Registros corregidos', 'valor' => '0', 'nota' => 'Sin proceso'],
                ['label' => 'Advertencias', 'valor' => '0', 'nota' => 'Sin observaciones'],
                ['label' => 'Estado', 'valor' => 'En espera', 'nota' => 'Requiere archivo', 'tipo' => 'warning'],
            ],
            'panelTitulo' => 'Validaciones consideradas',
            'panelDescripcion' => 'El sistema revisará inconsistencias antes de utilizar los datos en reportes.',
            'acciones' => [
                ['titulo' => 'Valores faltantes', 'descripcion' => 'Detectar campos vacíos en cantidad, total u otras columnas.'],
                ['titulo' => 'Duplicados', 'descripcion' => 'Identificar registros repetidos dentro del archivo.'],
                ['titulo' => 'Formato de fecha', 'descripcion' => 'Verificar que las fechas puedan procesarse correctamente.'],
                ['titulo' => 'Total de venta', 'descripcion' => 'Validar cantidad por precio unitario contra el total.'],
            ],
            'estados' => [
                ['texto' => 'Validaciones definidas', 'tipo' => 'success'],
                ['texto' => 'Requiere datos importados', 'tipo' => 'warning'],
            ],
            'uso' => 'La limpieza permite trabajar con información confiable antes de generar análisis y predicciones.',
            'mensaje' => 'Preparación de datos',
            'filas' => [
                ['elemento' => 'Nulos', 'descripcion' => 'Campos sin información.', 'estado' => 'Por revisar'],
                ['elemento' => 'Duplicados', 'descripcion' => 'Registros repetidos.', 'estado' => 'Por revisar'],
                ['elemento' => 'Totales incorrectos', 'descripcion' => 'Diferencias entre cantidad, precio y total.', 'estado' => 'Por revisar'],
            ],
        ]);
    }

    public function ventas()
    {
        return $this->vista([
            'titulo' => 'Ventas registradas',
            'subtitulo' => 'Consulta de registros comerciales importados',
            'indicadores' => [
                ['label' => 'Ventas disponibles', 'valor' => '0', 'nota' => 'Sin datos'],
                ['label' => 'Productos', 'valor' => '0', 'nota' => 'Sin importar'],
                ['label' => 'Categorías', 'valor' => '0', 'nota' => 'Sin importar'],
                ['label' => 'Regiones', 'valor' => '0', 'nota' => 'Sin importar'],
            ],
            'panelTitulo' => 'Consulta de ventas',
            'panelDescripcion' => 'Este módulo permitirá visualizar y filtrar los registros cargados en el sistema.',
            'acciones' => [
                ['titulo' => 'Filtrar por fecha', 'descripcion' => 'Consultar ventas dentro de un periodo específico.'],
                ['titulo' => 'Filtrar por producto', 'descripcion' => 'Revisar ventas asociadas a un producto.'],
                ['titulo' => 'Filtrar por categoría', 'descripcion' => 'Agrupar información por tipo de producto.'],
                ['titulo' => 'Filtrar por región', 'descripcion' => 'Comparar ventas por zona comercial.'],
            ],
            'estados' => [
                ['texto' => 'Vista preparada', 'tipo' => 'success'],
                ['texto' => 'Sin ventas importadas', 'tipo' => 'warning'],
            ],
            'uso' => 'La consulta de ventas permite verificar la información antes del análisis descriptivo.',
            'mensaje' => 'Consulta de registros',
            'filas' => [
                ['elemento' => 'Tabla de ventas', 'descripcion' => 'Listado de registros importados.', 'estado' => 'Pendiente de datos'],
                ['elemento' => 'Filtros', 'descripcion' => 'Búsqueda por fecha, producto, categoría y región.', 'estado' => 'Pendiente'],
                ['elemento' => 'Paginación', 'descripcion' => 'Consulta ordenada de registros.', 'estado' => 'Pendiente'],
            ],
        ]);
    }

        public function analisis()
        {
        // Ventas acumuladas
        $ventasTotales = DB::table('ventas')->sum('total') ?? 0;

        // Producto principal
        $productoTop = DB::table('ventas')
            ->select('producto', DB::raw('SUM(cantidad) as total'))
            ->groupBy('producto')
            ->orderByDesc('total')
            ->first();

        // Categoría destacada
        $categoriaTop = DB::table('ventas')
            ->select('categoria', DB::raw('SUM(total) as ingreso'))
            ->groupBy('categoria')
            ->orderByDesc('ingreso')
            ->first();

        // Región destacada
        $regionTop = DB::table('ventas')
            ->select('region', DB::raw('SUM(total) as ingreso'))
            ->groupBy('region')
            ->orderByDesc('ingreso')
            ->first();

        $ventasPorMes = DB::table('ventas')
            ->select(DB::raw("strftime('%Y-%m', fecha) as mes"), DB::raw("SUM(total) as total"))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $topProductos = DB::table('ventas')
            ->select('producto', DB::raw('SUM(cantidad) as total'))
            ->groupBy('producto')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $ventasCategoria = DB::table('ventas')
            ->select('categoria', DB::raw('SUM(total) as total'))
            ->groupBy('categoria')
            ->get();

        $ventasRegion = DB::table('ventas')
            ->select('region', DB::raw('SUM(total) as total'))
            ->groupBy('region')
            ->get();


        $ventasPorMes = DB::table('ventas')
            ->select(DB::raw("strftime('%Y-%m', fecha) as mes"), DB::raw("SUM(total) as total"))
            ->groupBy('mes')
            ->orderBy('mes')
            ->get();

        $topProductos = DB::table('ventas')
            ->select('producto', DB::raw('SUM(cantidad) as total'))
            ->groupBy('producto')
            ->orderByDesc('total')
            ->limit(5)
            ->get();

        $ventasCategoria = DB::table('ventas')
            ->select('categoria', DB::raw('SUM(total) as total'))
            ->groupBy('categoria')
            ->get();

        $ventasRegion = DB::table('ventas')
            ->select('region', DB::raw('SUM(total) as total'))
            ->groupBy('region')
            ->get();

        return view('modulos.analisis', [
            'titulo' => 'Análisis descriptivo',
            'subtitulo' => 'Interpretación del comportamiento histórico de ventas',

            'indicadores' => [
            [
                'label' => 'Ventas acumuladas',
                'valor' => '$' . number_format($ventasTotales, 2),
                'nota' => 'Ingresos totales'
            ],
            [
                'label' => 'Producto principal',
                'valor' => $productoTop->producto ?? 'Sin datos',
                'nota' => 'Mayor cantidad vendida'
            ],
            [
                'label' => 'Categoría destacada',
                'valor' => $categoriaTop->categoria ?? 'Sin datos',
                'nota' => 'Mayor ingreso'
            ],
            [
                'label' => 'Región destacada',
                'valor' => $regionTop->region ?? 'Sin datos',
                'nota' => 'Mejor desempeño'
            ],
        ],

        'panelTitulo' => 'Indicadores descriptivos',
        'panelDescripcion' => 'Análisis basado en datos reales de ventas.',

        'ventasPorMes' => $ventasPorMes,
        'topProductos' => $topProductos,
        'ventasCategoria' => $ventasCategoria,
        'ventasRegion' => $ventasRegion,

        'acciones' => [
            ['titulo' => 'Ventas por mes', 'descripcion' => 'Identificar tendencias por periodo.'],
            ['titulo' => 'Productos más vendidos', 'descripcion' => 'Detectar artículos con mayor demanda.'],
            ['titulo' => 'Ventas por categoría', 'descripcion' => 'Comparar ingresos por tipo de producto.'],
            ['titulo' => 'Ventas por región', 'descripcion' => 'Evaluar desempeño comercial por zona.'],
        ],

        'estados' => [
            ['texto' => 'Datos cargados', 'tipo' => 'success'],
            ['texto' => 'Análisis activo', 'tipo' => 'success'],
        ],

        'uso' => 'El análisis descriptivo permite comprender el comportamiento de ventas antes de tomar decisiones.',

        'mensaje' => 'Análisis comercial',

        'filas' => [
            ['elemento' => 'Ventas por mes', 'descripcion' => 'Agrupación mensual de ingresos.', 'estado' => 'Activo'],
            ['elemento' => 'Top productos', 'descripcion' => 'Productos con mayor cantidad vendida.', 'estado' => 'Activo'],
            ['elemento' => 'Categorías', 'descripcion' => 'Ingresos por categoría.', 'estado' => 'Activo'],
        ],
    ]);
}

    


    public function consultas()
{
    $totalVentas = DB::table('ventas')->count();
    $totalProductos = DB::table('ventas')->distinct()->count('producto');

    

    // Ventas por mes
    $ventasPorMes = DB::table('ventas')
        ->selectRaw("strftime('%Y-%m', fecha) as mes, SUM(total) as total")
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

    //  Top productos
    $topProductos = DB::table('ventas')
        ->select('producto', DB::raw('SUM(cantidad) as total'))
        ->groupBy('producto')
        ->orderByDesc('total')
        ->limit(10)
        ->get();

    $bajaRotacion = DB::table('ventas')
        ->select('producto', DB::raw('SUM(cantidad) as total'))
        ->groupBy('producto')
        ->having('total', '>', 0)
        ->orderBy('total', 'asc')
        ->limit(10)
        ->get();


    //  Región
    $ventasRegion = DB::table('ventas')
        ->select('region', DB::raw('SUM(total) as total'))
        ->groupBy('region')
        ->get();

    return view('modulos.consultas_sql', [
        'titulo' => 'Consultas SQL',
        'subtitulo' => 'Consultas utilizadas para obtener resultados del análisis',

        'indicadores' => [
            ['label' => 'Consultas definidas', 'valor' => '6', 'nota' => 'Consultas clave', 'tipo' => 'success'],
            ['label' => 'Motor SQL', 'valor' => 'SQLite', 'nota' => 'Base activa'],
            ['label' => 'Registros', 'valor' => $totalVentas, 'nota' => 'Ventas en BD'],
            ['label' => 'Estado', 'valor' => $totalVentas > 0 ? 'Preparado' : 'Sin datos', 'nota' => 'Listo para análisis', 'tipo' => $totalVentas > 0 ? 'success' : 'warning'],
        ],

        'panelTitulo' => 'Consultas principales',
        'panelDescripcion' => 'Este módulo mostrará las consultas SQL y sus resultados.',

        'acciones' => [
            ['titulo' => 'Ventas por mes', 'descripcion' => 'Agrupar ventas por periodo mensual.'],
            ['titulo' => 'Top 10 productos', 'descripcion' => 'Ordenar productos por cantidad vendida.'],
            ['titulo' => 'Baja rotación', 'descripcion' => 'Identificar productos con menor movimiento.'],
            ['titulo' => 'Comparación regional', 'descripcion' => 'Agrupar ventas por región.'],
        ],

        'estados' => [
            ['texto' => 'Consultas estructuradas', 'tipo' => 'success'],
            ['texto' => 'Resultados pendientes de datos', 'tipo' => 'warning'],
        ],

        'uso' => 'Las consultas SQL permitirán obtener resultados claros desde la base de datos.',

        'filas' => [
            ['elemento' => 'Ventas por mes', 'descripcion' => 'SUM(total) agrupado por fecha.', 'estado' => 'Definida'],
            ['elemento' => 'Productos más vendidos', 'descripcion' => 'Orden por cantidad total.', 'estado' => 'Definida'],
            ['elemento' => 'Ventas por categoría', 'descripcion' => 'Ingresos agrupados por categoría.', 'estado' => 'Definida'],
        ],

        
    'ventasPorMes' => $ventasPorMes,
    'topProductos' => $topProductos,
    'bajaRotacion' => $bajaRotacion,
    'ventasRegion' => $ventasRegion,
    ]);
}






    public function prediccion()
{
    $ventasPorMes = DB::table('ventas')
        ->selectRaw("strftime('%Y-%m', fecha) as mes, SUM(total) as total")
        ->groupBy('mes')
        ->orderBy('mes')
        ->get();

    $historial = $ventasPorMes->pluck('total')->toArray();

    $promedioMovil = count($historial) >= 3
        ? array_sum(array_slice($historial, -3)) / 3
        : 0;

    return view('modulos.prediccion', [
        'titulo' => 'Predicción de ventas',
        'subtitulo' => 'Estimación básica del comportamiento futuro de ventas',

        
        'ventasPorMes' => $ventasPorMes,
        'historial' => $historial,
        'promedioMovil' => $promedioMovil,
        'proyeccion' => $promedioMovil,

        'indicadores' => [
            ['label' => 'Método', 'valor' => 'Promedio móvil', 'nota' => '3 meses'],
            ['label' => 'Historial', 'valor' => count($historial), 'nota' => 'Registros detectados'],
            ['label' => 'Proyección', 'valor' => '$' . number_format($promedioMovil, 2), 'nota' => 'Estimación'],
            ['label' => 'Estado', 'valor' => count($historial) >= 3 ? 'Activo' : 'En espera', 'nota' => 'Requiere análisis', 'tipo' => 'warning'],
        ],

        'panelTitulo' => 'Modelo predictivo básico',
        'panelDescripcion' => 'Se utilizará promedio móvil para estimar ventas futuras con base en periodos anteriores.',

        'acciones' => [
            ['titulo' => 'Agrupar ventas mensuales', 'descripcion' => 'Preparar la serie histórica de ventas.'],
            ['titulo' => 'Calcular promedio móvil', 'descripcion' => 'Usar los últimos tres meses como referencia.'],
            ['titulo' => 'Mostrar proyección', 'descripcion' => 'Presentar una estimación del siguiente periodo.'],
            ['titulo' => 'Interpretar resultado', 'descripcion' => 'Explicar el posible comportamiento comercial.'],
        ],

        'estados' => [
            ['texto' => 'Método definido', 'tipo' => 'success'],
            ['texto' => 'Historial cargado', 'tipo' => count($historial) ? 'success' : 'warning'],
        ],

        'uso' => 'La predicción ayuda a anticipar demanda y preparar decisiones de inventario o promoción.',

        'mensaje' => 'Promedio móvil',

        'filas' => [
            ['elemento' => 'Serie mensual', 'descripcion' => 'Ventas agrupadas por mes.', 'estado' => 'Listo'],
            ['elemento' => 'Promedio móvil', 'descripcion' => 'Cálculo con tres periodos anteriores.', 'estado' => 'Activo'],
            ['elemento' => 'Proyección', 'descripcion' => 'Estimación del siguiente periodo.', 'estado' => 'Generado'],
        ],
    ]);
}

    public function propuestas()
{$productoTop = DB::table('ventas')
    ->select(
        'producto',
        DB::raw('SUM(cantidad) as total'),
        DB::raw('SUM(total) as ingresos')
    )
    ->groupBy('producto')
    ->orderByDesc('ingresos')
    ->first();


$productoBaja = DB::table('ventas')
    ->select(
        'producto',
        DB::raw('SUM(cantidad) as total'),
        DB::raw('SUM(total) as ingresos')
    )
    ->groupBy('producto')
    ->orderBy('total')
    ->first();


$regionTop = DB::table('ventas')
    ->select(
        'region',
        DB::raw('SUM(total) as ingreso')
    )
    ->groupBy('region')
    ->orderByDesc('ingreso')
    ->first();


$mesTop = DB::table('ventas')
    ->selectRaw("
        strftime('%Y-%m', fecha) as mes,
        SUM(total) as total
    ")
    ->groupBy('mes')
    ->orderByDesc('total')
    ->first();
    $propuestas = [

    [
        'tipo' => 'Inventario',

        'elemento' =>
            $productoTop->producto ?? 'Sin datos',

        'ingreso' =>
            $productoTop->ingresos ?? 0,

        'descripcion' =>
            'Producto con mayor demanda registrada.',

        'accion' =>
            'Aumentar inventario y asegurar disponibilidad.',

        'prioridad' => 'Alta'
    ],

    [
        'tipo' => 'Promoción',

        'elemento' =>
            $productoBaja->producto ?? 'Sin datos',

        'ingreso' =>
            $productoBaja->ingresos ?? 0,

        'descripcion' =>
            'Producto con baja rotación comercial.',

        'accion' =>
            'Aplicar descuentos o promociones estratégicas.',

        'prioridad' => 'Media'
    ],

    [
        'tipo' => 'Región fuerte',

        'elemento' =>
            $regionTop->region ?? 'Sin datos',

        'ingreso' =>
            $regionTop->ingreso ?? 0,

        'descripcion' =>
            'Zona con mayor generación de ingresos.',

        'accion' =>
            'Reforzar campañas y distribución.',

        'prioridad' => 'Alta'
    ],

    [
        'tipo' => 'Temporada alta',

        'elemento' =>
            $mesTop->mes ?? 'Sin datos',

        'ingreso' =>
            $mesTop->total ?? 0,

        'descripcion' =>
            'Periodo con el mayor volumen de ventas.',

        'accion' =>
            'Preparar inventario anticipadamente.',

        'prioridad' => 'Alta'
    ],
];
    return view('modulos.propuestas', [

        'titulo' => 'Propuestas de decisión',

        'subtitulo' =>
            'Recomendaciones comerciales basadas en resultados reales del análisis',

        'indicadores' => [

            [
                'label' => 'Propuestas generadas',
                'valor' => count($propuestas),
                'nota' => 'Resultados automáticos',
                'tipo' => 'success'
            ],

            [
                'label' => 'Inventario',
                'valor' => 'Optimización',
                'nota' => 'Basado en demanda',
                'tipo' => 'success'
            ],

            [
                'label' => 'Promociones',
                'valor' => 'Disponibles',
                'nota' => 'Productos lentos',
                'tipo' => 'warning'
            ],

            [
                'label' => 'Regiones',
                'valor' => $regionTop->region ?? 'Sin datos',
                'nota' => 'Mayor rendimiento',
                'tipo' => 'success'
            ],
        ],

        'acciones' => [

            [
                'titulo' => 'Inventario',
                'descripcion' =>
                    'Aumentar disponibilidad de productos con alta demanda.'
            ],

            [
                'titulo' => 'Promociones',
                'descripcion' =>
                    'Aplicar descuentos a productos con baja rotación.'
            ],

            [
                'titulo' => 'Temporadas altas',
                'descripcion' =>
                    'Preparar existencias antes de periodos con mayor venta.'
            ],

            [
                'titulo' => 'Regiones fuertes',
                'descripcion' =>
                    'Reforzar distribución en zonas con mejor desempeño.'
            ],
        ],

        'estados' => [

            [
                'texto' => 'Propuestas generadas automáticamente',
                'tipo' => 'success'
            ],

            [
                'texto' => 'Análisis comercial activo',
                'tipo' => 'success'
            ],
        ],

        'uso' =>
            'Este módulo convierte los resultados del análisis en acciones comerciales concretas.',

        'propuestas' => $propuestas
    ]);
}

    public function reportes()
    {
        return $this->vista([
            'titulo' => 'Reportes generales',
            'subtitulo' => 'Resultados consolidados del análisis comercial',
            'indicadores' => [
                ['label' => 'Reportes disponibles', 'valor' => '0', 'nota' => 'Sin datos'],
                ['label' => 'Ventas acumuladas', 'valor' => '$0.00', 'nota' => 'Sin procesar'],
                ['label' => 'Indicadores', 'valor' => '0', 'nota' => 'Sin calcular'],
                ['label' => 'Estado', 'valor' => 'En espera', 'nota' => 'Requiere análisis', 'tipo' => 'warning'],
            ],
            'panelTitulo' => 'Contenido del reporte',
            'panelDescripcion' => 'El reporte integrará resultados, interpretación y apoyo para la toma de decisiones.',
            'acciones' => [
                ['titulo' => 'Resumen de ventas', 'descripcion' => 'Mostrar el comportamiento general de las ventas.'],
                ['titulo' => 'Productos destacados', 'descripcion' => 'Identificar productos con mayor y menor movimiento.'],
                ['titulo' => 'Resultados por región', 'descripcion' => 'Comparar el desempeño comercial por zona.'],
                ['titulo' => 'Recomendaciones', 'descripcion' => 'Presentar propuestas derivadas del análisis.'],
            ],
            'estados' => [
                ['texto' => 'Estructura preparada', 'tipo' => 'success'],
                ['texto' => 'Resultados pendientes', 'tipo' => 'warning'],
            ],
            'uso' => 'Los reportes permiten presentar los resultados principales del sistema de manera clara.',
            'mensaje' => 'Salida de información',
            'filas' => [
                ['elemento' => 'Reporte de ventas', 'descripcion' => 'Resumen de ingresos y periodos.', 'estado' => 'Pendiente'],
                ['elemento' => 'Reporte de productos', 'descripcion' => 'Análisis de demanda y rotación.', 'estado' => 'Pendiente'],
                ['elemento' => 'Reporte gerencial', 'descripcion' => 'Información para toma de decisiones.', 'estado' => 'Pendiente'],
            ],
        ]);
    }
}