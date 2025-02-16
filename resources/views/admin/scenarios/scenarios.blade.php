@extends('adminlte::page')

@section('title', 'Listado de Escenarios')

@section('content_header')
    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluir DataTables CSS y JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
    <h1>Escenarios</h1>
    <div class="d-flex justify-content-between mb-3">
        <a href="{{ route('scenarios.create') }}" class="btn btn-primary h-25">
            Nuevo escenario
        </a>
        <div class="d-flex flex-column align-items-center">
            <label for="filtrarEscenario" class="">Filtrar escenario</label>
            <select name="filtrar-escenario" id="filtrarEscenario" class="form-control">
                <option value="0" selected>Mostrar todos</option>
                @foreach ($desa_trainers_escenarios as $desa_trainer)
                    <option value="{{ $desa_trainer->id }}">{{ $desa_trainer->name }}</option>
                @endforeach
            </select>
        </div>
    </div>
    @if ($escenarios->isEmpty())
        <div class="alert alert-info">
            No se encontraron escenarios.
        </div>
    @else
        <table class="table table-striped" id="tabla-escenario">
            <thead>
                <tr>
                    <th>ESCENARIO</th>
                    <th>DESA TRAINER</th>
                    <th>DESCRIPCIÓN</th>
                    <th>ACCIONES</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($escenarios as $escenario)
                    <tr>
                        <td>{{ $escenario->title }}</td>
                        <td>{{ $escenario->desa_trainer->name }}</td>
                        <td>{{ $escenario->description }}</td>
                        <td class="d-flex justify-content-center">
                            <a href="{{ route('scenario.info', $escenario->id) }}" class="btn btn-primary">
                                <i class="fa fa-eye" aria-hidden="true"></i>
                            </a>
                            <a href="{{ route('scenario.edit', $escenario->id) }}" class="btn btn-warning ml-1">
                                <i class="fa fa-pen" aria-hidden="true"></i>
                            </a>
                            <form 
                            id="form-borrar-escenario-{{ $escenario->id }}"
                            method="POST"
                            class="ml-1">
                                @csrf
                                @method('delete')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                            <script>
                                document.getElementById('form-borrar-escenario-{{ $escenario->id }}').addEventListener('submit', function(event) {
                                    event.preventDefault();
                                    Swal.fire({
                                        text: '¿Estás seguro de que deseas eliminar este escenario?',
                                        icon: 'warning',
                                        showCancelButton: true,
                                        confirmButtonColor: '#3085d6',
                                        cancelButtonColor: '#d33',
                                        confirmButtonText: 'Sí',
                                        cancelButtonText: 'No'
                                    })
                                    .then((result) => {
                                        if (!result.isConfirmed) {
                                            return;
                                        } else {
                                            const url = "{{ route('scenarios.destroy', $escenario->id) }}";
                                            fetch(url, {
                                                method: 'DELETE',
                                                headers: {
                                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                                                    'Content-Type': 'application/json'
                                                },
                                            })
                                            .then(response => response.json())
                                            .then(data => {
                                                if (data.success) {
                                                    Swal.fire({
                                                        text: 'El escenario ha sido eliminado correctamente.',
                                                        icon: 'success',
                                                        confirmButtonText: 'Aceptar'
                                                    })
                                                    .then(() => {
                                                        window.location.href = "{{ route('scenarios.index') }}";
                                                    });
                                                } else {
                                                    Swal.fire({
                                                        text: 'Ocurrió un error al borrar el escenario.',
                                                        icon: 'error',
                                                        confirmButtonText: 'Aceptar'
                                                    });
                                                }
                                            })
                                            .catch(error => {
                                                console.error('Error:', error);
                                                alert('Ocurrió un error en la solicitud...');
                                            });
                                        }
                                    });
                                });
                            </script>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif

    <script>
        // DataTable
        $(document).ready(function() {
            let tabla = new DataTable('#tabla-escenario', {
                responsive: true,
                autoWidth: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json',
                }
            });
        });

        // Filtrado
        const selectFiltrado = document.getElementById('filtrarEscenario');
        selectFiltrado.addEventListener('change', function() {
            let select_value = selectFiltrado.value;
            let url = `/admin/scenarios/desa/${select_value}`;

            fetch(url, {
                method: 'GET',
                headers: {
                    'Content-type': 'application/json',
                },
            })
            .then(response => {

                if (!response.ok) {
                    throw new Error(`Error: ${response.status} - ${response.statusText}`);
                }

                return response.json();
            })
            .then(data => {
                // Renderizas los datos en el DOM
                renderizarTabla(data);
            })
        });

        // Función para renderizar escenarios en el DOM
        function renderizarTabla(scenarios) {
            const cuerpoTabla = document.querySelector('#tabla-escenario tbody');
            cuerpoTabla.innerHTML = '';

            if (!scenarios || scenarios.length === 0) {
                cuerpoTabla.innerHTML = `
                    <tr>
                        <td colspan="5" class="text-center">No hay escenarios disponibles para este filtro.</td>
                    </tr>
                `;
                return;
            }
            
            // Rutas Laravel
            const routes = {
                scenarioInfo: "{{ route('scenario.info', ':id') }}",
                scenarioEdit: "{{ route('scenarios.update', ':id') }}",
                scenarioDestroy: "{{ route('scenarios.destroy', ':id') }}"
            };

            // Por cada scenario dado; renderizar por DESA_TRAINER
            scenarios.forEach(scenario => {
                const row = document.createElement('tr');

                // Reemplazar ":id" en las rutas con el ID real
                const infoUrl = routes.scenarioInfo.replace(':id', scenario.id);
                const editUrl = routes.scenarioEdit.replace(':id', scenario.id);
                const destroyUrl = routes.scenarioDestroy.replace(':id', scenario.id);

                row.innerHTML = `
                    <td>${scenario.title}</td>
                    <td>${scenario.desa_trainer.name}</td>
                    <td>${scenario.description || 'Sin descripción'}</td>
                    <td class="d-flex justify-content-center">
                        <a href="${infoUrl}" class="btn btn-primary">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                        <a href="${editUrl}" class="btn btn-warning ml-1">
                            <i class="fa fa-pen" aria-hidden="true"></i>
                        </a>
                        <form 
                            id="form-borrar-escenario-${scenario.id}"
                            method="POST"
                            class="ml-1">
                            <button type="button" class="btn btn-danger" onclick="deleteScenario(${scenario.id})">
                                <i class="fa fa-trash" aria-hidden="true"></i>
                            </button>
                        </form>
                    </td>
                `;
                cuerpoTabla.appendChild(row);
            });
        }

        function deleteScenario(id) {
            Swal.fire({
                text: '¿Estás seguro de que deseas eliminar este escenario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Sí',
                cancelButtonText: 'No'
            }).then((result) => {
                if (result.value) {
                    fetch(`/admin/scenarios/${id}+`, {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.success) {
                            Swal.fire({
                                text: 'El escenario ha sido eliminado exitosamente.',
                                icon: 'success',
                                confirmButtonText: 'Aceptar'
                            });
                            location.reload();
                        } else {
                            Swal.fire({
                                text: 'Ocurrió un error al eliminar el SCENARIO.',
                                icon: 'error',
                                confirmButtonText: 'Aceptar'
                            });
                        }
                    })
                    .catch(error => {
                        Swal.fire({
                            title: '¡Error!',
                            text: 'Ocurrió un error al eliminar el SCENARIO.',
                            icon: 'error',
                            confirmButtonText: 'Aceptar'
                        });
                    });
                }
            });
        }
    </script>

@endsection
