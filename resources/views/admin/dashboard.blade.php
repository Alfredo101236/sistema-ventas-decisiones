@extends('layouts.panel')

@section('title', 'Panel del Administrador')

@section('page-title', 'Panel del Administrador')

@section('page-subtitle', 'Gestión general del sistema, usuarios y carga de información')

@section('content')

<div class="cards-grid">
    <div class="card">
        <p class="card-label">Usuarios registrados</p>
        <h2>3</h2>
        <span class="card-note success">Roles activos</span>
    </div>

    <div class="card">
        <p class="card-label">Archivo de ventas</p>
        <h2>Sin cargar</h2>
        <span class="card-note warning">Carga requerida</span>
    </div>

    <div class="card">
        <p class="card-label">Registros procesados</p>
        <h2>0</h2>
        <span class="card-note">Sin información importada</span>
    </div>

    <div class="card">
        <p class="card-label">Base de datos</p>
        <h2>Activa</h2>
        <span class="card-note success">Disponible</span>
    </div>
</div>

<div class="dashboard-grid">
    <div class="panel large-panel">
        <div class="panel-header">
            <h3>Administración del sistema</h3>
            <p>Opciones principales para preparar la información antes del análisis.</p>
        </div>

        <div class="quick-grid">
            <div class="quick-action">
                <h4>Usuarios y roles</h4>
                <p>Permite administrar los accesos de acuerdo con las responsabilidades de cada usuario.</p>
            </div>

            <div class="quick-action">
                <h4>Carga de ventas</h4>
                <p>Permite importar el archivo con los registros históricos de ventas.</p>
            </div>

            <div class="quick-action">
                <h4>Validación de datos</h4>
                <p>Revisa la información cargada antes de utilizarla en consultas y reportes.</p>
            </div>

            <div class="quick-action">
                <h4>Reportes generales</h4>
                <p>Permite consultar resultados globales del procesamiento de información.</p>
            </div>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Roles del sistema</h3>
            <p>Perfiles disponibles para el control de acceso.</p>
        </div>

        <div class="role-list">
            <span class="role-pill">Administrador</span>
            <span class="role-pill">Analista de Ventas</span>
            <span class="role-pill">Gerente Comercial</span>
        </div>
    </div>

    <div class="panel">
        <div class="panel-header">
            <h3>Estado operativo</h3>
            <p>Condición actual de los módulos principales.</p>
        </div>

        <div class="status-list">
            <div><span class="dot success"></span> Sistema disponible</div>
            <div><span class="dot success"></span> Base de datos activa</div>
            <div><span class="dot warning"></span> Archivo de ventas sin importar</div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h3>Resumen administrativo</h3>
        <p>Este panel concentra las funciones necesarias para preparar el sistema antes del análisis comercial.</p>
    </div>

    <table class="data-table">
        <thead>
            <tr>
                <th>Módulo</th>
                <th>Función</th>
                <th>Estado actual</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Usuarios</td>
                <td>Control de accesos y asignación de roles</td>
                <td>Disponible</td>
            </tr>
            <tr>
                <td>Carga de ventas</td>
                <td>Importación del archivo de datos comerciales</td>
                <td>Sin archivo cargado</td>
            </tr>
            <tr>
                <td>Limpieza de datos</td>
                <td>Validación y preparación de la información</td>
                <td>En espera de datos</td>
            </tr>
        </tbody>
    </table>
</div>

@endsection