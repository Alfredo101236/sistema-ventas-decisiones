@extends('layouts.panel')

@section('title', 'Reportes generales')

@section('page-title', 'Reportes generales')

@section('page-subtitle', 'Resultados consolidados del análisis comercial para la toma de decisiones')

@section('content')

@php
    $rutaReportes = auth()->user()->role === 'administrador'
        ? route('admin.reportes.index')
        : route('gerente.reportes.index');
@endphp

<div class="panel report-actions-panel">
    <div class="panel-header panel-between">
        <div>
            <h3>Filtros del reporte</h3>
            <p>Consulta los resultados generales por periodo.</p>
        </div>

        <button type="button" class="btn-primary" onclick="window.print()">
            Imprimir reporte
        </button>
    </div>

    <form method="GET" action="{{ $rutaReportes }}" class="filters-form">
        <div class="filters-grid compact">
            <div class="form-group">
                <label for="fecha_inicio">Fecha inicial</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            </div>

            <div class="form-group">
                <label for="fecha_fin">Fecha final</label>
                <input type="date" id="fecha_fin" name="fecha_fin" value="{{ request('fecha_fin') }}">
            </div>

            <div class="form-actions inline">
                <a href="{{ $rutaReportes }}" class="btn-secondary">
                    Limpiar
                </a>

                <button type="submit" class="btn-primary">
                    Generar reporte
                </button>
            </div>
        </div>
    </form>
</div>

<div class="cards-grid">
    <div class="card">
        <p class="card-label">Ventas acumuladas</p>
        <h2>${{ number_format((float) $ventasAcumuladas, 2) }}</h2>
        <span class="card-note success">Ingreso total</span>
    </div>

    <div class="card">
        <p class="card-label">Registros válidos</p>
        <h2>{{ $totalRegistros }}</h2>
        <span class="card-note">Correctos y corregidos</span>
    </div>

    <div class="card">
        <p class="card-label">Unidades vendidas</p>
        <h2>{{ number_format((float) $cantidadTotal) }}</h2>
        <span class="card-note">Cantidad acumulada</span>
    </div>

    <div class="card">
        <p class="card-label">Promedio por venta</p>
        <h2>${{ number_format((float) $promedioVenta, 2) }}</h2>
        <span class="card-note">Ticket promedio</span>
    </div>
</div>

<div class="cards-grid">
    <div class="card">
        <p class="card-label">Producto más vendido</p>
        <h2>{{ $productoTop->producto ?? 'No disponible' }}</h2>
        <span class="card-note">
            {{ $productoTop ? number_format((float) $productoTop->cantidad_total) . ' unidades' : 'Sin datos' }}
        </span>
    </div>

    <div class="card">
        <p class="card-label">Categoría con mayor ingreso</p>
        <h2>{{ $categoriaTop->categoria ?? 'No disponible' }}</h2>
        <span class="card-note">
            {{ $categoriaTop ? '$' . number_format((float) $categoriaTop->ingreso_total, 2) : 'Sin datos' }}
        </span>
    </div>

    <div class="card">
        <p class="card-label">Región con mayor venta</p>
        <h2>{{ $regionTop->region ?? 'No disponible' }}</h2>
        <span class="card-note">
            {{ $regionTop ? '$' . number_format((float) $regionTop->ingreso_total, 2) : 'Sin datos' }}
        </span>
    </div>

    <div class="card">
        <p class="card-label">Predicción siguiente periodo</p>
        <h2>${{ number_format((float) $prediccion, 2) }}</h2>
        <span class="card-note warning">Promedio móvil de 3 meses</span>
    </div>
</div>

<div class="reports-grid">
    <div class="panel large-panel">
        <div class="panel-header">
            <h3>Tendencia de ventas por mes</h3>
            <p>Comportamiento histórico de ingresos agrupados por periodo mensual.</p>
        </div>

        <div class="chart-card">
            <canvas id="chartVentasMes"></canvas>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Top productos</h3>
            <p>Productos con mayor cantidad vendida.</p>
        </div>

        <div class="chart-card small">
            <canvas id="chartTopProductos"></canvas>
        </div>
    </div>
