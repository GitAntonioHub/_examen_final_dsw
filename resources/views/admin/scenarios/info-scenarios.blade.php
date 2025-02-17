@extends('adminlte::page')

@section('title', 'Información escenario')

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
<div class="card mt-3">
    <div class="card-header">
        <h2>{{$escenario->title}}</h2>
    </div>
    <div class="card-body">
        <ul class="list-group">
            <li class="list-group-item"><strong>ID:</strong> {{$escenario->id}}</li>
            <li class="list-group-item"><strong>Título:</strong> {{$escenario->title}}</li>
            <li class="list-group-item"><strong>Descripción:</strong> {{$escenario->description}}</li>
            <li class="list-group-item"><strong>Fecha de creación:</strong> {{$escenario->created_at}}</li>
            <li class="list-group-item"><strong>Última actualización:</strong> {{$escenario->updated_at}}</li>
        </ul>
    </div>
</div>
<div class="d-flex justify-content-center mb-3">
    <a href="{{ route('scenario.edit', $escenario->id) }}" class="btn btn-primary mr-1">
        Modificar escenario
    </a>
    {{-- Botón para modificar el escenario --}}
    
    <a href="{{ route('scenario.edit', $escenario->id) }}" class="btn btn-primary mr-1">
        Modificar escenario
    </a>

    {{-- Nuevo botón para simular el escenario --}}
    <a href="{{ route('scenarios.play', ['id_scenario' => $escenario->id, 'id_desa' => $escenario->desa_trainer_id]) }}" class="btn btn-success mr-1">
        Simular Escenario
    </a>

    {{-- Form para borrar el escenario --}}
    <form method="POST" id="form-borrar-escenario" action="{{ route('scenarios.destroy', $escenario->id) }}">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger">
            Borrar escenario
        </button>
    </form>
    <a href="{{ route('scenarios.index') }}" class="btn btn-secondary ml-2">
        Volver
    </a>
</div>


<br>

@if($instructions->isEmpty())
    <br>
    <h4>No hay instrucciones registradas.</h4>
@else
    <h2>Instrucciones</h2>
    <table class="table table-striped" id="instructions-table">
        <thead>
            <tr>
                <th>ID</th>
                <th>Título</th>
                <th>Contenido</th>
                <th class="text-center">Audio</th>
                <!-- <th>Audio</th> -->
            </tr>
        </thead>
        <tbody>
            @foreach($instructions as $instruction)
                <tr>
                    <td>{{ $instruction->id }}</td>
                    <td>{{ $instruction->title }}</td>
                    <td>{{ $instruction->content }}</td>
                    <td class="text-center">
                        <audio controls>
                            <source src="{{ asset('storage/' . $instruction->audio_file) }}" type="audio/mpeg">
                            Tu navegador no soporta la reproducción de audio.
                        </audio>
                    </td>
                    <!-- <td>{{ $instruction->audio_file }}</td> -->
                </tr>
            @endforeach
        </tbody>
    </table>
@endif

<hr>

@if($transitions->isEmpty())
  <h4>No hay transiciones asociadas a este escenario.</h4>
@else
  <h2>Transiciones</h2>
  <table class="table table-striped" id="transitions-table">
    <thead>
        <tr>
            <th>Instrucción origen</th>
            <th>Instrucción destino</th>
            <th>Trigger</th>
            <th>Segundos</th>
            <th>Botón</th>
            <th>Bucles</th>
        </tr>
    </thead>
    <tbody>
      @foreach($transitions as $transition)
        <tr>
          <td>{{ $transition->from_instruction_id }}</td>
          <td>{{ $transition->to_instruction_id }}</td>
          <td>{{ $transition->trigger }}</td>
          <td>{{ $transition->time_seconds ?? 'Opcional' }}</td>
          <td>{{ $transition->desa_button_id ?? 'Opcional' }}</td>
          <td>{{ $transition->loop_count ?? 'Opcional' }}</td>
        </tr>
      @endforeach
    </tbody>
  </table>
@endif
<br>

<script>
    // DataTable para Instrucciones
    $(document).ready(function () {
        let tablaInstrucciones = new DataTable('#instructions-table', {
            responsive: true,
            autoWidth: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json',
            }
        });

        let tablaTransiciones = new DataTable('#transitions-table', {
            responsive: true,
            autoWidth: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json',
            }
        })
    });

    // Borrado de Instrucciones
    

    // Borrado
    document.getElementById('form-borrar-escenario').addEventListener('submit', function (event) {
        event.preventDefault();
        // Pregunta confirmación de eliminado de escenario
        Swal.fire({
            text: '¿Estás seguro de que deseas eliminar este escenario?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Sí',
            cancelButtonText: 'No'
        }).then((result) => {
            if (result.isConfirmed) {
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
                            }).then(() => {
                                window.location.href = "{{ route('scenarios.index') }}";
                            })
                        } else {
                            alert('Ocurrió un error al borrar el escenario.');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('Ocurrió un error en la solicitud...');
                    });
            }
        })
    });
</script>
@endsection