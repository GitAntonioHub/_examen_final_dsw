<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <title>Nuevo Usuario</title>
</head>
<body>
    @extends('adminlte::page')
    @section('title', 'Nuevo Usuario')

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
        <div class="d-flex flex-column justify-content-center align-items-center">
            <h1 id="title_form" class="mt-2"><strong>Nuevo usuario</strong></h1>

            <form id="formulario" action="{{ route('user.save') }}" method="POST" class="w-50">
                @csrf <!-- Token de seguridad -->
                <div class="form-group">
                    <label for="name" class="form-label">Nombre</label>
                    <input type="text" id="name" name="name" class="form-control" placeholder="Nombre completo" required>
                </div>
                <div class="form-group">
                    <label for="email" class="form-label">Correo</label>
                    <input type="email" id="email" name="email" class="form-control" placeholder="Introduce tu correo" required>
                </div>
                <div class="form-group">
                    <label for="role" class="form-label">Rol</label>
                    <select name="role" id="role" class="form-control">
                        <option value="Administrador">Administrador</option>
                        <option value="Profesor">Profesor</option>
                        <option value="Alumno">Alumno</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Contraseña</label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Introduce una contraseña" required>
                </div>
                <div class="form-group">
                    <label for="password_confirmation" class="form-label">Confirmar Contraseña</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" required>
                </div>
                <div class="d-flex justify-content-between gap-3">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="far fa-floppy-disk mr-1"></i>
                        Añadir
                    </button>
                    <a href="{{ route('users') }}" class="btn btn-secondary">
                        <i class="fas fa-regular fa-arrow-left mr-1"></i>
                        Volver
                    </a>
                </div>
            </form>
        </div>
        
    @endsection

    @section('js')
        <script>
            // Agregar un nuevo usuario
            const formNuevoUsuario = document.getElementById("formulario");
            formNuevoUsuario.addEventListener("submit", function(event) {
                event.preventDefault();

                // Resetear mensajes de error
                document.querySelectorAll('.is-invalid').forEach(element => {
                    element.classList.remove('is-invalid');
                });
                document.querySelectorAll('.invalid-feedback').forEach(element => {
                    element.remove();
                });

                fetch(formNuevoUsuario.action, {
                    method: formNuevoUsuario.method,
                    body: new FormData(formNuevoUsuario),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                }).then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            if (response.status === 422) {
                                throw { validationErrors: data.errors };
                            } else {
                                throw new Error("Error en la respuesta");
                            }
                        });
                    }
                    return response.json();
                }).then(data => {
                    Swal.fire({
                        icon: 'success',
                        text: 'El usuario ha sido creado.',
                        showConfirmButton: false,
                        timer: 1500
                    }).then(() => {
                        window.location.href = "{{ route('users') }}";
                    });
                }).catch(error => {
                    if (error.validationErrors) {
                        console.log(error.validationErrors);
                        Object.keys(error.validationErrors).forEach(field => {
                            let input = document.getElementById(field);
                            if (input) {
                                input.classList.add('is-invalid');
                                let errorDiv = document.createElement('div');
                                errorDiv.classList.add('invalid-feedback');
                                errorDiv.innerText = error.validationErrors[field][0];
                                input.parentNode.appendChild(errorDiv);
                            }
                        });
                    } else {
                        console.error('Error:', error);
                        Swal.fire({
                            icon: 'error',
                            text: 'Ocurrió un error inesperado.',
                        });
                    }
                });
            });
        </script>
    @endsection
</body>
</html>