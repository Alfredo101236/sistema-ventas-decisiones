@extends('layouts.panel')

@section('title', 'Panel del Analista')

@section('page-title', 'Panel del Analista de Ventas')

@section('page-subtitle', 'Revisión, preparación y análisis de la información comercial')

@section('content')

<div class="cards-grid">
    <div class="card">
        <p class="card-label">Registros disponibles</p>
        <h2>0</h2>
        <span class="card-note">Sin datos importados</span>
    </div>

    <div class="card">
        <p class="card-label">Registros corregidos</p>
        <h2>0</h2>
        <span class="card-note">Sin proceso ejecutado</span>
    </div>

    <div class="card">
        <p class="card-label">Consultas preparadas</p>
        <h2>6</h2>
        <span class="card-note success">Análisis SQL</span>
    </div>

    <div class="card">
        <p class="card-label">Estado del análisis</p>
        <h2>En espera</h2>
        <span class="card-note warning">Requiere datos</span>
    </div>
</div>

<div class="dashboard-grid">
    <div class="panel large-panel">
        <div class="panel-header">
            <h3>Calidad de los datos</h3>
            <p>Resumen de registros válidos, corregidos y observaciones detectadas.</p>
        </div>

        <div class="chart-placeholder">
            La gráfica se mostrará después de procesar el archivo de ventas
        </div>
    </div>

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

    <div class="panel">
        <div class="panel-header">
            <h3>Validaciones requeridas</h3>
            <p>Aspectos que se revisarán durante la limpieza.</p>
        </div>

        <div class="status-list">
            <div><span class="dot warning"></span> Valores faltantes</div>
            <div><span class="dot warning"></span> Duplicados</div>
            <div><span class="dot warning"></span> Totales inconsistentes</div>
        </div>
    </div>
</div>

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
                <td>Validación de fechas, cantidades y totales</td>
                <td>Datos listos para consulta</td>
            </tr>
            <tr>
                <td>Análisis</td>
                <td>Aplicación de consultas SQL y gráficas</td>
                <td>Identificación de patrones de venta</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection