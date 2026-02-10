<div class="tab-pane fade" id="tab-users">
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Usuarios Videre</h5>
            <button class="btn btn-primary btn-sm" data-bs-toggle="modal" data-bs-target="#userCreateModal">
                <i class="ki-outline ki-plus me-1"></i> Agregar usuario
            </button>

        </div>

        <div class="card-body p-0">
            <div class="px-6 py-4">
                <table id="usersTable" class="table table-row-bordered align-middle mb-0">
                    <thead class="table-light">
                        <tr class="fw-bold text-muted">
                            <th>Nombre</th>
                            <th>Correo</th>
                            <th class="text-center">Rol</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($users as $user)
                            <tr data-id="{{ $user->id }}">
                                <td>{{ $user->name }}</td>
                                <td>{{ $user->email }}</td>
                                <td class="text-center">
                                    @if($user->is_active)
                                        <span class="badge badge-light-primary">
                                            Administrador
                                        </span>
                                    @else
                                        <span class="badge badge-light-danger">
                                            Inactivo
                                        </span>
                                    @endif
                                </td>

                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@include('admin.users.modalCreate')
@include('admin.users.show')