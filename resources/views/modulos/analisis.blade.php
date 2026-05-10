@extends('layouts.panel')

@section('title', $titulo)
@section('page-title', $titulo)
@section('page-subtitle', $subtitulo)

@section('content')

@include('modulos.placeholder')

{{-- GRÁFICAS --}}
<div class="dashboard-grid">

    <div class="panel">
        <h3>Ventas por mes</h3>
        <canvas id="chartMes"></canvas>
    </div>

    <div class="panel">
        <h3>Top productos</h3>
        <canvas id="chartProductos"></canvas>
    </div>

    <div class="panel">
    <h3>Categorías</h3>

    <div style="max-width: 300px; margin: auto;">
        <canvas id="chartCategoria"></canvas>
        </div>
    </div>

    <div class="panel">
        <h3>Regiones</h3>
        <canvas id="chartRegion"></canvas>
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
new Chart(document.getElementById('chartMes'), {
    type: 'line',
    data: {
        labels: {!! json_encode($ventasPorMes->pluck('mes')) !!},
        datasets: [{
            data: {!! json_encode($ventasPorMes->pluck('total')) !!}
        }]
    }
});

new Chart(document.getElementById('chartProductos'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($topProductos->pluck('producto')) !!},
        datasets: [{
            data: {!! json_encode($topProductos->pluck('total')) !!}
        }]
    }
});

new Chart(document.getElementById('chartCategoria'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($ventasCategoria->pluck('categoria')) !!},
        datasets: [{
            data: {!! json_encode($ventasCategoria->pluck('total')) !!}
        }]
    }
});

new Chart(document.getElementById('chartRegion'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($ventasRegion->pluck('region')) !!},
        datasets: [{
            data: {!! json_encode($ventasRegion->pluck('total')) !!}
        }]
    }
});
</script>

@endsection