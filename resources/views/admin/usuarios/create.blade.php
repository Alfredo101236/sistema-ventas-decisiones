@extends('layouts.panel')

@section('title', 'Nuevo usuario')

@section('page-title', 'Registrar usuario')

@section('page-subtitle', 'Alta de nuevo usuario autorizado en el sistema')

@section('content')

<div class="panel">
    <div class="panel-header">
        <h3>Datos del usuario</h3>
        <p>Completa la información necesaria para crear un acceso al sistema.</p>
    </div>

    @if ($errors->any())
        <div class="alert-error">
            Revisa los campos marcados antes de continuar.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.usuarios.store') }}" class="form-card">
        @csrf

        <div class="form-grid">
            <div class="form-group">
                <label for="name">Nombre completo</label>
                <input type="text" id="name" name="name" value="{{ old('name') }}" placeholder="Nombre del usuario">
                @error('name')
                    <small class="input-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="email">Correo electrónico</label>
                <input type="email" id="email" name="email" value="{{ old('email') }}" placeholder="usuario@empresa.com">
                @error('email')
                    <small class="input-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="role">Rol del usuario</label>
                <select id="role" name="role">
                    <option value="">Selecciona un rol</option>
                    <option value="administrador" @selected(old('role') === 'administrador')>Administrador</option>
                    <option value="analista" @selected(old('role') === 'analista')>Analista de Ventas</option>
                    <option value="gerente" @selected(old('role') === 'gerente')>Gerente Comercial</option>
                </select>
                @error('role')
                    <small class="input-error">{{ $message }}</small>
                @enderror
            </div>

            <div class="form-group">
                <label for="password">Contraseña</label>
                <input type="password" id="password" name="password" placeholder="Mínimo 8 caracteres">
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
                Guardar usuario
            </button>
        </div>
    </form>
</div>

@endsection