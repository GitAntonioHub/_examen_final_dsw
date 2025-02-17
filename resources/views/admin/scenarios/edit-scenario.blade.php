@extends('adminlte::page')

@section('title', 'Modificar escenario')

@section('content_header')
    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluir DataTables CSS y JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
  <h1>Modificar escenario: {{ $escenario->title}}</h1>
  <!-- Formulario -->
  <form method="POST" id="form-modificar-escenario">
      @csrf
      @method('PUT')
      <label for="title" class="form-label">Título</label>
      <input type="text" name="title" id="title" placeholder="Nombre del escenario" class="form-control mb-2" maxlength="255" value="{{ $escenario->title }}" required>
      <input class="form-check-input" type="checkbox" id="is_simulable" wire:model.live="is_simulable">
    <label class="form-check-label small" for="is_simulable">
    <i class="fas fa-lightbulb me-1 mr-1"></i>Es Simulable
    </label>
    <p>
      
      <label for="descripcion-escenario" class="form-label">Descripción</label>
      <textarea name="descripcion-escenario" id="descripcion-escenario" class="form-control mb-2" placeholder="Describe el escenario" maxlength="2000" style="resize: none;">{{ $escenario->description }}</textarea>
      <label for="desa-trainers-escenario">DESA Trainer</label>
      <select name="desa-trainers-escenario" id="desa-trainers-escenario" class="form-control mb-2">
          <option value="" selected disabled>Selecciona un DESA Trainer</option>
          @foreach ($desa_trainers as $desa_trainerAux)
              <option value="{{ $desa_trainerAux->id }}"
              {{ isset($escenario) && $escenario->desa_trainer_id == $desa_trainerAux->id ? 'selected' : '' }}>
                  {{ $desa_trainerAux->name }}
              </option>
          @endforeach
      </select>
      <button type="submit" class="btn btn-primary" style="display: block;">
          Actualizar escenario
      </button>
  </form>
  <br>
  <div class="d-flex align-items-end gap-2">
    <form method="POST" id="form-borrar-escenario" style="margin-right: 10px;">
        @csrf
        @method('delete')
        <button type="submit" class="btn btn-danger">
            Borrar escenario
        </button>
    </form>
    <a href="{{ route('scenarios.index') }}" class="btn btn-secondary">
      Volver
    </a>
  </div>
  <hr>
  
  <!-- Instrucciones -->
  <a href="{{ route('instruction.create', $escenario->id) }}" class="btn btn-primary mb-3">
    Crear nueva instrucción
  </a>
  @if($instructions->isEmpty())
    <h4>No hay instrucciones asociadas a este escenario.</h4>
  @else
    <h2>Instrucciones</h2>
    <table class="table table-striped" id="instructions-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Título</th>
          <th>Contenido</th>
          <th style="text-align:center; margin:10px;">Audio</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($instructions as $instruction)
          <tr>
            <td>{{ $instruction->id }}</td>
            <td>{{ $instruction->title }}</td>
            <td>{{ $instruction->content }}</td>
            <td style="text-align:center; margin:10px;">
              <audio controls>
                <source src="{{ asset('storage/' . $instruction->audio_file) }}" type="audio/mp4">
                Tu navegador no soporta la reproducción de audio.
              </audio>
            </td>
            <td>
              <form action="{{ route('instruction.edit', ['scenario_id' => $escenario->id, 'instruction_id' => $instruction->id]) }}" method="GET" style="display:inline;">
                <button type="submit" class="btn btn-warning">
                <i class="fa fa-pen" aria-hidden="true"></i>
                </button>
              </form>
              <form action="{{ route('instruction.destroy', ['scenario_id' => $escenario->id, 'instruction_id' => $instruction->id]) }}" method="POST" onsubmit="confirmDelete(event)" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-danger">
                <i class="fa fa-trash" aria-hidden="true"></i>
                </button>
              </form>
            </td>
          </tr>
        @endforeach
      </tbody>
    </table>
  @endif
  <hr>
  <a href="{{ route('transition.create', ['scenario_id' => $escenario->id]) }}" class="btn btn-primary mb-3">
    Crear nueva transición
  </a>
  @if($transitions->isEmpty())
    <h4>No hay transiciones asociadas a este escenario.</h4>
  @else
    <h2>Transiciones</h2>
    <table class="table table-striped" id="transitions-table">
      <thead>
        <tr>
          <th>Instrucción origen</th>
          <th>Instrucción destino</th>
          <th>Condición</th>
          <th>Desencadenante</th>
          <th>Acciones</th>
        </tr>
      </thead>
      <tbody>
        @foreach($transitions as $transition)
            <tr>
              <td>{{ $transition->from_instruction_id }}</td>
              <td>{{ $transition->to_instruction_id }}</td>
              <td>
                @if($transition->time_seconds)
                    <i class="fa fa-stopwatch text-primary" aria-hidden="true" title="Segundos" style="font-size: 35px;"></i>
                @endif
                @if($transition->desa_button_id)
                    <i class="fas fa-toggle-on text-success" aria-hidden="true" title="Botón" style="font-size: 35px;"></i>
                @endif
                @if($transition->loop_count)
                    <i class="fa fa-sync text-warning" aria-hidden="true" title="Bucle" style="font-size: 35px;"></i>
                @endif
              </td>
              <td>
                @if($transition->time_seconds)
                  {{ $transition->time_seconds }} seg{{ $transition->time_seconds > 1 ? 'undos' : 'undo' }}<br>
                @endif
                @if($transition->desa_button_id)
                  ID: {{ $transition->desa_button_id }}<br>
                @endif
                @if($transition->loop_count)
                  {{ $transition->loop_count }} loop{{ $transition->loop_count > 1 ? 's' : '' }}<br>
                @endif
              </td>
              <td>
                <form action="{{ route('transition.edit', ['scenario_id' => $escenario->id, 'transition_id' => $transition->id]) }}" method="GET" style="display:inline;">
                  <button type="submit" class="btn btn-warning">
                    <i class="fa fa-pen" aria-hidden="true"></i>
                  </button>
                </form>
                <form action="{{ route('transition.destroy', ['scenario_id' => $escenario->id, 'transition_id' => $transition->id]) }}" method="POST" onsubmit="confirmDelete(event)" style="display:inline;">
                  @csrf
                  @method('DELETE')
                  <button type="submit" class="btn btn-danger">
                    <i class="fa fa-trash" aria-hidden="true"></i>
                  </button>
                </form>
              </td>
            </tr>
        @endforeach
      </tbody>
    </table>
    @endif
@endsection
@section('js')
  <script>
      $(document).ready(function() {
      // DataTable de instrucciones
        let tablaInstrucciones = new DataTable('#instructions-table', {
          responsive: true,
          autoWidth: false,
          language: {
            url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json',
          }
        });

        // DataTable de transiciones
        let tablaTransiciones = new DataTable('#transitions-table', {
          responsive: true,
          autoWidth: false,
          language: {
            url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json',
          }
        });
      });

      function confirmDelete(event)
      {
        event.preventDefault();
        Swal.fire({
          text: '¿Estás seguro de eliminar esta transición?',
          showCancelButton: true,
          confirmButtonText: `Sí`,
          cancelButtonText: `No`,
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              text: 'La transición ha sido eliminada.',
              icon: 'success',
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              event.target.submit();
            })
          }
        });
      }
      setTimeout(function()
      {
        let successMessage = document.getElementById('success-message');
        if(successMessage)
        {
          successMessage.style.display = 'none';
        }
      }, 5000);

      const formBorrar = document.getElementById('form-borrar-escenario');
      formBorrar.addEventListener('submit', function(event) {
          event.preventDefault();

          // Pregunta confirmación de eliminado de escenario
          Swal.fire({
              text: '¿Estás seguro de que deseas eliminar este escenario?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sí',
              cancelButtonText: 'Cancelar'
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
                              title: 'Eliminado',
                              text: data.message,
                              icon: 'success',
                              confirmButtonColor: '#3085d6',
                          }).then(() => {
                              window.location.href = "{{ route('scenarios.index') }}";
                          });
                      } else {
                          Swal.fire({
                              title: 'Error',
                              text: 'Ocurrió un error al borrar el escenario.',
                              icon: 'error',
                              confirmButtonColor: '#d33'
                          });
                      }
                  })
                  .catch(error => {
                      console.error('Error:', error);
                      Swal.fire({
                          title: 'Error',
                          text: 'Ocurrió un error en la solicitud...',
                          icon: 'error',
                          confirmButtonColor: '#d33'
                      });
                  });
              }
          });
      });
      const formModificar = document.getElementById('form-modificar-escenario');
      formModificar.addEventListener('submit', function(event) {
          event.preventDefault();

          // Confirmar modificación
          Swal.fire({
              text: '¿Estás seguro de que deseas modificar este escenario?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Sí',
              cancelButtonText: 'No'
          }).then((result) => {
              if (result.isConfirmed) {
                  const formData = new FormData(formModificar);
                  const url = "{{ route('scenarios.update', $escenario->id) }}";
                  fetch(url, {
                      method: 'POST',
                      body: formData
                  })
                  .then(response => response.json())
                  .then(data => {
                      if (data.success) {
                          Swal.fire({
                              text: data.message,
                              icon: 'success',
                              confirmButtonText: 'Aceptar'
                          }).then(() => {
                              window.location.href = "{{ route('scenarios.index') }}";
                          });
                      } else {
                          Swal.fire({
                              text: 'Ocurrió un error al modificar el escenario',
                              icon: 'error',
                              confirmButtonText: 'Aceptar'
                          });
                      }
                  })
                  .catch(error => {
                      console.error('Error:', error);
                  });
              }
          });
      });
    </script>
@endsection