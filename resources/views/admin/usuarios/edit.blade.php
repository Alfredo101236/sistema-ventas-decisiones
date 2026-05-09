@extends('layouts.panel')

@section('title', 'Editar usuario')

@section('page-title', 'Editar usuario')

@section('page-subtitle', 'Actualización de datos y rol del usuario')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Información del usuario</h3>
        <p>Modifica únicamente los datos necesarios.</p>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            Revisa los campos marcados antes de continuar.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.usuarios.update', $usuario) }}" class="form-card">
        @csrf
        @method('PUT')

        <div class="form-grid">
            <div class="form-group">
                <label for="name">Nombre completo</label>
                <input type="text" id="name" name="name" value="{{ old('name', $usuario->name) }}">
                @error('name')
                    <small class="input-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email', $usuario->email) }}">
                @error('email')
                    <small class="input-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Rol del usuario</label>
                <select id="role" name="role">
                    <option value="administrador" @selected(old('role', $usuario->role) === 'administrador')>Administrador</option>
                    <option value="analista" @selected(old('role', $usuario->role) === 'analista')>Analista de Ventas</option>
                    <option value="gerente" @selected(old('role', $usuario->role) === 'gerente')>Gerente Comercial</option>
                </select>
                @error('role')
                    <small class="input-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Nueva contraseña</label>
                <input type="password" id="password" name="password" placeholder="Dejar vacío si no se cambiará">
                @error('password')
                    <small class="input-error">{{ $message }}</small>
                @enderror
            </div>
        </div>

        <div class="form-actions">
            <a href="{{ route('admin.usuarios.index') }}" class="btn-secondary">
                Cancelar
            </a>

            <button type="submit" class="btn-primary">
                Guardar cambios
            </button>
        </div>
    </form>
</div>

@endsection