</div>

<div class="reports-grid two">
    <div class="panel">
        <div class="panel-header">
            <h3>Ventas por categoría</h3>
            <p>Comparación de ingresos por categoría.</p>
        </div>

        <div class="chart-card medium">
            <canvas id="chartCategorias"></canvas>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Ventas por región</h3>
            <p>Comparación del desempeño comercial por región.</p>
        </div>

        <div class="chart-card medium">
            <canvas id="chartRegiones"></canvas>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h3>Productos con baja rotación</h3>
        <p>Productos con menor cantidad vendida dentro del periodo consultado.</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Producto</th>
                <th>Cantidad vendida</th>
                <th>Ingreso generado</th>
                <th>Interpretación</th>
            </tr>
        </thead>

        <tbody>
            @forelse($productosBajaRotacion as $producto)
                <tr>
                    <td>{{ $producto->producto }}</td>
                    <td>{{ number_format((float) $producto->cantidad_total) }}</td>
                    <td>${{ number_format((float) $producto->ingreso_total, 2) }}</td>
                    <td>Producto con bajo movimiento comercial.</td>
                </tr>
            @empty
                <tr>
                    <td colspan="4">No hay datos suficientes para identificar baja rotación.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

<div class="panel">
    <div class="panel-header">
        <h3>Propuestas para la toma de decisiones</h3>
        <p>Recomendaciones generadas a partir de los resultados del análisis.</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Situación detectada</th>
                <th>Hallazgo</th>
                <th>Propuesta estratégica</th>
            </tr>
        </thead>

        <tbody>
            @foreach($propuestas as $propuesta)
                <tr>
                    <td>{{ $propuesta['situacion'] }}</td>
                    <td>{{ $propuesta['hallazgo'] }}</td>
                    <td>{{ $propuesta['decision'] }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    if (!window.Chart) {
        return;
    }

    const mesesLabels = @json($ventasPorMes->pluck('periodo'));
    const mesesData = @json($ventasPorMes->pluck('total')->map(fn($v) => round((float) $v, 2)));

    const productosLabels = @json($topProductos->pluck('producto'));
    const productosData = @json($topProductos->pluck('cantidad_total')->map(fn($v) => (float) $v));

    const categoriasLabels = @json($ventasPorCategoria->pluck('categoria'));
    const categoriasData = @json($ventasPorCategoria->pluck('total')->map(fn($v) => round((float) $v, 2)));

    const regionesLabels = @json($ventasPorRegion->pluck('region'));
    const regionesData = @json($ventasPorRegion->pluck('total')->map(fn($v) => round((float) $v, 2)));

    const commonOptions = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: {
            legend: {
                display: true
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    };

    const ventasMesCanvas = document.getElementById('chartVentasMes');
    if (ventasMesCanvas) {
        new Chart(ventasMesCanvas, {
            type: 'line',
            data: {
                labels: mesesLabels,
                datasets: [{
                    label: 'Ventas por mes',
                    data: mesesData,
                    tension: 0.3
                }]
            },
            options: commonOptions
        });
    }

    const topProductosCanvas = document.getElementById('chartTopProductos');
    if (topProductosCanvas) {
        new Chart(topProductosCanvas, {
            type: 'bar',
            data: {
                labels: productosLabels,
                datasets: [{
                    label: 'Cantidad vendida',
                    data: productosData
                }]
            },
            options: commonOptions
        });
    }

    const categoriasCanvas = document.getElementById('chartCategorias');
    if (categoriasCanvas) {
        new Chart(categoriasCanvas, {
            type: 'bar',
            data: {
                labels: categoriasLabels,
                datasets: [{
                    label: 'Ingreso por categoría',
                    data: categoriasData
                }]
            },
            options: commonOptions
        });
    }

    const regionesCanvas = document.getElementById('chartRegiones');
    if (regionesCanvas) {
        new Chart(regionesCanvas, {
            type: 'bar',
            data: {
                labels: regionesLabels,
                datasets: [{
                    label: 'Ingreso por región',
                    data: regionesData
                }]
            },
            options: commonOptions
        });
    }
});
</script>
@endsection