@extends('admin.layouts.app')

@section('title', 'Dashboard | Panel administrativo')
@section('page_title', 'Dashboard inicial')

@section('content')
    <div class="row g-3">
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 text-muted mb-2">Usuarios activos</h2>
                    <p class="h3 mb-0">120</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 text-muted mb-2">Pedidos hoy</h2>
                    <p class="h3 mb-0">34</p>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <h2 class="h6 text-muted mb-2">Incidencias</h2>
                    <p class="h3 mb-0">2</p>
                </div>
            </div>
        </div>
    </div>

    <div class="card border-0 shadow-sm mt-4">
        <div class="card-body">
            <h2 class="h5 mb-3">Resumen del panel</h2>
            <p class="mb-0 text-muted">
                Esta es la estructura inicial del dashboard administrativo para continuar con los siguientes sprints.
            </p>
        </div>
    </div>
@endsection
