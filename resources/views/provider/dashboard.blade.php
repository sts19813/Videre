@extends('layouts.app')

@section('title', 'Dashboard | Videre')

@section('content')

    {{-- Page Header --}}
    <div class="mb-4">
        <h1 class="h4 fw-semibold text-dark mb-1">Portal del Proveedor</h1>
        <p class="text-muted mb-0">Clínica Visual</p>
    </div>

    {{-- Stats --}}
    <div class="row g-4 mb-4">

        {{-- Pacientes enviados --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-primary bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">

                        <i class="ki-outline ki-user fs-3 text-primary"></i>

                    </div>
                    <div>
                        <div class="text-muted small">Pacientes enviados</div>
                        <div class="fs-4 fw-semibold text-dark">
                            {{ $stats['sent'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pendientes --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-warning bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="ki-outline ki-time text-warning fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Pendientes</div>
                        <div class="fs-4 fw-semibold text-dark">
                            {{ $stats['pending'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Con cita --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-info bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="ki-outline ki-calendar text-info fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Con cita</div>
                        <div class="fs-4 fw-semibold text-dark">
                            {{ $stats['scheduled'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Atendidos --}}
        <div class="col-12 col-sm-6 col-xl-3">
            <div class="card border shadow-sm h-100">
                <div class="card-body d-flex align-items-center gap-3">
                    <div class="rounded-circle bg-success bg-opacity-10 d-flex align-items-center justify-content-center"
                        style="width:48px;height:48px;">
                        <i class="ki-outline ki-check-circle text-success fs-4"></i>
                    </div>
                    <div>
                        <div class="text-muted small">Atendidos</div>
                        <div class="fs-4 fw-semibold text-dark">
                            {{ $stats['attended'] ?? 0 }}
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>

    {{-- Patients --}}
    <div class="card shadow-sm">
        <div class="card-header d-flex justify-content-between align-items-center">
            <h5 class="mb-0">Listado de pacientes</h5>

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#patientCreateModal">
                Agregar paciente
            </button>
        </div>

        <div class="card-body pt-0">
            <table id="patientsTable" class="table table-row-bordered table-row-gray-300 align-middle gy-4">
                <thead>
                    <tr class="fw-bold text-muted">
                        <th>Nombre</th>
                        <th>Teléfono</th>
                        <th>Correo</th>
                        <th>Observaciones</th>
                        <th class="text-center">Estatus</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($patients as $patient)
                        <tr>
                            <td>
                                <div class="d-flex align-items-center gap-2">
                                    <i class="ki-duotone ki-user fs-3 text-primary"></i>
                                    <span class="fw-semibold">
                                        {{ $patient->first_name }} {{ $patient->last_name }}
                                    </span>
                                </div>
                            </td>

                            <td>{{ $patient->phone }}</td>
                            <td>{{ $patient->email }}</td>
                            <td class="text-muted">{{ $patient->observations }}</td>

                            <td class="text-center">
                                @php
                                    $statusMap = [
                                        'pendiente' => ['warning', 'Pendiente'],
                                        'cita_agendada' => ['info', 'Con cita'],
                                        'atendido' => ['success', 'Atendido'],
                                        'cancelado' => ['danger', 'Cancelado'],
                                    ];
                                    [$color, $label] = $statusMap[$patient->status] ?? ['secondary', 'Desconocido'];
                                @endphp

                                <span class="badge badge-light-{{ $color }} fw-bold px-4 py-2">
                                    {{ $label }}
                                </span>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="text-center text-muted py-10">
                                <i class="ki-duotone ki-information fs-2 mb-2 d-block"></i>
                                No hay pacientes registrados
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>

        </div>
    </div>

    @include('provider.patients.modal')
@endsection
@push('scripts')
    <script>
        $(document).ready(function () {

            let table = $('#patientsTable').DataTable({
                responsive: true,
                pageLength: 10,
                paging: true,
                lengthChange: true,
                ordering: true,
                info: true,
                searching: true,
                "language": { url: '//cdn.datatables.net/plug-ins/2.3.2/i18n/es-MX.json' },
                dom: "<'row mb-3'<'col-12 d-flex justify-content-end'f>>" +
                    "<'row'<'col-12'tr>>" +
                    "<'row mt-3'<'col-sm-12 col-md-6'l><'col-sm-12 col-md-6'p>>",
            });

            $('#patientsSearch').on('keyup', function () {
                table.search(this.value).draw();
            });

        });
    </script>


    <script>
        $('#referralType').on('change', function () {
            renderClinicalForm(this.value);
        });


        function renderClinicalForm(type) {
            let html = '';

            /* =====================================================
               CONSULTA GENERAL
            ===================================================== */
            if (type === 'consulta_general') {
                html = `
                                    <div class="card border-warning p-4">
                                        <h6 class="fw-bold mb-3">Información específica - Consulta general</h6>

                                        <div class="mb-3">
                                            <label class="form-label">Motivo de consulta / síntomas *</label>
                                            <textarea name="clinical_data[motivo_consulta]" 
                                                      class="form-control" 
                                                      rows="3" 
                                                      required></textarea>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Presión intraocular (mmHg)</label>
                                            <input type="text" 
                                                   name="clinical_data[presion_intraocular]" 
                                                   class="form-control" 
                                                   placeholder="Ej: 15 mmHg">
                                        </div>
                                    </div>`;
            }

            /* =====================================================
               CIRUGÍA REFRACTIVA
            ===================================================== */
            if (type === 'cirugia_refractiva') {
                html = `
                                    <div class="card border-primary p-4">
                                        <h6 class="fw-bold mb-3">Información específica - Cirugía refractiva</h6>

                                        <div class="mb-3">
                                            <label class="form-label">¿Usa lentes de contacto?</label><br>
                                            <label><input type="radio" name="clinical_data[usa_lentes]" value="si"> Sí</label>
                                            <label class="ms-3"><input type="radio" name="clinical_data[usa_lentes]" value="no"> No</label>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">¿Antecedentes familiares de queratocono?</label><br>
                                            <label><input type="radio" name="clinical_data[queratocono]" value="si"> Sí</label>
                                            <label class="ms-3"><input type="radio" name="clinical_data[queratocono]" value="no"> No</label>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">¿Embarazo o lactancia activa?</label><br>
                                            <label><input type="radio" name="clinical_data[embarazo]" value="si"> Sí</label>
                                            <label class="ms-3"><input type="radio" name="clinical_data[embarazo]" value="no"> No</label>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">¿Uso de isotretinoína en los últimos 6 meses?</label><br>
                                            <label><input type="radio" name="clinical_data[isotretinoina]" value="si"> Sí</label>
                                            <label class="ms-3"><input type="radio" name="clinical_data[isotretinoina]" value="no"> No</label>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Padecimiento actual / síntomas</label>
                                            <textarea name="clinical_data[padecimiento_actual]" 
                                                      class="form-control" 
                                                      rows="3"></textarea>
                                        </div>
                                    </div>`;
            }

            /* =====================================================
               CATARATA / CRISTALINO
            ===================================================== */
            if (type === 'catarata_cristalino') {
                html = `
                                    <div class="card border-info p-4">
                                        <h6 class="fw-bold mb-3">Información específica - Catarata / Cristalino</h6>

                                        <div class="mb-3">
                                            <label class="form-label">¿Diabetes, hipertensión o glaucoma?</label><br>
                                            <label><input type="radio" name="clinical_data[enfermedades]" value="si"> Sí</label>
                                            <label class="ms-3"><input type="radio" name="clinical_data[enfermedades]" value="no"> No</label>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">¿Cirugías oculares previas?</label><br>
                                            <label><input type="radio" name="clinical_data[cirugias_previas]" value="si"> Sí</label>
                                            <label class="ms-3"><input type="radio" name="clinical_data[cirugias_previas]" value="no"> No</label>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Síntomas o padecimiento actual</label>
                                            <textarea name="clinical_data[sintomas]" 
                                                      class="form-control" 
                                                      rows="3"></textarea>
                                        </div>
                                    </div>`;
            }

            /* =====================================================
               RETINA
            ===================================================== */
            if (type === 'retina') {
                html = `
                                    <div class="card border-success p-4">
                                        <h6 class="fw-bold mb-3">Información específica - Retina</h6>

                                        <div class="mb-3">
                                            <label class="form-label">¿Diabetes o hipertensión?</label><br>
                                            <label><input type="radio" name="clinical_data[diabetes_hipertension]" value="si"> Sí</label>
                                            <label class="ms-3"><input type="radio" name="clinical_data[diabetes_hipertension]" value="no"> No</label>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">¿Cirugías oculares previas?</label><br>
                                            <label><input type="radio" name="clinical_data[cirugias_previas]" value="si"> Sí</label>
                                            <label class="ms-3"><input type="radio" name="clinical_data[cirugias_previas]" value="no"> No</label>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">¿Traumatismo ocular reciente?</label><br>
                                            <label><input type="radio" name="clinical_data[traumatismo]" value="si"> Sí</label>
                                            <label class="ms-3"><input type="radio" name="clinical_data[traumatismo]" value="no"> No</label>
                                        </div>

                                        <div class="mb-3">
                                            <label class="form-label">Síntomas o padecimiento actual</label>
                                            <textarea name="clinical_data[sintomas]" 
                                                      class="form-control" 
                                                      rows="3"></textarea>
                                        </div>
                                    </div>`;
            }

            $('#dynamicClinicalSection').html(html);
        }
    </script>
@endpush