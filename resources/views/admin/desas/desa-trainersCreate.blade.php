@extends('adminlte::page')

@section('title', 'Crear DESA Trainer')

@section('content')
<div class="container">
    <h1>Crear nuevo DESA Trainer</h1>
    <form action="{{ route('desa-trainers.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        
        {{-- Campo: name --}}
        <div class="form-group">
            <label for="name">Nombre:</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        {{-- Campo: model --}}
        <div class="form-group">
            <label for="model">Modelo:</label>
            <input type="text" name="model" id="model" class="form-control">
        </div>

        {{-- Campo: description --}}
        <div class="form-group">
            <label for="description">Descripción:</label>
            <textarea name="description" id="description" class="form-control"></textarea>
        </div>

        {{-- Campo: image (en este caso como texto) --}}
        <div class="form-group">
            <label for="image">Imagen (ruta/URL):</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        {{-- Campo: settings (JSON) --}}
        {{-- <div class="form-group">
            <label for="settings">Ajustes (JSON):</label>
            <textarea name="settings" id="settings" class="form-control" required></textarea>
        </div> --}}

        <button type="submit" class="btn btn-primary">Guardar</button>
    </form>
</div>

<script>
    // Seleccionar formulario
    const form = document.querySelector('form');
    // Agregar evento al formulario
    form.addEventListener('submit', function(event) {
        event.preventDefault();
    });
</script>

@endsection

