<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Creación de </title>
</head>
<body>
@extends('adminlte::page')
@section('title', 'Nueva Transición')
@section('content_header')
    <h1 id="title_form"><strong>Nueva Transición</strong></h1>
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
    <form action="{{ route('transition.save', ['scenario_id' => $escenario_id]) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="from_instruction_id">Instrucción previa:</label>
            <select class="form-control" name="from_instruction_id" id="from_instruction_id" required>
                <option value="" selected disabled>Seleccione una instrucción de origen</option>
                @foreach ($instructions as $instruction)
                    <option value="{{ $instruction->id }}">
                        {{ $instruction->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="to_instruction_id">Instrucción posterior:</label>
            <select class="form-control" name="to_instruction_id" id="to_instruction_id" required>
                <option value="" selected disabled>Seleccione la siguiente instrucción</option>
                @foreach ($instructions as $instruction)
                    <option value="{{ $instruction->id }}">
                        {{ $instruction->title }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group">
            <label for="trigger">Desencadenante:</label>
            <select class="form-control" name="trigger" id="trigger" required onchange="toggleFields()">
                <option value="" selected disabled>Seleccione el desencadenante</option>
                <option value="time">Tiempo</option>
                <option value="desaButton">Botón</option>
                <option value="loop">Bucles</option>
            </select>
        </div>
        <div class="form-group" id="timeSecondsGroup" style="display: none;">
            <label for="time_seconds">Segundos:</label>
            <input type="text" class="form-control" name="time_seconds" id="time_seconds" min="1" maxlength="11">
        </div>
        <div class="form-group" id="desaButtonGroup" style="display: none;">
            <label for="desa_button_id">Button:</label>
            <select class="form-control" name="desa_button_id" id="desa_button_id">
                <option value="" selected disabled>Seleccione un DesaButton</option>
                @foreach ($desaButtons as $desaButton)
                    <option value="{{ $desaButton->id }}">
                        {{ $desaButton->label }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="form-group" id="loopCountGroup" style="display: none;">
            <label for="loop_count">Contador:</label>
            <input type="text" class="form-control" name="loop_count" id="loop_count" min="1" maxlength="10">
        </div>
        <button type="submit" class="btn btn-primary">Guardar transición</button>
    </form>
    <script>
        function toggleFields()
        {
            const triggerSelect = document.getElementById('trigger').value;
            const timeSecondsGroup = document.getElementById('timeSecondsGroup');
            const desaButtonGroup = document.getElementById('desaButtonGroup');
            const loopCountGroup = document.getElementById('loopCountGroup');

            // Oculta todos los campos opcionales para mostrar solo el necesario
            timeSecondsGroup.style.display = 'none';
            desaButtonGroup.style.display = 'none';
            loopCountGroup.style.display = 'none';

            if (triggerSelect === 'time')
            {
                timeSecondsGroup.style.display = 'block';
            }
            else if (triggerSelect === 'desaButton')
            {
                desaButtonGroup.style.display = 'block';
            }
            else if (triggerSelect === 'loop')
            {
                loopCountGroup.style.display = 'block';
            }
        }
    </script>
@endsection
</body>
</html>