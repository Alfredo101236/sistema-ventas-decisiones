@extends('layouts.panel')

@section('title', 'Limpieza de datos')

@section('page-title', 'Limpieza y validación de datos')

@section('page-subtitle', 'Revisión de inconsistencias, corrección de totales y preparación de registros')

@section('content')

@if(session('success'))
    <div class="alert-success">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="alert-error">
        {{ session('error') }}
    </div>
@endif

@if(session('resumen_limpieza'))
    @php
        $resumen = session('resumen_limpieza');
    @endphp

    <div class="alert-info">
        <strong>Resumen de limpieza:</strong>
        {{ $resumen['correctos'] }} registros correctos,
        {{ $resumen['corregidos'] }} corregidos y
        {{ $resumen['revision'] }} requieren revisión.
    </div>
@endif

<div class="cards-grid">
    <div class="card">
        <p class="card-label">Registros revisados</p>
        <h2>{{ $totalVentas }}</h2>
        <span class="card-note">Ventas importadas</span>
    </div>

    <div class="card">
        <p class="card-label">Correctos</p>
        <h2>{{ $correctos }}</h2>
        <span class="card-note success">Listos para análisis</span>
    </div>

    <div class="card">
        <p class="card-label">Corregidos</p>
        <h2>{{ $corregidos }}</h2>
        <span class="card-note success">Ajustados por el sistema</span>
    </div>

    <div class="card">
        <p class="card-label">Requieren revisión</p>
        <h2>{{ $revision }}</h2>
        <span class="card-note warning">Validación pendiente</span>
    </div>
</div>

<div class="dashboard-grid">
    <div class="panel large-panel">
        <div class="panel-header panel-between">
            <div>
                <h3>Proceso de limpieza</h3>
                <p>El sistema revisa valores faltantes, duplicados y diferencias entre cantidad, precio unitario y total.</p>
            </div>

            @php
                $rutaProcesar = auth()->user()->role === 'administrador'
                    ? route('admin.limpieza.procesar')
                    : route('analista.limpieza.procesar');
            @endphp

            <form method="POST" action="{{ $rutaProcesar }}">
                @csrf
                <button type="submit" class="btn-primary" onclick="return confirm('¿Deseas ejecutar la limpieza de datos?')">
                    Ejecutar limpieza
                </button>
            </form>
        </div>

        <div class="quality-grid">
            <div class="quality-box">
                <span class="quality-label">Calidad de datos</span>
                <strong>{{ $porcentajeCalidad }}%</strong>
                <p>Porcentaje de registros correctos o corregidos.</p>
            </div>

            <div class="quality-box">
                <span class="quality-label">Cantidad vacía</span>
                <strong>{{ $cantidadVacia }}</strong>
                <p>Registros sin cantidad válida.</p>
            </div>

            <div class="quality-box">
                <span class="quality-label">Total vacío</span>
                <strong>{{ $totalVacio }}</strong>
                <p>Registros sin importe de venta.</p>
            </div>

            <div class="quality-box">
                <span class="quality-label">Fechas vacías</span>
                <strong>{{ $fechaVacia }}</strong>
                <p>Registros sin fecha válida.</p>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Validaciones aplicadas</h3>
            <p>Reglas utilizadas para preparar la información.</p>
        </div>

        <div class="status-list">
            <div><span class="dot success"></span> Revisión de campos vacíos</div>
            <div><span class="dot success"></span> Validación de fechas</div>
            <div><span class="dot success"></span> Detección de duplicados</div>
            <div><span class="dot success"></span> Cálculo de total de venta</div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Duplicados detectados</h3>
            <p>Revisión por identificador de venta.</p>
        </div>

        <div class="prediction-box">
            {{ $duplicados }} ID duplicados
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h3>Registros con observaciones</h3>
        <p>Vista previa de ventas corregidas o que requieren revisión.</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID venta</th>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Cantidad</th>
                <th>Precio unitario</th>
                <th>Total</th>
                <th>Estado</th>
                <th>Observaciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($ventasObservadas as $venta)
                <tr>
                    <td>{{ $venta->id_venta ?: 'N/D' }}</td>
                    <td>{{ optional($venta->fecha)->format('d/m/Y') ?? 'Sin fecha' }}</td>
                    <td>{{ $venta->producto ?: 'No disponible' }}</td>
                    <td>{{ $venta->cantidad ?? 'N/D' }}</td>
                    <td>
                        @if(!is_null($venta->precio_unitario))
                            ${{ number_format((float) $venta->precio_unitario, 2) }}
                        @else
                            N/D
                        @endif
                    </td>
                    <td>
                        @if(!is_null($venta->total))
                            ${{ number_format((float) $venta->total, 2) }}
                        @else
                            N/D
                        @endif
                    </td>
                    <td>
                        @if($venta->estado_limpieza === 'Correcto')
                            <span class="badge-status success">Correcto</span>
                        @elseif($venta->estado_limpieza === 'Corregido')
                            <span class="badge-status info">Corregido</span>
                        @else
                            <span class="badge-status warning">Requiere revisión</span>
                        @endif
                    </td>
                    <td>{{ $venta->observaciones }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8">No hay registros con observaciones.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection