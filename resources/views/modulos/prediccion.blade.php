@extends('layouts.panel')

@section('title', 'Predicción de Ventas')

@section('content')
<div class="cards-grid">

    <div class="card">
        <p class="card-label">Método</p>
        <h2>Promedio móvil (3 meses)</h2>
    </div>

    <div class="card">
        <p class="card-label">Historial</p>
        <h2>{{ count($ventasPorMes ?? []) }}</h2>
        <small>Registros detectados</small>
    </div>

    <div class="card">
        <p class="card-label">Proyección</p>
        <h2>
            ${{ number_format($proyeccion ?? 0, 2) }}
        </h2>
        <small>Estimación siguiente periodo</small>
    </div>

    <div class="card">
        <p class="card-label">Estado</p>
        <h2>
            {{ count($ventasPorMes ?? []) >= 3 ? 'Listo' : 'En espera' }}
        </h2>
        <small>Modelo predictivo</small>
    </div>

</div>



{{-- GRÁFICA --}}
<div class="panel mt-4">
    <div class="panel-header">
        <h3>Serie histórica de ventas</h3>
    </div>

    <canvas id="prediccionChart"></canvas>
</div>



<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ventas = @json($ventasPorMes ?? []);

new Chart(document.getElementById('prediccionChart'), {
    type: 'line',
    data: {
        labels: ventas.map(v => v.mes),
        datasets: [
            {
                label: 'Ventas reales',
                data: ventas.map(v => v.total),
                borderColor: '#3498db',
                backgroundColor: 'transparent',
                tension: 0.3
            }
        ]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: true
            }
        }
    }
});
</script>



<!-- INTERPRETACIÓN DEL MODELO -->
<div class="panel">

    <div class="panel-header">
        <h3>Interpretación de la predicción</h3>
        <p>Análisis automático del comportamiento de ventas</p>
    </div>

    <div style="padding: 15px; font-size: 14px; line-height: 1.7; color: #2c3e50;">

        <p>
            El modelo de predicción se basa en un <strong>promedio móvil de 3 meses</strong>.
            Esto significa que la estimación usa los últimos datos disponibles para proyectar el siguiente periodo.
        </p>

        <p>
            La proyección actual es de:
            <strong style="color:#3498db;">
                ${{ number_format($proyeccion ?? 0, 2) }}
            </strong>
            lo que indica el comportamiento esperado de ventas.
        </p>

        <p>
            Este resultado no es exacto, sino una <strong>estimación estadística</strong>
            útil para decisiones de inventario, compras y planificación comercial.
        </p>

        <p>
            Mientras más datos históricos existan, más precisa será la predicción del modelo.
        </p>

    </div>

</div>

@endsection