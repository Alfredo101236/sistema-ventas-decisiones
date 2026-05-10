@extends('layouts.panel')

@section('title', 'Panel del Gerente')

@section('page-title', 'Panel del Gerente Comercial')

@section('page-subtitle', 'Consulta de indicadores, tendencias y propuestas para la toma de decisiones')

@section('content')

<div class="cards-grid">

    {{-- VENTAS --}}
    <div class="card">
        <p class="card-label">Ventas acumuladas</p>

        <h2>
            ${{ number_format($ventasTotales, 2) }}
        </h2>

        <span class="card-note success">
            Datos procesados
        </span>
    </div>

    {{-- PRODUCTO TOP --}}
    <div class="card">
        <p class="card-label">Producto principal</p>

        <h2>
            {{ $productoTop }}
        </h2>

        <span class="card-note">
            {{ $productoTop != 'Sin datos' ? 'Mayor demanda' : 'Requiere análisis' }}
        </span>
    </div>

    {{-- REGIÓN TOP --}}
    <div class="card">
        <p class="card-label">Región con mayor venta</p>

        <h2>
            {{ $regionTop }}
        </h2>

        <span class="card-note">
            {{ $regionTop != 'Sin datos' ? 'Mayor ingreso' : 'Requiere datos' }}
        </span>
    </div>

    {{-- PROYECCIÓN --}}
    <div class="card">
        <p class="card-label">Proyección</p>

        <h2>
            ${{ number_format($promedioMovil, 2) }}
        </h2>

        <span class="card-note {{ $promedioMovil > 0 ? 'success' : 'warning' }}">
            {{ $promedioMovil > 0 ? 'Predicción generada' : 'Sin historial procesado' }}
        </span>
    </div>

</div>

{{-- GRID PRINCIPAL --}}
<div class="dashboard-grid">

    {{-- TENDENCIA --}}
    <div class="panel large-panel">

        <div class="panel-header">
            <h3>Tendencia comercial</h3>
            <p>Visualización del comportamiento mensual de ventas.</p>
        </div>

        <div class="chart-container">
            <canvas id="tendenciaChart"></canvas>
        </div>

    </div>

    {{-- INDICADORES --}}
    <div class="panel">

        <div class="panel-header">
            <h3>Indicadores de decisión</h3>
            <p>Elementos que servirán para apoyar decisiones comerciales.</p>
        </div>

        <div class="status-list">

            <div>
                <span class="dot success"></span>
                Productos con mayor demanda
            </div>

            <div>
                <span class="dot warning"></span>
                Productos con baja rotación
            </div>

            <div>
                <span class="dot success"></span>
                Periodos con mayor venta
            </div>

        </div>

    </div>

    {{-- MÉTODO PREDICTIVO --}}
    <div class="panel">

        <div class="panel-header">
            <h3>Método predictivo</h3>
            <p>Modelo básico considerado para estimar ventas futuras.</p>
        </div>

        <div class="prediction-box">

            <strong>
                Promedio móvil de 3 meses
            </strong>

            <div class="prediction-value">
                ${{ number_format($promedioMovil, 2) }}
            </div>

        </div>

    </div>

</div>

{{-- TABLA DE DECISIONES --}}
<div class="panel">

    <div class="panel-header">
        <h3>Enfoque de toma de decisiones</h3>

        <p>
            El sistema permitirá generar propuestas comerciales a partir de los resultados obtenidos.
        </p>
    </div>

    <table class="data-table">

        <thead>
            <tr>
                <th>Indicador</th>
                <th>Interpretación</th>
                <th>Posible decisión</th>
            </tr>
        </thead>

        <tbody>

            @foreach($propuestas as $propuesta)

                <tr>

                    <td>
                        {{ $propuesta['indicador'] }}
                    </td>

                    <td>
                        {{ $propuesta['interpretacion'] }}
                    </td>

                    <td>
                        {{ $propuesta['decision'] }}
                    </td>

                </tr>

            @endforeach

        </tbody>

    </table>

</div>

@endsection


@section('scripts')

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

const meses = @json($ventasPorMes->pluck('mes'));
const totales = @json($ventasPorMes->pluck('total'));

const ctx = document.getElementById('tendenciaChart');

new Chart(ctx, {

    type: 'line',

    data: {

        labels: meses,

        datasets: [{

            label: 'Ventas mensuales',

            data: totales,

            tension: 0.3,

            fill: true

        }]
    },

    options: {

        responsive: true,

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
    }
});

</script>

@endsection