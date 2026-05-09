@extends('layouts.panel')

@section('title', 'Panel del Gerente')

@section('page-title', 'Panel del Gerente Comercial')

@section('page-subtitle', 'Consulta de indicadores, tendencias y propuestas para la toma de decisiones')

@section('content')

<div class="cards-grid">
    <div class="card">
        <p class="card-label">Ventas acumuladas</p>
        <h2>$0.00</h2>
        <span class="card-note">Sin datos procesados</span>
    </div>

    <div class="card">
        <p class="card-label">Producto principal</p>
        <h2>No disponible</h2>
        <span class="card-note">Requiere análisis</span>
    </div>

    <div class="card">
        <p class="card-label">Región con mayor venta</p>
        <h2>No disponible</h2>
        <span class="card-note">Requiere datos</span>
    </div>

    <div class="card">
        <p class="card-label">Proyección</p>
        <h2>No disponible</h2>
        <span class="card-note warning">Sin historial procesado</span>
    </div>
</div>

<div class="dashboard-grid">
    <div class="panel large-panel">
        <div class="panel-header">
            <h3>Tendencia comercial</h3>
            <p>Visualización del comportamiento mensual de ventas.</p>
        </div>

        <div class="chart-placeholder">
            La tendencia se mostrará después de importar y procesar los datos
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Indicadores de decisión</h3>
            <p>Elementos que servirán para apoyar decisiones comerciales.</p>
        </div>

        <div class="status-list">
            <div><span class="dot success"></span> Productos con mayor demanda</div>
            <div><span class="dot warning"></span> Productos con baja rotación</div>
            <div><span class="dot success"></span> Periodos con mayor venta</div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Método predictivo</h3>
            <p>Modelo básico considerado para estimar ventas futuras.</p>
        </div>

        <div class="prediction-box">
            Promedio móvil de 3 meses
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h3>Enfoque de toma de decisiones</h3>
        <p>El sistema permitirá generar propuestas comerciales a partir de los resultados obtenidos.</p>
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
            <tr>
                <td>Alta demanda</td>
                <td>Producto con buen comportamiento de venta</td>
                <td>Reforzar inventario</td>
            </tr>
            <tr>
                <td>Baja rotación</td>
                <td>Producto con poca salida comercial</td>
                <td>Aplicar promoción</td>
            </tr>
            <tr>
                <td>Pico de ventas</td>
                <td>Periodo con mayor consumo</td>
                <td>Planificar existencias con anticipación</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection