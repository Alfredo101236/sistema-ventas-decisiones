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
            <p>{{ $panelDescripcion ?? '' }}</p>
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
        <h3>Estado del módulo</h3>
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
        <h3>Uso del sistema</h3>
        <p>{{ $uso ?? '' }}</p>
    </div>
</div>

<div class="panel">
    <h3>{{ $tablaTitulo ?? 'Resumen' }}</h3>

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