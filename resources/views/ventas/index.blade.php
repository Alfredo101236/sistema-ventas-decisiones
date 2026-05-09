@extends('layouts.panel')

@section('title', 'Ventas registradas')

@section('page-title', 'Ventas registradas')

@section('page-subtitle', 'Consulta de registros comerciales importados y preparados para análisis')

@section('content')

@php
    $rutaVentas = auth()->user()->role === 'administrador'
        ? route('admin.ventas.index')
        : route('analista.ventas.index');
@endphp

<div class="cards-grid">
    <div class="card">
        <p class="card-label">Registros encontrados</p>
        <h2>{{ $totalRegistros }}</h2>
        <span class="card-note">Ventas filtradas</span>
    </div>

    <div class="card">
        <p class="card-label">Total vendido</p>
        <h2>${{ number_format((float) $totalVendido, 2) }}</h2>
        <span class="card-note success">Ingreso acumulado</span>
    </div>

    <div class="card">
        <p class="card-label">Cantidad vendida</p>
        <h2>{{ number_format((float) $cantidadVendida) }}</h2>
        <span class="card-note">Unidades registradas</span>
    </div>

    <div class="card">
        <p class="card-label">Promedio por venta</p>
        <h2>${{ number_format((float) $promedioVenta, 2) }}</h2>
        <span class="card-note">Promedio filtrado</span>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h3>Filtros de búsqueda</h3>
        <p>Consulta las ventas por periodo, producto, categoría, región o estado de limpieza.</p>
    </div>

    <form method="GET" action="{{ $rutaVentas }}" class="filters-form">
        <div class="filters-grid">
            <div class="form-group">
                <label for="fecha_inicio">Fecha inicial</label>
                <input type="date" id="fecha_inicio" name="fecha_inicio" value="{{ request('fecha_inicio') }}">
            </div>

            <div class="form-group">
                <label for="fecha_fin">Fecha final</label>
                <input type="date" id="fecha_fin" name="fecha_fin" value="{{ request('fecha_fin') }}">
            </div>

            <div class="form-group">
                <label for="producto">Producto</label>
                <select id="producto" name="producto">
                    <option value="">Todos</option>
                    @foreach($productos as $producto)
                        <option value="{{ $producto }}" @selected(request('producto') === $producto)>
                            {{ $producto }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="categoria">Categoría</label>
                <select id="categoria" name="categoria">
                    <option value="">Todas</option>
                    @foreach($categorias as $categoria)
                        <option value="{{ $categoria }}" @selected(request('categoria') === $categoria)>
                            {{ $categoria }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="region">Región</label>
                <select id="region" name="region">
                    <option value="">Todas</option>
                    @foreach($regiones as $region)
                        <option value="{{ $region }}" @selected(request('region') === $region)>
                            {{ $region }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="form-group">
                <label for="estado_limpieza">Estado</label>
                <select id="estado_limpieza" name="estado_limpieza">
                    <option value="">Todos</option>
                    <option value="Correcto" @selected(request('estado_limpieza') === 'Correcto')>Correcto</option>
                    <option value="Corregido" @selected(request('estado_limpieza') === 'Corregido')>Corregido</option>
                    <option value="Requiere revisión" @selected(request('estado_limpieza') === 'Requiere revisión')>Requiere revisión</option>
                    <option value="Sin revisar" @selected(request('estado_limpieza') === 'Sin revisar')>Sin revisar</option>
                </select>
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ $rutaVentas }}" class="btn-secondary">
                Limpiar filtros
            </a>

            <button type="submit" class="btn-primary">
                Aplicar filtros
            </button>
        </div>
    </form>
</div>

<div class="panel">
    <div class="panel-header panel-between">
        <div>
            <h3>Listado de ventas</h3>
            <p>Registros almacenados en la base de datos después de la importación del CSV.</p>
        </div>

        <span class="table-counter">
            Mostrando {{ $ventas->count() }} de {{ $ventas->total() }} registros
        </span>
    </div>

    <div class="table-responsive">
        <table class="data-table">
            <thead>
                <tr>
                    <th>ID venta</th>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Categoría</th>
                    <th>Región</th>
                    <th>Cantidad</th>
                    <th>Precio unitario</th>
                    <th>Total</th>
                    <th>Estado</th>
                </tr>
            </thead>

            <tbody>
                @forelse($ventas as $venta)
                    <tr>
                        <td>{{ $venta->id_venta ?: 'N/D' }}</td>

                        <td>
                            {{ optional($venta->fecha)->format('d/m/Y') ?? 'Sin fecha' }}
                        </td>

                        <td>{{ $venta->producto ?: 'No disponible' }}</td>

                        <td>{{ $venta->categoria ?: 'No disponible' }}</td>

                        <td>{{ $venta->region ?: 'No disponible' }}</td>

                        <td>
                            {{ $venta->cantidad ?? 'N/D' }}
                        </td>

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
                            @elseif($venta->estado_limpieza === 'Requiere revisión')
                                <span class="badge-status warning">Requiere revisión</span>
                            @else
                                <span class="badge-status neutral">Sin revisar</span>
                            @endif
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="9">
                            No se encontraron registros de ventas con los filtros seleccionados.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="pagination-box">
        {{ $ventas->links() }}
    </div>
</div>

@endsection