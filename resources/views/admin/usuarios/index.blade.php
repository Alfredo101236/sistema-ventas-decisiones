@extends('layouts.panel')

@section('title', 'Usuarios')

@section('page-title', 'Gestión de usuarios')

@section('page-subtitle', 'Administración de accesos y roles del sistema')

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

<div class="cards-grid">
    <div class="card">
        <p class="card-label">Usuarios registrados</p>
        <h2>{{ $usuarios->count() }}</h2>
        <span class="card-note success">Total de accesos</span>
    </div>

    <div class="card">
        <p class="card-label">Administradores</p>
        <h2>{{ $usuarios->where('role', 'administrador')->count() }}</h2>
        <span class="card-note">Control general</span>
    </div>

    <div class="card">
        <p class="card-label">Analistas</p>
        <h2>{{ $usuarios->where('role', 'analista')->count() }}</h2>
        <span class="card-note">Análisis de datos</span>
    </div>

    <div class="card">
        <p class="card-label">Gerentes</p>
        <h2>{{ $usuarios->where('role', 'gerente')->count() }}</h2>
        <span class="card-note">Toma de decisiones</span>
    </div>
</div>

<div class="panel">
    <div class="panel-header panel-between">
        <div>
            <h3>Usuarios del sistema</h3>
            <p>Lista de usuarios autorizados para acceder a la plataforma.</p>
        </div>

        <a href="{{ route('admin.usuarios.create') }}" class="btn-primary">
            Nuevo usuario
        </a>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Nombre</th>
                <th>Correo electrónico</th>
                <th>Rol</th>
                <th>Fecha de registro</th>
                <th>Acciones</th>
            </tr>
        </thead>

        <tbody>
            @forelse($usuarios as $usuario)
                <tr>
                    <td>{{ $usuario->name }}</td>
                    <td>{{ $usuario->email }}</td>
                    <td>
                        @if($usuario->role === 'administrador')
                            <span class="badge-role admin">Administrador</span>
                        @elseif($usuario->role === 'analista')
                            <span class="badge-role analyst">Analista de Ventas</span>
                        @else
                            <span class="badge-role manager">Gerente Comercial</span>
                        @endif
                    </td>
                    <td>{{ $usuario->created_at->format('d/m/Y') }}</td>
                    <td>
                        <div class="table-actions">
                            <a href="{{ route('admin.usuarios.edit', $usuario) }}" class="btn-small">
                                Editar
                            </a>

                            <form method="POST" action="{{ route('admin.usuarios.destroy', $usuario) }}">
                                @csrf
                                @method('DELETE')

                                <button type="submit" class="btn-small danger" onclick="return confirm('¿Deseas eliminar este usuario?')">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5">No hay usuarios registrados.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>

@endsection