@extends('layouts.panel')

@section('page-Title', 'Consultas SQL')
@section('page-Subtitle', 'Consultas utilizadas para obtener resultados del análisis')

@section('content')

<div class="container">

    

    {{-- 🔵 RESUMEN SUPERIOR --}}
    <div class="summary-grid">

        @foreach($indicadores ?? [] as $indicador)
            <div class="summary-card">
                <h4 class="summary-title">{{ $indicador['label'] }}</h4>
                <h2 class="summary-value">{{ $indicador['valor'] }}</h2>
                <p class="summary-note">{{ $indicador['nota'] }}</p>
            </div>
        @endforeach

    </div>

    {{-- 🧩 LAYOUT PRINCIPAL --}}
    <div class="dashboard-grid">

        {{-- IZQUIERDA: CONSULTAS --}}
        <div class="main-panel">

            <h3 class="section-title">Consultas principales</h3>
            <p class="section-subtitle">
                Este módulo mostrará las consultas SQL y sus resultados.
            </p>

            <div class="cards-grid">
                @foreach($acciones ?? [] as $accion)
                    <div class="card">
                        <h4 class="card-title">{{ $accion['titulo'] }}</h4>
                        <p>{{ $accion['descripcion'] }}</p>
                    </div>
                @endforeach
            </div>

        </div>

        {{-- DERECHA --}}
        <div class="side-panel">

            <div class="panel-box">
                <h3 class="section-title">Estado del módulo</h3>

                <div class="status-list">
                    @foreach($estados ?? [] as $estado)
                        <div>
                            <span class="dot {{ $estado['tipo'] ?? 'success' }}"></span>
                            {{ $estado['texto'] }}
                        </div>
                    @endforeach
                </div>
            </div>

            <div class="panel-box mt-4">
                <h3 class="section-title">Uso del sistema</h3>
                <p>{{ $uso ?? '' }}</p>
            </div>

        </div>

    </div>

    <div class="dashboard-grid">

    <div class="panel">
        <h3>Ventas por mes</h3>
        <canvas id="chartMes"></canvas>
    </div>

    <div class="panel">
        <h3>Top 10 productos</h3>
        <canvas id="chartTop"></canvas>
    </div>

    <div class="panel">
        <h3>Baja rotación</h3>
        <canvas id="chartBaja"></canvas>
    </div>

    <div class="panel">
        <h3>Comparación regional</h3>
        <canvas id="chartRegion"></canvas>
    </div>

</div>

    {{-- 📊 RESUMEN FINAL --}}
    <div class="panel mt-4">

        <h3 class="section-title">Resumen</h3>

        <table class="data-table">
            <thead>
                <tr>
                    <th>Elemento</th>
                    <th>Descripción</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                @foreach($filas ?? [] as $fila)
                    <tr>
                        <td>{{ $fila['elemento'] }}</td>
                        <td>{{ $fila['descripcion'] }}</td>
                        <td>{{ $fila['estado'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>

    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// 📈 MES
new Chart(document.getElementById('chartMes'), {
    type: 'line',
    data: {
        labels: {!! json_encode($ventasPorMes->pluck('mes')) !!},
        datasets: [{
            label: 'Ventas',
            data: {!! json_encode($ventasPorMes->pluck('total')) !!},
            borderColor: '#3b82f6',
            backgroundColor: 'rgba(59,130,246,0.2)',
            tension: 0.4
        }]
    }
});

// 🏆 TOP
new Chart(document.getElementById('chartTop'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($topProductos->pluck('producto')) !!},
        datasets: [{
            label: 'Cantidad',
            data: {!! json_encode($topProductos->pluck('total')) !!},
            backgroundColor: '#10b981'
        }]
    }
});

// 📉 BAJA ROTACIÓN
new Chart(document.getElementById('chartBaja'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($bajaRotacion->pluck('producto')) !!},
        datasets: [{
            label: 'Menor movimiento',
            data: {!! json_encode($bajaRotacion->pluck('total')) !!},
            backgroundColor: '#f59e0b'
        }]
    }
});

// 🌎 REGIÓN
new Chart(document.getElementById('chartRegion'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($ventasRegion->pluck('region')) !!},
        datasets: [{
            label: 'Ventas',
            data: {!! json_encode($ventasRegion->pluck('total')) !!},
            backgroundColor: '#ef4444'
        }]
    },
    options: {
        indexAxis: 'y'
    }
});
</script>

@endsection