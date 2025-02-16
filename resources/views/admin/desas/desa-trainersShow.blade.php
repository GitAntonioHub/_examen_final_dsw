@extends('adminlte::page')

@section('title', 'Detalles del DESA Trainer')

@section('content')
<div class="container">
    <h1>{{ $desaTrainer->name }}</h1>
    <img src="{{ asset('storage/' . $image->image_path) }}" class="img-thumbnail" width="200">
    <p>{{ $desaTrainer->description }}</p>
    <a href="{{ route('desa-trainers.edit', $desaTrainer) }}" class="btn btn-warning">Editar</a>
    <a href="{{ route('desa-trainers.index') }}" class="btn btn-secondary">Volver al listado</a>
</div>
@endsection