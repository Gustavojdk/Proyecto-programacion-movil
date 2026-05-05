@extends('admin.layout')

@section('title', 'Dashboard - Admin')

@section('content')
    <div class="ct-header mb-4">
        <h2 class="ct-title">Panel Administrativo</h2>
        <div class="ct-subtitle">
            Gestión de trufis, rutas, paradas, radiotaxis y sindicatos.
        </div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4">
            <div class="ct-stat-card">
                <div class="card-body">
                    <div class="ct-stat-label">Total Trufis</div>
                    <div class="ct-stat-value">{{ $stats['total_trufis'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ct-stat-card">
                <div class="card-body">
                    <div class="ct-stat-label">Trufis Activos</div>
                    <div class="ct-stat-value">{{ $stats['trufis_activos'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="ct-stat-card">
                <div class="card-body">
                    <div class="ct-stat-label">Rutas Registradas</div>
                    <div class="ct-stat-value">{{ $stats['total_rutas'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="ct-stat-card">
                <div class="card-body">
                    <div class="ct-stat-label">Sindicatos</div>
                    <div class="ct-stat-value">{{ $stats['total_sindicatos'] }}</div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="ct-stat-card">
                <div class="card-body">
                    <div class="ct-stat-label">RadioTaxis</div>
                    <div class="ct-stat-value">{{ $stats['total_radiotaxis'] }}</div>
                </div>
            </div>
        </div>
    </div>

    <div class="card ct-stat-card">
        <div class="card-body">
            <h5 class="mb-3">Accesos rápidos</h5>
            <div class="d-flex flex-wrap gap-2">
                @can('admin.trufis.ver')
                    <a href="{{ route('admin.trufis.index') }}" class="btn ct-btn ct-btn-view">Trufis</a>
                @endcan
                @can('admin.rutas.ver')
                    <a href="{{ route('admin.rutas.index') }}" class="btn ct-btn ct-btn-view">Rutas</a>
                @endcan
                @can('admin.sindicatos.ver')
                    <a href="{{ route('admin.sindicatos.index') }}" class="btn ct-btn ct-btn-view">Sindicatos</a>
                @endcan
                @can('admin.radiotaxis.ver')
                    <a href="{{ route('admin.radiotaxis.index') }}" class="btn ct-btn ct-btn-view">RadioTaxis</a>
                @endcan
            </div>
        </div>
    </div>
@endsection
