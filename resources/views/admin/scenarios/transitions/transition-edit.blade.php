<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación de </title>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
@extends('adminlte::page')
@section('title', 'Modificar Transición')
@section('content_header')
    <h1 id="title_form"><strong>Modificar Transición</strong></h1>
@endsection
@section('content')
    @if($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    <form action="{{ route('transition.update', ['scenario_id' => $escenario_id, 'transition_id' => $transition->id]) }}" id="form" method="POST">
        @csrf
        @method('PUT') <!-- Indica que se trata de una actualización -->
        <div class="form-group">
            <label for="from_instruction_id">Instrucción previa:</label>
            <select class="form-control" name="from_instruction_id" id="from_instruction_id" required>
                <option value="" disabled>Seleccione una instrucción previa</option>
                @foreach ($instructions as $instruction)
                    <option 
                        value="{{ $instruction->id }}"
                        {{ old('from_instruction_id', $transition->from_instruction_id) == $instruction->id ? 'selected' : '' }}>
                        {{ $instruction->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="to_instruction_id">Instrucción posterior:</label>
        <select class="form-control" name="to_instruction_id" id="to_instruction_id" required>
            <option value="" disabled>Seleccione una instrucción posterior</option>
            @foreach ($instructions as $instruction)
                <option
                    value="{{ $instruction->id }}"
                    {{ old('to_instruction_id', $transition->to_instruction_id) == $instruction->id ? 'selected' : '' }}>
                    {{ $instruction->title }}
                </option>
            @endforeach
        </select>
        </div>
        <div class="form-group">
            <label for="trigger">Desencadenante:</label>
            <select class="form-control" name="trigger" id="trigger" required onchange="onTriggerChange()">
                <option value="" disabled>Seleccione el desencadenante</option>
                <option value="time" {{ old('trigger', $transition->trigger) === 'time' ? 'selected' : '' }}>Tiempo</option>
                <option value="desaButton" {{ old('trigger', $transition->trigger) === 'desaButton' ? 'selected' : '' }}>Botón</option>
                <option value="loop" {{ old('trigger', $transition->trigger) === 'loop' ? 'selected' : '' }}>Bucles</option>
            </select>
        </div>
        <div class="form-group" id="timeSecondsGroup" style="display: none;">
            <label for="time_seconds">Segundos:</label>
            <input type="text" class="form-control" name="time_seconds" id="time_seconds" value="{{ old('time_seconds', $transition->time_seconds) }}" min="1" maxlength="10">
        </div>
        <div class="form-group" id="desaButtonGroup" style="display: none;">
            <label for="desa_button_id">Button:</label>
            <select class="form-control" name="desa_button_id" id="desa_button_id">
                <option value="" disabled>Seleccione un DesaButton</option>
                @foreach ($desaButtons as $desaButton)
                    <option value="{{ $desaButton->id }}"
                        {{-- Mostrar como seleccionado si coincide con el valor en BD (o si viene de old) --}}
                        {{ old('desa_button_id', $transition->desa_button_id) == $desaButton->id ? 'selected' : '' }}>
                        {{ $desaButton->label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group" id="loopCountGroup" style="display: none;">
            <label for="loop_count">Contador:</label>
            <input type="text" class="form-control" name="loop_count" id="loop_count" value="{{ old('loop_count', $transition->loop_count) }}" min="1" maxlength="10">
        </div>
        <button type="submit" id="sweetAlert" class="btn btn-primary">Guardar transición</button>
        <a href="{{ route('scenario.edit', $escenario_id) }}" class="btn btn-secondary ml-2">
            Volver
        </a>
    </form>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Obtener el valor actual del trigger desde la base de datos o 'old'
            const triggerValue = '{{ old("trigger", $transition->trigger) }}';
            toggleFields(triggerValue);
        });

        function toggleFields(triggerValue) {
            const timeSecondsGroup = document.getElementById('timeSecondsGroup');
            const desaButtonGroup  = document.getElementById('desaButtonGroup');
            const loopCountGroup  = document.getElementById('loopCountGroup');

            timeSecondsGroup.style.display = 'none';
            desaButtonGroup.style.display  = 'none';
            loopCountGroup.style.display   = 'none';

            if (triggerValue === 'time') {
                timeSecondsGroup.style.display = 'block';
            } else if (triggerValue === 'desaButton') {
                desaButtonGroup.style.display = 'block';
            } else if (triggerValue === 'loop') {
                loopCountGroup.style.display = 'block';
            }
        }

        // Llamar a toggleFields en el evento onchange del select
        function onTriggerChange() {
            const triggerSelect = document.getElementById('trigger');
            toggleFields(triggerSelect.value);
        }

        // SweetAlert y administración del Json
        document.getElementById('form').addEventListener('submit', function(e)
        {
            e.preventDefault(); // Evita el submit normal
            
            console.log("Enviando datos...");
            const formData = Object.fromEntries(new FormData(e.target).entries());
            const url = "{{ route('transition.update', ['scenario_id' => $escenario_id, 'transition_id' => $transition->id]) }}";
            
            fetch(url, {
                method: 'PUT',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(formData) // Enviar el cuerpo de la solicitud
            })
            .then(response => response.json())
            .then(data => {
                if (data.success)
                {
                    console.log("Transición actualizada correctamente");

                    Swal.fire({
                        text: 'La transición ha sido actualizado correctamente.',
                        icon: 'success',
                        confirmButtonText: 'Aceptar'
                    }).then(() => {
                        window.location.href="{{ route('scenario.edit', $escenario_id) }}";
                    });
                }
                else
                {
                    console.log("Ocurrió un error al actualizar la transición.");

                    Swal.fire({
                        text: 'Ocurrió un error al actualizar la transición.',
                        icon: 'error',
                        confirmButtonText: 'Aceptar'
                    });
                }
            })
            .catch(error => {
                console.error('Error:', error);
                Swal.fire({
                    text: 'Ocurrió un error inesperado...',
                    icon: 'error',
                    confirmButtonText: 'Aceptar'
                });
            });
        });
    </script>
@endsection
</body>
</html>