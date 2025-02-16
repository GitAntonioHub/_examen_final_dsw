<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nueva instrucción</title>
</head>
<body>
@extends('adminlte::page')
    @section('title', 'Nueva Instrucción')
    @section('content_header')
        <h1 id="title_form"><strong>Nueva Instrucción</strong></h1>
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
        <form action="{{ route('instruction.save', $escenario_id)}}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Título:</label>
                <input type="text" class="form-control" name="title" id="title" required>
            </div>
            <div class="form-group">
                <label for="content">Contenido:</label>
                <textarea class="form-control" name="content" id="content" required></textarea>
            </div>
            <div class="form-group">
                <label for="audio_file">Archivo de audio:</label>
                <input type="file" class="form-control-file" name="audio_file" id="audio_file" accept=".mp3,.wav">
            </div>
            <button type="submit" class="btn btn-primary">Guardar Instrucción</button>
        </form>
    @endsection
</body>
</html>