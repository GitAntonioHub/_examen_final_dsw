<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <title>User Info</title>
    <link rel="stylesheet" href="{{ asset('CSS/Users/users.css') }}">
</head>

<body>
    @extends('adminlte::page')
    @section('title', 'Usuario {{ $user->id }}')

    @section('content_header')
    <h1><strong>Usuario {{ $user->id }}</strong></h1>
    @endsection

    @section('content')
    <div class="d-flex flex-column justify-content-center align-items-center">
        <div class="card shadow-sm border-0" style="width: 24rem;">
            <div class="card-header bg-primary text-white">
                <h5 class="mb-0"><i class="fa fa-user-circle"></i> Información del Usuario</h5>
            </div>
            <div class="card-body">
                <p><i class="fa fa-id-badge"></i> <strong>ID:</strong> {{ $user->id }}</p>
                <p><i class="fa fa-user"></i> <strong>Nombre:</strong> {{ $user->name }}</p>
                <p><i class="fa fa-envelope"></i> <strong>Correo:</strong>{{ $user->email }}</p>
                <p><i class="fa fa-user-circle"></i> <strong>Rol:</strong>{{ $user->role }}</p>
            </div>
            <div style="display: flex; flex-direction: row; gap: 5px;" class="card-footer justify-content-end">
                <form action="{{ route('user.edit', $user->id) }}" method="GET">
                    <button type="submit" class="btn btn-warning">Editar</button>
                </form>
                <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="confirmDelete(event)">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">Eliminar</button>
                </form>
            </div>
        </div>
        <div>
            <a href="{{ route('users') }}" class="btn btn-secondary">
                <i class="fas fa-regular fa-arrow-left mr-1"></i>
                Volver
            </a>
        </div>
    </div>
    @endsection

    @section('js')
    <script>
        function confirmDelete(event) {
            event.preventDefault();
            Swal.fire({
                icon: 'warning',
                text: '¿Estás seguro de eliminar este usuario?',
                showCancelButton: true,
                confirmButtonText: `Sí`,
                cancelButtonText: `No`,
            })
                .then((result) => {
                    if (result.isConfirmed) {
                        Swal.fire({
                            text: 'El usuario ha sido eliminado.',
                            icon: 'success',
                            showConfirmButton: false,
                            timer: 1500
                        })
                            .then(() => {
                                event.target.submit();
                            })
                    }
                });
        }
    </script>
    @endsection
</body>

</html>