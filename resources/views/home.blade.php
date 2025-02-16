<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link href="vendor/adminlte/dist/css/adminlte.min.css" rel="stylesheet">
  <title>Home</title>
</head>

<body>
    <div class="container card-center d-flex flex-column justify-content-center align-items-center" style="padding-top: 50px;">

      <!-- TRASLADAR A LA VISTA DE SIMULACIÓN -->
      <!-- @if(session()->get('error'))
        <div class="alert alert-danger">
            {{ session()->get('error') }}
        </div>
      @endif -->


      <div class="col-md-8">
          <div class="card shadow-lg rounded-4 p-2" style="background-color: #66bb6a; color: #f5f5f5;">
            <div class="card-body">
              <div class="card-title d-flex justify-content-center align-items-center text-center gap-3 mb-3">
                  <img src="vendor/adminlte/dist/img/desa-heart.png" alt="Logo" style="height: 50px;">
                  <h1 class="m-0">Bienvenido/a al DESA Trainer</h1>
              </div>
              <p class="card-text mt-4" style="color: black;">
                Esta aplicación está diseñada para simular cómo funciona un Desfibrilador Externo Semiautomático (DESA) en diferentes escenarios, permitiendo a los usuarios entender mejor su uso y aplicación en situaciones de emergencia.
              </p>
              <p class="card-text mt-4" style="color: black;">
                A través de una interfaz intuitiva, la app reproduce distintos escenarios de emergencia, proporcionando una experiencia educativa para la correcta utilización del DESA en la reanimación cardiopulmonar (RCP).
              </p>
              <p class="card-text mt-4" style="color: black;">
                Ideal para profesionales de la salud, estudiantes o cualquier persona interesada en aprender sobre primeros auxilios y el uso de estos dispositivos en situaciones críticas.
              </p>

              <!-- Si el usuario ya ha iniciado sesión -->
              @if(auth()->check())
                @if(auth()->user()->role == 'Administrador')
                  <div class="alert alert-info text-center" style="max-width: 600px; margin: 20px auto;">
                      Ya has iniciado sesión como
                      <a href="{{ route('admin.dashboard') }}" class="text-black"><strong>{{ trim(auth()->user()->name) }}</strong></a>
                      <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger m-2">Cerrar Sesión</button>
                      </form>
                  </div>
                @elseif(auth()->user()->role == 'Profesor' || auth()->user()->role == 'Alumno')
                  <div class="alert alert-info text-center" style="max-width: 600px; margin: 20px auto;">
                      Ya has iniciado sesión como
                      <a href="#" class="text-black"><strong>{{ auth()->user()->name }}</strong></a>
                      <form action="{{ route('logout') }}" method="POST" class="d-inline">
                        @csrf
                        <button type="submit" class="btn btn-danger m-2">Cerrar Sesión</button>
                      </form>
                  </div>
                @endif
                <div class="d-flex justify-content-end">

                </div>
              @else
                <div class="card-footer border-0 bg-transparent mt-4 d-flex justify-content-end">
                  <a href="/register" class="btn btn-light text-success m-2">Registrarse</a>
                  <a href="/login" class="btn btn-success text-white m-2">Iniciar Sesión</a>
                </div>
              @endif
            </div>
          </div>
        </div>
    </div>
</body>

</html>