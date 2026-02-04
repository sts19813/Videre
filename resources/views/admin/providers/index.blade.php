@extends('layouts.app')

@section('title', 'Admin | Proveedores')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h4 fw-bold">Proveedores</h1>

    <button
        class="btn btn-primary"
        data-bs-toggle="modal"
        data-bs-target="#providerModal"
    >
        Agregar proveedor
    </button>
</div>

@if(session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

<div class="card shadow-sm">
    <div class="card-body p-0">
        <table class="table table-striped mb-0">
            <thead class="table-light">
                <tr>
                    <th>Nombre</th>
                    <th>Email</th>
                    <th>Teléfono</th>
                </tr>
            </thead>
            <tbody>
                @forelse($providers as $provider)
                    <tr>
                        <td>{{ $provider->name }}</td>
                        <td>{{ $provider->email }}</td>
                        <td>{{ $provider->phone }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center text-muted">
                            No hay proveedores
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@include('admin.providers.modal')

@endsection
