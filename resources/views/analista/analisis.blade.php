@extends('layouts.panel')

@section('title', 'Análisis descriptivo')

@section('page-title', 'Análisis descriptivo')

@section('page-subtitle', 'Interpretación del comportamiento histórico de ventas')

@section('content')

<div class="cards-grid">
    <div class="card">
        <p class="card-label">Ventas acumuladas</p>
        <h2>${{ number_format($ventasTotales ?? 0, 2) }}</h2>
        <span class="card-note">Ingresos totales</span>
    </div>

    <div class="card">
        <p class="card-label">Producto principal</p>
        <h2>{{ $productoTop ?? 'No disponible' }}</h2>
        <span class="card-note">Mayor demanda</span>
    </div>

    <div class="card">
        <p class="card-label">Categoría destacada</p>
        <h2>{{ $categoriaTop ?? 'No disponible' }}</h2>
        <span class="card-note">Mayor ingreso</span>
    </div>

    <div class="card">
        <p class="card-label">Región destacada</p>
        <h2>{{ $regionTop ?? 'No disponible' }}</h2>
        <span class="card-note">Mejor desempeño</span>
    </div>
</div>

<div class="dashboard-grid">

    <!-- VENTAS POR MES -->
    <div class="panel">
        <div class="panel-header">
            <h3>Ventas por mes</h3>
        </div>
        <canvas id="chartMes"></canvas>
    </div>

    <!-- PRODUCTOS -->
    <div class="panel">
        <div class="panel-header">
            <h3>Productos más vendidos</h3>
        </div>
        <canvas id="chartProductos"></canvas>
    </div>

    <!-- CATEGORÍAS -->
    <div class="panel">
        <div class="panel-header">
            <h3>Ventas por categoría</h3>
        </div>
        <canvas id="chartCategoria"></canvas>
    </div>

    <!-- REGIONES -->
    <div class="panel">
        <div class="panel-header">
            <h3>Ventas por región</h3>
        </div>
        <canvas id="chartRegion"></canvas>
    </div>

</div>

@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
// ================= VENTAS POR MES =================
new Chart(document.getElementById('chartMes'), {
    type: 'line',
    data: {
        labels: {!! json_encode($ventasPorMes->pluck('mes') ?? []) !!},
        datasets: [{
            label: 'Ventas',
            data: {!! json_encode($ventasPorMes->pluck('total') ?? []) !!},
            borderColor: '#3498db',
            fill: false
        }]
    }
});

// ================= PRODUCTOS =================
new Chart(document.getElementById('chartProductos'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($topProductos->pluck('producto') ?? []) !!},
        datasets: [{
            label: 'Cantidad',
            data: {!! json_encode($topProductos->pluck('total') ?? []) !!},
            backgroundColor: '#2ecc71'
        }]
    }
});

// ================= CATEGORÍAS =================
new Chart(document.getElementById('chartCategoria'), {
    type: 'doughnut',
    data: {
        labels: {!! json_encode($ventasCategoria->pluck('categoria') ?? []) !!},
        datasets: [{
            data: {!! json_encode($ventasCategoria->pluck('total') ?? []) !!},
            backgroundColor: ['#f1c40f','#e67e22','#9b59b6','#1abc9c']
        }]
    }
});

// ================= REGIONES =================
new Chart(document.getElementById('chartRegion'), {
    type: 'bar',
    data: {
        labels: {!! json_encode($ventasRegion->pluck('region') ?? []) !!},
        datasets: [{
            label: 'Ventas',
            data: {!! json_encode($ventasRegion->pluck('total') ?? []) !!},
            backgroundColor: '#e74c3c'
        }]
    },
    options: {
        indexAxis: 'y'
    }
});
</script>
@endsection