<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Inicio de sesión - Sistema de Ventas</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="login-body">

    <main class="login-page">

        <section class="login-info">
            <span class="system-badge">Sistema comercial</span>

            <h1>Sistema de Análisis y Predicción de Ventas</h1>

            <p>
                Plataforma diseñada para consultar información histórica de ventas,
                analizar tendencias comerciales y apoyar la toma de decisiones mediante
                indicadores, reportes y proyecciones básicas.
            </p>

            <div class="login-colors-note">
                Acceso exclusivo para usuarios autorizados.
            </div>
        </section>

        <section class="login-card">
            <h2>Iniciar sesión</h2>
            <p>Ingresa tus credenciales para acceder al sistema.</p>

            @if ($errors->any())
                <div class="alert-error">
                    {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login.post') }}">
                @csrf

                <div class="form-group">
                    <label for="email">Correo electrónico</label>
                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email') }}"
                        placeholder="usuario@empresa.com"
                        required
                    >
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <input
                        type="password"
                        id="password"
                        name="password"
                        placeholder="Ingresa tu contraseña"
                        required
                    >
                </div>

                <button type="submit" class="btn-primary full">
                    Entrar al sistema
                </button>
            </form>

            <div class="login-security-note">
                El acceso se asigna de acuerdo con el rol del usuario dentro del sistema.
            </div>
        </section>

    </main>

</body>
</html>