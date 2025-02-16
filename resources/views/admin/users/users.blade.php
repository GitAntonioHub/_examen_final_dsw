<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Usuarios</title>
    <!-- Incluir jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Incluir DataTables CSS y JS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
    <!-- Incluir SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 </head>
<body>
  @extends('adminlte::page')
  
  @section('content_header')
    <h1><strong>Usuarios</strong></h1>
  @endsection
  
  @section('content')
    <a href="{{ route('user.create') }}" class="btn btn-primary mb-3">
      <i class="fas fa-light fa-plus mr-1"></i>
      Nuevo usuario
    </a>
    @if($users->isEmpty())
      <p>No hay usuarios registrados.</p>
    @else
      <table class="table table-striped" id="tabla-usuarios">
        <thead>
          <tr>
            <th>Nombre</th>
            <th>Correo</th>
            <th>Rol</th>
            <th>Acciones</th>
          </tr>
        </thead>
        <tbody>
          @foreach($users as $user)
            <tr>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              @if ($user->role === 'Alumno')
                <td class="badge badge-success">Alumno</td>
              @elseif ($user->role === 'Profesor')
                <td class="badge badge-primary">Profesor</td>
              @else
                <td class="badge badge-warning">Administrador</td>
              @endif
              <td class="text-center">
                  <form action="{{ route('user.info', $user->id) }}" method="GET" style="display:inline;">
                    <button type="submit" class="btn btn-primary" title="Información del usuario">
                      <i class="fa fa-eye" aria-hidden="true"></i>
                    </button>
                  </form>
                  <form action="{{ route('user.edit', $user->id) }}" method="GET" style="display:inline;">
                    <button type="submit" class="btn btn-warning" title="Modificar usuario">
                      <i class="fa fa-pen" aria-hidden="true"></i>
                    </button>
                  </form>
                  <form action="{{ route('user.destroy', $user->id) }}" method="POST" onsubmit="confirmDelete(event)" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger" title="Eliminar usuario">
                      <i class="fa fa-trash" aria-hidden="true"></i>
                    </button>
                  </form>
              </td>  
            </tr>
          @endforeach
        </tbody>
      </table>
    @endif
    <br>
  @endsection

  @section('js')
    <script>
      function confirmDelete(event)
      {
        event.preventDefault();
        Swal.fire({
          icon: 'warning',
          text: '¿Estás seguro de eliminar este usuario?',
          showCancelButton: true,
          confirmButtonText: `Sí`,
          cancelButtonText: `No`,
        }).then((result) => {
          if (result.isConfirmed) {
            Swal.fire({
              text: 'El usuario ha sido eliminado.',
              icon: 'success',
              showConfirmButton: false,
              timer: 1500
            }).then(() => {
              event.target.submit();
            })
          }
        });
      }
      setTimeout(function()
      {
          let successMessage = document.getElementById('success-message');
          if(successMessage)
          {
            successMessage.style.display = 'none';
          }
        }, 5000);

        // DataTable
        $(document).ready(function() {
          let tabla = new DataTable('#tabla-usuarios', {
            responsive: true,
            autoWidth: false,
            language: {
                url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json',
            }
          });
        });
    </script>
  @endsection
</body>
</html>