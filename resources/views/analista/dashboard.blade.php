@extends('layouts.panel')

@section('title', 'Panel del Analista')

@section('page-title', 'Panel del Analista de Ventas')

@section('page-subtitle', 'Revisión, preparación y análisis de la información comercial')

@section('content')

<div class="cards-grid">

    <div class="card">
        <p class="card-label">Registros disponibles</p>
        <h2>{{ $totalRegistros }}</h2>
        <span class="card-note">Ventas importadas</span>
    </div>

    <div class="card">
        <p class="card-label">Registros válidos</p>
        <h2>{{ $registrosValidos }}</h2>
        <span class="card-note">Listos para análisis</span>
    </div>

    <div class="card">
        <p class="card-label">Observaciones</p>
        <h2>{{ $registrosObservaciones }}</h2>
        <span class="card-note">Datos con inconsistencias</span>
    </div>

    <div class="card">
        <p class="card-label">Estado del análisis</p>
        <h2>{{ $totalRegistros > 0 ? 'Listo' : 'En espera' }}</h2>
        <span class="card-note">
            {{ $totalRegistros > 0 ? 'Datos disponibles' : 'Requiere datos' }}
        </span>
    </div>

</div>

<div class="dashboard-grid">

    <!-- CALIDAD DE DATOS -->
    <div class="panel large-panel">

        <div class="panel-header">
            <h3>Calidad de los datos</h3>
            <p>Resumen de registros válidos y observaciones detectadas.</p>
        </div>

        <!-- GRÁFICA -->
        <div style="max-width: 420px; margin: auto;">
            <canvas id="calidadChart"></canvas>
        </div>

    </div>

    <!-- CONSULTAS -->
    <div class="panel">
        <div class="panel-header">
            <h3>Consultas de análisis</h3>
            <p>Consultas principales para interpretar el comportamiento de ventas.</p>
        </div>

        <div class="status-list">
            <div><span class="dot success"></span> Ventas por mes</div>
            <div><span class="dot success"></span> Productos más vendidos</div>
            <div><span class="dot success"></span> Ventas por categoría</div>
            <div><span class="dot success"></span> Comparación por región</div>
        </div>
    </div>

    <!-- VALIDACIONES -->
    <div class="panel">
        <div class="panel-header">
            <h3>Validaciones requeridas</h3>
            <p>Aspectos detectados en la calidad de datos.</p>
        </div>

        <div class="status-list">
            <div><span class="dot warning"></span> Valores faltantes</div>
            <div><span class="dot warning"></span> Duplicados</div>
            <div><span class="dot warning"></span> Totales inconsistentes</div>
        </div>
    </div>

</div>


<!-- FLUJO -->
<div class="panel">

    <div class="panel-header">
        <h3>Flujo de análisis</h3>
        <p>Proceso utilizado para transformar los datos en información útil.</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Etapa</th>
                <th>Actividad</th>
                <th>Resultado</th>
            </tr>
        </thead>

        <tbody>
            <tr>
                <td>Preparación</td>
                <td>Revisión de registros cargados</td>
                <td>Identificación de inconsistencias</td>
            </tr>

            <tr>
                <td>Limpieza</td>
                <td>Validación de campos clave</td>
                <td>Datos listos para análisis</td>
            </tr>

            <tr>
                <td>Análisis</td>
                <td>Aplicación de consultas SQL</td>
                <td>Patrones de ventas detectados</td>
            </tr>
        </tbody>

    </table>

</div>

<!-- GRÁFICA -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const canvas = document.getElementById('calidadChart');

if (canvas) {
    const ctx = canvas.getContext('2d');

    new Chart(ctx, {
        type: 'doughnut',
        data: {
            labels: ['Registros válidos', 'Observaciones'],
            datasets: [{
                data: [
                    {{ $registrosValidos }},
                    {{ $registrosObservaciones }}
                ],
                backgroundColor: [
                    '#2ecc71',
                    '#e74c3c'
                ]
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    position: 'bottom'
                }
            }
        }
    });
}
</script>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


@endsection