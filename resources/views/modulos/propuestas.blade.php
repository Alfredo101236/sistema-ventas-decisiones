@extends('layouts.panel')

@section('title', $titulo)

@section('page-title', $titulo)

@section('page-subtitle', $subtitulo)

@section('content')

<div class="cards-grid">

    @foreach($indicadores as $indicador)

        <div class="card">

            <p class="card-label">
                {{ $indicador['label'] }}
            </p>

            <h2>
                {{ $indicador['valor'] }}
            </h2>

            <span class="card-note {{ $indicador['tipo'] ?? '' }}">
                {{ $indicador['nota'] }}
            </span>

        </div>

    @endforeach

</div>

<div class="dashboard-grid">

    <div class="panel large-panel">

        <div class="panel-header">
            <h3>Enfoque de recomendaciones</h3>

            <p>
                Las propuestas se generan automáticamente con base en el comportamiento de ventas.
            </p>
        </div>

        <div class="quick-grid">

            @foreach($acciones as $accion)

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
        </div>

        <div class="status-list">

            @foreach($estados as $estado)

                <div>
                    <span class="dot {{ $estado['tipo'] }}"></span>

                    {{ $estado['texto'] }}
                </div>

            @endforeach

        </div>

    </div>

    <div class="panel">

        <div class="panel-header">
            <h3>Uso del sistema</h3>
        </div>

        <div class="prediction-box">
            {{ $uso }}
        </div>

    </div>

</div>

<div class="panel">

    <div class="panel-header">

        <h3>Propuestas comerciales generadas</h3>

        <p>
            Recomendaciones obtenidas automáticamente desde los datos analizados.
        </p>

    </div>

    <table class="data-table">

    <thead>

        <tr>
            <th>Tipo</th>
            <th>Elemento detectado</th>
            <th>Ingreso asociado</th>
            <th>Interpretación</th>
            <th>Acción recomendada</th>
            <th>Prioridad</th>
        </tr>

    </thead>

    <tbody>

        @foreach($propuestas as $propuesta)

            <tr>

                <td>
                    {{ $propuesta['tipo'] }}
                </td>

                <td>
                    {{ $propuesta['elemento'] }}
                </td>

                <td>
                    ${{ number_format($propuesta['ingreso'], 2) }}
                </td>

                <td>
                    {{ $propuesta['descripcion'] }}
                </td>

                <td>
                    {{ $propuesta['accion'] }}
                </td>

                <td>
                    {{ $propuesta['prioridad'] }}
                </td>

            </tr>

        @endforeach

    </tbody>

</table>

</div>

@endsection