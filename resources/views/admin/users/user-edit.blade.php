<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modificación de Usuario</title>
    <link rel="stylesheet" href="{{ asset('CSS/user-edit.css') }}">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    @extends('adminlte::page')
    @section('title', 'Modificación de Usuario')
    @section('content_header')
        <h1 id="title_form"><strong>Modificación del usuario: {{ $user->name }}</strong></h1>
    @endsection
    @section('content')
        <form id="formulario" action="{{ route('user.update', $user->id) }}" class="w-50">
            @csrf <!-- Token de seguridad -->
            <input type="hidden" name="_method" value="PUT"> <!-- Enviar método manualmente -->
            
            <div class="form-group">
                <label for="name"><h3>Nombre</h3></label>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name', $user->name) }}" placeholder="Nombre completo" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="email"><h3>Correo</h3></label>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email', $user->email) }}" placeholder="Introduce tu correo" required autocomplete="off">
            </div>

            <div class="form-group">
                <label for="role" class="form-label"><h3>Rol</h3></label>
                <select name="role" id="role" class="form-control">
                    <option value="Administrador" {{ isset($user) && $user->role === 'Administrador' ? 'selected' : ''}}>Administrador</option>
                    <option value="Profesor" {{ isset($user) && $user->role === 'Profesor' ? 'selected' : '' }}>Profesor</option>
                    <option value="Alumno" {{ isset($user) && $user->role === 'Alumno' ? 'selected' : '' }}>Alumno</option>
                </select>
            </div>

            <!-- Botón para mostrar/ocultar la sección de contraseña -->
            <p>
                <a class="btn btn-link" onclick="togglePasswordFields(event)">
                    <i class="fa fa-lock"></i> Cambiar contraseña (opcional)
                </a>
            </p>

            <!-- Sección de contraseñas colapsable -->
            <div class="collapse" id="passwordSection" style="display: none;">
                <div class="form-group">
                    <label for="password"><h3>Contraseña:</h3></label>
                    <input type="password" id="password" name="password" class="form-control" placeholder="Introduce una nueva contraseña" autocomplete="off">
                </div>

                <div class="form-group">
                    <label for="password_confirmation"><h3>Confirmar contraseña:</h3></label>
                    <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" autocomplete="off">
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary">
                <i class="far fa-floppy-disk mr-1"></i>
                Guardar cambios
            </button>
            <a href="{{ route('users') }}" class="btn btn-secondary">
                <i class="fas fa-regular fa-arrow-left mr-1"></i>
                Volver
            </a>
        </form>
    @endsection
    @section('js')
        <script>
            // Mostrar ocultar campos contraseñas
            function togglePasswordFields(event) {
                event.preventDefault();
                let passwordSection = document.getElementById("passwordSection");
                if (passwordSection.style.display === "none") {
                    passwordSection.style.display = "block";
                } else {
                    passwordSection.style.display = "none";
                }
            }

            // Modificar usuario
            const formFormularioModificar = document.getElementById('formulario');
            formFormularioModificar.addEventListener('submit', function(event) {
                event.preventDefault();

                // errores
                document.querySelectorAll('.is-invalid').forEach(element => {
                    element.classList.remove('is-invalid');
                });
                document.querySelectorAll('.invalid-feedback').forEach(element => {
                    element.remove();
                });

                // Enviar formulario
                fetch(formFormularioModificar.action, {
                    method: 'POST',
                    body: new FormData(formFormularioModificar),
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                    }
                }).then(response => {
                    if (!response.ok) {
                        return response.json().then(data => {
                            if (response.status === 422) {
                                // Validaciones fallidas
                                throw { 
                                    validationErrors: data.errors 
                                };
                            } else {
                                // Error inesperado
                                throw new Error('Error en la respuesta');
                            }
                        });
                    }
                    return response.json();
                }).then(data => {
                    // Si la respuesta es correcta
                    Swal.fire({
                        icon: 'success',
                        text: 'Se ha modificado el usuario correctamente.',
                        showConfirmButton: true,
                        // timer: 1500
                    }).then(() => {
                        window.location.replace("{{ route('users') }}");
                    });
                }).catch(error => {
                    if (error.validationErrors) {
                        console.log('Errores de validación:', error.validationErrors);
                        console.log(document.getElementById('email').value);
                        Object.keys(error.validationErrors).forEach(field => {
                            let input = document.getElementById(field);
                            if (input) {
                                
                                input.classList.add('is-invalid');

                                let existingError = input.parentNode.querySelector('.invalid-feedback');
                                if (existingError) {
                                    existingError.remove();
                                }

                                let errorDiv = document.createElement('div');
                                errorDiv.classList.add('invalid-feedback');
                                errorDiv.innerText = error.validationErrors[field][0];
                                input.insertAdjacentElement('afterend', errorDiv);

                                // Si el campo es contraseña y está visible, mostrar mensaje de error
                                if (field === 'password' || field === 'password_confirmation') {
                                    let passwordSection = document.getElementById("passwordSection");
                                    passwordSection.style.display = "block"; // Que se muestre si hay error
                                }
                            }
                        });
                    } else {
                        Swal.fire({
                            icon: 'error',
                            text: 'Ha ocurrido un error al modificar el usuario.',
                            showConfirmButton: true,
                        })
                    }
                });
            });
        </script>
    @endsection
</body>
</html>