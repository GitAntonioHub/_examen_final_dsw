@extends('adminlte::page')

@section('title', 'Listado de DESA Trainers')

@section('content_header')
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
@endsection

@section('content')
    <div class="container">
        <h1>DESA</h1>
        <a href="{{ route('desa-trainers.create') }}" class="btn btn-primary mb-3">Crear nuevo DESA</a>
        <table class="table mt-4" id="tabla-desatrainer">
            <thead>
                <tr class="text-center">
                    <th>Descripción</th>
                    <th>Imagen</th>
                    <th>Nombre</th>
                    <th>Descripción</th>
                    <th>Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($trainers as $trainer)
                    <tr class="text-center">
                        <td></td>
                        {{-- Si 'image' es una ruta o URL, puedes ajustarlo así --}}
                        <td>
                            @if($trainer->image)
                                <img src="{{ asset('storage/' . $trainer->image) }}" alt="Miniatura" width="50">
                            @else
                                Sin imagen
                            @endif
                        </td>
                        <td>{{ $trainer->name }}</td>
                        <td>
                            {{ $trainer->description }}
                        </td>
                        <td>
                            <a href="{{ route('desa-trainers.edit', $trainer) }}" class="btn btn-warning">
                                <i class="fa fa-pen" aria-hidden="true"></i>
                            </a>
                            <a href="{{ route('desa-trainers.show', $trainer->id) }}" class="btn btn-info">
                                <i class="fas fa-cogs"></i>
                            </a>
                            <form action="{{ route('desa-trainers.destroy', $trainer) }}" method="POST" style="display:inline;"
                                onsubmit="return confirm('¿Estás seguro de eliminar este DESA Trainer?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">
                                    <i class="fa fa-trash" aria-hidden="true"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function () {
            let tabla = new DataTable('#tabla-desatrainer', {
                responsive: true,
                autoWidth: false,
                language: {
                    url: 'https://cdn.datatables.net/plug-ins/1.10.21/i18n/Spanish.json',
                },
                columnDefs: [
                    {
                        targets: [3], // Columna de descripción
                        visible: false
                    },
                    {
                        targets: [0],
                        className: 'dt-control',
                        defaultContent: '<i class="fa fa-plus-circle" style="cursor:pointer;"></i>'
                    },
                    {
                        targets: [0, 4],
                        orderable: false
                    },
                ],
                order: [],
            });

            $('#tabla-desatrainer tbody').on('click', 'td.dt-control', function () {
                let tr = $(this).closest('tr');
                let row = tabla.row(tr);

                if (row.child.isShown()) {
                    // Oculta la fila
                    row.child.hide();
                } else {
                    // Muestra la descripción
                    row.child('<div style="padding: 10px;">' + row.data()[3] + '</div>').show();
                }
            });
        });
    </script>

    <style>
        tbody tr:hover {
            background-color: #dfdfdf;
        }
    </style>
@endsection