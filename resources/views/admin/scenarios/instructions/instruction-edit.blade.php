<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>Modificación de {{ $instruction->title }} </title>
</head>
<body>

@extends('adminlte::page')
    @section('title', 'Editar Instrucción')
    @section('content_header')
        <h1 id="title_form"><strong>Editar Instrucción</strong></h1>
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
        <form action="{{ route('instruction.update', ['scenario_id' => $escenario_id, 'instruction_id' => $instruction->id]) }}" method="POST" enctype="multipart/form-data" id="form-editar-instruccion">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" class="form-control" name="title" id="title" value="{{ old('title', $instruction->title) }}" required>
            </div>
            <div class="form-group">
                <label for="content">Contenido:</label>
                <textarea class="form-control" name="content" id="content" required>{{ old('content', $instruction->content) }}</textarea>
            </div>
            <div class="form-group">
                <label for="audio_file">Archivo de audio:</label>
                <input type="text" class="form-control-file mb-3" name="audio_file_directory" id="audio_file_title" value="{{ $instruction->audio_file }}" disabled>
                <input type="file" name="audio_file" id="audio_file">
            </div>
            <button type="submit" class="btn btn-primary">Actualizar instrucción</button>
            <a href="{{ route('scenario.edit', $escenario_id) }}" class="btn btn-secondary ml-2">
                Volver
            </a>
        </form>
    @endsection

    <!-- Añadido Aco -->
    @section('js')
        <script>
            document.getElementById('form-editar-instruccion').addEventListener('submit', function (event) {
                event.preventDefault();
                let form = event.target;
                let formData = new FormData(form);
                let url = form.action;
                fetch(url, {
                    method: 'POST',
                    body: formData,
                })
                .then(response => response.json())
                .then(data => {
                    if(data.success === true) {
                        //SweetAlert2
                        Swal.fire({
                            icon: 'success',
                            text: data.message,
                            shownConfirmButton: true,
                        })
                        .then((result) => {
                            if (result.isConfirmed) {
                                window.location.href = "{{ route('scenario.edit', $escenario_id) }}";
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: 'Hubo un error al actualizar la instrucción.',
                            shownConfirmButton: true,
                        });
                    }
                });
            });
        </script>
    @endsection

</body>
</html>