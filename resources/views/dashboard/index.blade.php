@extends('layouts.panel')

@section('title', 'Dashboard - Sistema de Ventas')

@section('page-title', 'Dashboard general')

@section('page-subtitle', 'Resumen visual del comportamiento de ventas')

@section('content')

<div class="cards-grid">
    <div class="card">
        <p class="card-label">Ventas totales</p>
        <h2>$ 0.00</h2>
        <span class="card-note success">Indicador general</span>
    </div>

    <div class="card">
        <p class="card-label">Registros cargados</p>
        <h2>1200</h2>
        <span class="card-note">Dataset principal</span>
    </div>

    <div class="card">
        <p class="card-label">Producto más vendido</p>
        <h2>Por definir</h2>
        <span class="card-note warning">Después del análisis</span>
    </div>

    <div class="card">
        <p class="card-label">Región destacada</p>
        <h2>Por definir</h2>
        <span class="card-note">Resultado del dashboard</span>
    </div>
</div>

<div class="dashboard-grid">
    <div class="panel large-panel">
        <div class="panel-header">
            <h3>Tendencia de ventas mensuales</h3>
            <p>Espacio reservado para gráfica de línea</p>
        </div>

        <div class="chart-placeholder">
            Gráfica de ventas por mes
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Productos más vendidos</h3>
            <p>Espacio reservado para gráfica de barras</p>
        </div>

        <div class="chart-placeholder small">
            Top 10 productos
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Ventas por región</h3>
            <p>Comparación entre regiones</p>
        </div>

        <div class="chart-placeholder small">
            Gráfica por región
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h3>Resumen para la toma de decisiones</h3>
        <p>Esta sección mostrará los hallazgos principales del análisis.</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Elemento analizado</th>
                <th>Resultado esperado</th>
                <th>Decisión sugerida</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Producto con mayor demanda</td>
                <td>Por calcular</td>
                <td>Aumentar inventario</td>
            </tr>
            <tr>
                <td>Producto con baja rotación</td>
                <td>Por calcular</td>
                <td>Aplicar promoción</td>
            </tr>
            <tr>
                <td>Mes con mayor venta</td>
                <td>Por calcular</td>
                <td>Preparar inventario anticipadamente</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection