@extends('adminlte::page')

@section('title', 'Crear escenario')

@section('content_header')
<!-- Añadir SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endsection

@section('content')
<h1>Crear escenario</h1>

<form method="POST" id="form-crear-escenario">
    @csrf
    <!-- Título -->
    <label for="title" class="form-label">Título</label>
    <input type="text" name="title" id="title" placeholder="Nombre del escenario" class="form-control mb-2"
        maxlength="255" required>
    <div class="invalid-feedback"></div>
    <input class="form-check-input" type="checkbox" id="is_simulable" wire:model.live="is_simulable">
    <label class="form-check-label small" for="is_simulable">
    <i class="fas fa-lightbulb me-1 mr-1"></i>Es Simulable
    </label>
    <!-- Descripción -->
    <label for="descripcion-escenario" class="form-label">Descripción</label>
    <textarea name="descripcion-escenario" id="descripcion-escenario" class="form-control mb-2"
        placeholder="Describe el escenario" maxlength="2000" style="resize: none;"></textarea>
    <div class="invalid-feedback"></div>

    <div class="invalid-feedback"></div>
    <!-- DESA Trainer -->
    <label for="desa-trainers-escenario">DESA Trainer</label>
    <select name="desa-trainers-escenario" id="desa-trainers-escenario" class="form-control mb-2">
        <option value="" selected disabled>Selecciona un DESA Trainer</option>
        @foreach ($desa_trainers as $desa_trainerAux)
            <option value="{{ $desa_trainerAux->id }}">
                {{ $desa_trainerAux->name }}
            </option>
        @endforeach
    </select>
    <div class="invalid-feedback"></div>
    <!-- Botones -->
    <div class="d-flex flex-row">
        <button type="submit" class="btn btn-primary mr-2">
            <i class="fas fa-light fa-plus mr-1"></i>
            Agregar escenario
        </button>
        <a href="{{ route('scenarios.index') }}" class="btn btn-secondary">
            Volver
        </a>
    </div>
</form>

<script>
    const form = document.getElementById('form-crear-escenario');
    form.addEventListener('submit', function (event) {
        event.preventDefault();
        const formData = new FormData(form);

        // Limpiar clases previas y mensajes antes de enviar
        const inputs = form.querySelectorAll('.form-control');
        inputs.forEach(input => {
            input.classList.remove('is-invalid');
            const errorContainer = input.nextElementSibling; // div mensaje
            if (errorContainer && errorContainer.classList.contains('invalid-feedback')) {
                errorContainer.innerHTML = '';
            }
        });

        // Fetch de creación de escenario
        fetch("{{ route('scenarios.store') }}", {
            method: 'POST',
            body: formData
        })
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    Swal.fire({
                        text: 'El escenario se ha creado correctamente',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href = "{{ route('scenarios.index') }}";
                    });
                } else {
                    let errorMessages = '';
                    if (data.errors) {
                        // Para la alerta
                        for (let field in data.errors) {
                            // Mensaje de error (SweetAlert)
                            errorMessages += `<p>
                                ${data.errors[field].join('<br>')}
                            <p>`;
                            
                            // Añadir la clase is-invalid + mensaje error
                            const input = document.querySelector(`#${field}`);
                            
                            // Si existe un input erróneo, colocar la clase
                            if (input) {
                                input.classList.add('is-invalid');
                            }

                            // Si el campo erróneo es un SELECT
                            if (input && input.tagName === 'SELECT') {
                                const errorContainer = input.nextElementSibling;
                                if (errorContaienr && errorContainer.classList.contains('invalid-feedback')) {
                                    const icon = '<i class="fas fa-exclamation-circle"></i>';
                                    errorContainer.innerHTML = `${icon} ${data.errors[field].join('<br>')}`; // Mostrar los mensajes
                                }
                            } else {
                                // demas campos
                                const errorContainer = input ? input.nextElementSibling : null;
                                if (errorContainer) {
                                    const icon = '<i class="bi bi-exclamation-circle text-danger"></i>'; // Icono de error
                                    errorContainer.innerHTML = `${icon} ${data.errors[field].join('<br>')}`; // Mostrar los mensajes
                                }
                            }
                        }
                    }
                    // Alerta error
                    Swal.fire({
                        title: 'Error',
                        icon: 'error',
                        html: errorMessages,
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            // En caso de que el fetch falle
            .catch(error => {
                console.error('Error:', error);
            });
    });
</script>
@endsection