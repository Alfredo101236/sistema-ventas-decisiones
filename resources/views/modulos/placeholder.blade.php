@extends('layouts.panel')

@section('title', $titulo ?? 'Módulo del sistema')
@section('page-title', $titulo ?? 'Módulo del sistema')
@section('page-subtitle', $subtitulo ?? 'Sección del sistema de análisis de ventas')

@section('content')

<div class="cards-grid">
    @foreach($indicadores ?? [] as $indicador)
        <div class="card">
            <p class="card-label">{{ $indicador['label'] }}</p>
            <h2>{{ $indicador['valor'] }}</h2>
            <span class="card-note {{ $indicador['tipo'] ?? '' }}">
                {{ $indicador['nota'] }}
            </span>
        </div>
    @endforeach
</div>

<div class="dashboard-grid">
    <div class="panel large-panel">
        <div class="panel-header">
            <h3>{{ $panelTitulo ?? 'Información del módulo' }}</h3>
            <p>{{ $panelDescripcion ?? 'Esta sección mostrará información relacionada con el módulo seleccionado.' }}</p>
        </div>

        <div class="quick-grid">
            @foreach($acciones ?? [] as $accion)
                <div class="quick-action">
                    <h4>{{ $accion['titulo'] }}</h4>
                    <p>{{ $accion['descripcion'] }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Estado del módulo</h3>
            <p>Condición actual de esta sección.</p>
        </div>

        <div class="status-list">
            @foreach($estados ?? [] as $estado)
                <div>
                    <span class="dot {{ $estado['tipo'] ?? 'success' }}"></span>
                    {{ $estado['texto'] }}
                </div>
            @endforeach
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Uso dentro del sistema</h3>
            <p>{{ $uso ?? 'Este módulo forma parte del flujo principal de análisis y toma de decisiones.' }}</p>
        </div>

        <div class="prediction-box">
            {{ $mensaje ?? 'Módulo disponible' }}
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h3>{{ $tablaTitulo ?? 'Resumen del módulo' }}</h3>
        <p>{{ $tablaDescripcion ?? 'Información general de la sección seleccionada.' }}</p>
    </div>

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

@endsection