<div class="tab-pane fade" id="tab-providers">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Afiliados videre</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#providerCreateModal">
                <i class="ki-outline ki-plus me-1"></i> Agregar proveedor
            </button>

        </div>

        <div class="card-body p-0">
            <div class="px-6 py-4">
                <table id="providersTable" class="table table-row-bordered align-middle gy-4">
                    <thead class="table-light">
                        <tr class="fw-bold text-muted">
                            <th>Nombre</th>
                            <th>Email</th>
                            <th class="text-center">Estatus</th>
                            <th class="text-center">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($providers as $provider)
                            <tr data-id="{{ $provider->id }}">
                                <td class="fw-semibold">
                                    {{ $provider->user->name }}
                                </td>

                                <td>{{ $provider->user->email }}</td>

                                {{-- ESTATUS --}}
                                <td class="text-center">
                                    <select class="form-select form-select-sm provider-status w-auto mx-auto">
                                        <option value="1" @selected($provider->is_active)>Activo</option>
                                        <option value="0" @selected(!$provider->is_active)>Inactivo</option>
                                    </select>
                                </td>

                                {{-- ACCIONES --}}
                                <td class="text-center">
                                    <button class="btn btn-sm btn-light-primary btn-view-provider">
                                        <i class="ki-outline ki-eye fs-5"></i>
                                    </button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.providers.modalShow')