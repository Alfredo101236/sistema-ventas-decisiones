@extends('layouts.panel')

@section('title', 'Cargar CSV')

@section('page-title', 'Carga de archivo de ventas')

@section('page-subtitle', 'Importación del archivo comercial para iniciar el análisis de datos')

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

@if(session('resumen_importacion'))
    @php
        $resumen = session('resumen_importacion');
    @endphp

    <div class="alert-info">
        <strong>Resumen de importación:</strong>
        {{ $resumen['importados'] }} registros importados,
        {{ $resumen['correctos'] }} correctos y
        {{ $resumen['revision'] }} requieren revisión.
    </div>
@endif

<div class="cards-grid">
    <div class="card">
        <p class="card-label">Registros importados</p>
        <h2>{{ $totalVentas }}</h2>
        <span class="card-note">Ventas almacenadas</span>
    </div>

    <div class="card">
        <p class="card-label">Registros correctos</p>
        <h2>{{ $correctos }}</h2>
        <span class="card-note success">Listos para análisis</span>
    </div>

    <div class="card">
        <p class="card-label">Requieren revisión</p>
        <h2>{{ $revision }}</h2>
        <span class="card-note warning">Validación necesaria</span>
    </div>

    <div class="card">
        <p class="card-label">Formato permitido</p>
        <h2>CSV</h2>
        <span class="card-note">Archivo delimitado</span>
    </div>
</div>

<div class="dashboard-grid">
    <div class="panel large-panel">
        <div class="panel-header">
            <h3>Importar archivo de ventas</h3>
            <p>Selecciona el archivo CSV con los registros históricos de ventas.</p>
        </div>

        @if ($errors->any())
            <div class="alert-error">
                {{ $errors->first() }}
            </div>
        @endif

        <form method="POST" action="{{ route('admin.csv.store') }}" enctype="multipart/form-data" class="upload-form">
            @csrf

            <label for="archivo_csv" class="upload-box">
                <span class="upload-title">Seleccionar archivo CSV</span>
                <span class="upload-description">
                    El archivo debe contener las columnas requeridas para el análisis de ventas.
                </span>

                <input type="file" id="archivo_csv" name="archivo_csv" accept=".csv,text/csv">
            </label>

            <div class="form-actions">
                <button type="submit" class="btn-primary">
                    Importar archivo
                </button>
            </div>
        </form>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Columnas requeridas</h3>
            <p>El archivo debe respetar estos encabezados.</p>
        </div>

        <div class="status-list">
            <div><span class="dot success"></span> ID_Venta</div>
            <div><span class="dot success"></span> Fecha</div>
            <div><span class="dot success"></span> Producto</div>
            <div><span class="dot success"></span> Categoria</div>
            <div><span class="dot success"></span> Cantidad</div>
            <div><span class="dot success"></span> Precio_Unitario</div>
            <div><span class="dot success"></span> Total</div>
            <div><span class="dot success"></span> Region</div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Validaciones iniciales</h3>
            <p>Revisión aplicada durante la importación.</p>
        </div>

        <div class="status-list">
            <div><span class="dot warning"></span> Campos vacíos</div>
            <div><span class="dot warning"></span> Fechas inválidas</div>
            <div><span class="dot warning"></span> Totales incorrectos</div>
            <div><span class="dot warning"></span> Registros duplicados</div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h3>Últimos registros importados</h3>
        <p>Vista previa de las ventas almacenadas recientemente.</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>ID venta</th>
                <th>Fecha</th>
                <th>Producto</th>
                <th>Categoría</th>
                <th>Cantidad</th>
                <th>Total</th>
                <th>Estado</th>
            </tr>
        </thead>

        <tbody>
            @forelse($ultimasVentas as $venta)
                <tr>
                    <td>{{ $venta->id_venta }}</td>
                    <td>{{ optional($venta->fecha)->format('d/m/Y') ?? 'Sin fecha' }}</td>
                    <td>{{ $venta->producto ?: 'No disponible' }}</td>
                    <td>{{ $venta->categoria ?: 'No disponible' }}</td>
                    <td>{{ $venta->cantidad ?? 'N/D' }}</td>
                    <td>${{ number_format((float) $venta->total, 2) }}</td>
                    <td>
                        @if($venta->estado_limpieza === 'Correcto')
                            <span class="badge-status success">Correcto</span>
                        @else
                            <span class="badge-status warning">Requiere revisión</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="7">No se han importado registros de ventas.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection