<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Sistema de Ventas')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

@php
    $user = auth()->user();

    $roleLabels = [
        'administrador' => 'Administrador',
        'analista' => 'Analista de Ventas',
        'gerente' => 'Gerente Comercial',
    ];

    $roleLabel = $roleLabels[$user->role] ?? 'Usuario';
@endphp

<body class="app-body">

    <div class="app-container">

        <aside class="sidebar">
            <div class="sidebar-header">
                <h2>SAV</h2>
                <p>Análisis de Ventas</p>
            </div>

            <nav class="sidebar-menu">

    @if($user->role === 'administrador')
        <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">Inicio</a>
        <a href="{{ route('admin.usuarios.index') }}" class="{{ request()->routeIs('admin.usuarios.*') ? 'active' : '' }}">Usuarios</a>
        <a href="{{ route('admin.csv.index') }}" class="{{ request()->routeIs('admin.csv.*') ? 'active' : '' }}">Cargar CSV</a>
        <a href="{{ route('admin.limpieza.index') }}" class="{{ request()->routeIs('admin.limpieza.*') ? 'active' : '' }}">Limpieza de datos</a>
        <a href="{{ route('admin.ventas.index') }}" class="{{ request()->routeIs('admin.ventas.*') ? 'active' : '' }}">Ventas</a>
        <a href="{{ route('admin.reportes.index') }}" class="{{ request()->routeIs('admin.reportes.*') ? 'active' : '' }}">Reportes</a>
    @endif

    @if($user->role === 'analista')
        <a href="{{ route('analista.dashboard') }}" class="{{ request()->routeIs('analista.dashboard') ? 'active' : '' }}">Inicio</a>
        <a href="{{ route('analista.limpieza.index') }}" class="{{ request()->routeIs('analista.limpieza.*') ? 'active' : '' }}">Limpieza de datos</a>
        <a href="{{ route('analista.ventas.index') }}" class="{{ request()->routeIs('analista.ventas.*') ? 'active' : '' }}">Ventas</a>
        <a href="{{ route('analista.analisis.index') }}" class="{{ request()->routeIs('analista.analisis.*') ? 'active' : '' }}">Análisis descriptivo</a>
        <a href="{{ route('analista.consultas.index') }}" class="{{ request()->routeIs('analista.consultas.*') ? 'active' : '' }}">Consultas SQL</a>
        <a href="{{ route('analista.prediccion.index') }}" class="{{ request()->routeIs('analista.prediccion.*') ? 'active' : '' }}">Predicción</a>
    @endif

    @if($user->role === 'gerente')
        <a href="{{ route('gerente.dashboard') }}" class="{{ request()->routeIs('gerente.dashboard') ? 'active' : '' }}">Inicio</a>
        <a href="{{ route('gerente.analisis.index') }}" class="{{ request()->routeIs('gerente.analisis.*') ? 'active' : '' }}">Análisis descriptivo</a>
        <a href="{{ route('gerente.prediccion.index') }}" class="{{ request()->routeIs('gerente.prediccion.*') ? 'active' : '' }}">Predicción</a>
        <a href="{{ route('gerente.propuestas.index') }}" class="{{ request()->routeIs('gerente.propuestas.*') ? 'active' : '' }}">Propuestas</a>
        <a href="{{ route('gerente.reportes.index') }}" class="{{ request()->routeIs('gerente.reportes.*') ? 'active' : '' }}">Reportes</a>
    @endif

</nav>

            <div class="sidebar-footer">
    <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="logout-link">Cerrar sesión</button>
    </form>
    <span>Versión académica</span>
    </div>
        </aside>

        <main class="main-content">

            <header class="topbar">
                <div>
                    <h1>@yield('page-title', 'Panel principal')</h1>
                    <p>@yield('page-subtitle', 'Sistema de análisis y predicción de ventas')</p>
                </div>

                <div class="user-box">
                    <span class="user-name">{{ $user->name }}</span>
                    <span class="user-role">{{ $roleLabel }}</span>
                </div>
            </header>

            <section class="content">
                @yield('content')
            </section>

        </main>

    </div>
  
    @yield('scripts')
    
</body>
</html>