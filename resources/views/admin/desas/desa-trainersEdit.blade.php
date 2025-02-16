@extends('adminlte::page')

@section('title', 'Editar DESA')

@section('content_header')
<h1 id="title_form"><strong>Editar DESA</strong></h1>
@endsection

@section('content')
<div class="row">
    <div class="col-12">
        <div class="card">
            <form action="{{ route('desa-trainers.update', $desaTrainer->id) }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="card-header">
                    <h3 class="card-title">Información del DESA Trainer</h3>
                </div>

                <div class="card-body">
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif

                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="name">Nombre</label>
                                <input type="text" class="form-control @error('name') is-invalid @enderror" id="name"
                                    name="name" value="{{ old('name', $desaTrainer->name) }}" required>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="model">Modelo</label>
                                <input type="text" class="form-control @error('model') is-invalid @enderror" id="model"
                                    name="model" value="{{ old('model', $desaTrainer->model) }}" required>
                                @error('model')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="form-group">
                                <label for="description">Descripción</label>
                                <textarea class="form-control @error('description') is-invalid @enderror"
                                    id="description" name="description"
                                    rows="4" style="resize: none;">{{ old('description', $desaTrainer->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="image">Imagen del DESA</label>
                                @if($desaTrainer->image)
                                    <div class="current-image mb-3">
                                        <label>Imagen Actual:</label>
                                        <img src="{{ asset('storage/' . $desaTrainer->image) }}" alt="Imagen actual"
                                            class="img-fluid img-thumbnail" style="max-height: 200px;">
                                    </div>
                                @endif
                                <div class="custom-file">
                                    <input type="file" class="custom-file-input @error('image') is-invalid @enderror"
                                        id="image" name="image" accept="image/*">
                                    <label class="custom-file-label" for="image">
                                        {{ $desaTrainer->image ? 'Cambiar imagen' : 'Seleccionar imagen' }}
                                    </label>
                                </div>
                                @error('image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="form-text text-muted">
                                    Dejar vacío para mantener la imagen actual. La nueva imagen reemplazará a la
                                    anterior.
                                </small>
                            </div>

                            <div class="image-preview mt-3" style="display: none;">
                                <p class="font-weight-bold">Vista previa de la nueva imagen:</p>
                                <img id="preview" src="#" alt="Vista previa" class="img-fluid">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="card-footer">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Guardar Cambios
                    </button>
                    <a href="{{ route('desa-trainers.index') }}" class="btn btn-secondary">
                        <i class="fas fa-times"></i> Cancelar
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function () {
        // Mostrar nombre del archivo seleccionado y preview
        $('.custom-file-input').on('change', function () {
            let fileName = $(this).val().split('\\').pop();
            if (fileName) {
                $(this).next('.custom-file-label').addClass("selected").html(fileName);
            } else {
                $(this).next('.custom-file-label').removeClass("selected").html("Seleccionar imagen");
            }

            // Mostrar vista previa de la nueva imagen
            if (this.files && this.files[0]) {
                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#preview').attr('src', e.target.result);
                    $('.image-preview').show();
                }
                reader.readAsDataURL(this.files[0]);
            } else {
                $('.image-preview').hide();
            }
        });
    });
</script>
@stop