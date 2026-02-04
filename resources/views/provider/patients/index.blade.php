<table class="table table-row-bordered align-middle">
    <thead>
        <tr class="fw-bold text-muted">
            <th>Nombre</th>
            <th>Teléfono</th>
            <th>Correo</th>
            <th>Observaciones</th>
            <th>Estatus</th>
        </tr>
    </thead>

    <tbody>
        @forelse($patients as $patient)
            <tr>
                <td>{{ $patient->first_name }} {{ $patient->last_name }}</td>
                <td>{{ $patient->phone }}</td>
                <td>{{ $patient->email }}</td>
                <td>{{ $patient->observations }}</td>
                <td>
                    @php
                        $statusColors = [
                            'pendiente' => 'warning',
                            'cita_agendada' => 'info',
                            'atendido' => 'success',
                            'cancelado' => 'danger',
                        ];
                    @endphp

                    <span class="badge badge-light-{{ $statusColors[$patient->status] }}">
                        {{ ucfirst(str_replace('_', ' ', $patient->status)) }}
                    </span>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-muted py-10">
                    No hay pacientes registrados
                </td>
            </tr>
        @endforelse
    </tbody>
</table>
