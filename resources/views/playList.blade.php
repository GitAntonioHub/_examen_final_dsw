@extends('adminlte::page')

@section('title', 'Listado de Escenarios')

@section('content_header')
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.5/css/dataTables.bootstrap4.min.css">
    <script src="https://cdn.datatables.net/1.11.5/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.5/js/dataTables.bootstrap4.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
    <script src="https://cdn.datatables.net/responsive/2.2.9/js/responsive.bootstrap4.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
@endsection

<style>

    body
    {
        background-color: #f4f6f9;
    }
    .card {
        transition: transform 0.5s ease, box-shadow 0.5s ease;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        height: 100%;
    }
    .card-body {
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .card:hover {
        transform: scale(1.05);
        box-shadow: 0 8px 16px rgba(0, 0, 0, 0.2);
    }
    .card-container {
        margin-bottom: 10px;
    }
</style>

@section('content')
<div class="container">
    <h1>PlayList de Escenarios</h1>
    <div class="row">
        @foreach ($scenarios as $scenario)
            <div class="col-md-4 d-flex align-items-stretch card-container">
                <div class="card mb-4">
                    <div class="card-body">
                        <h5 class="card-title">ID: {{ $scenario->id }}</h5>
                        <h5 class="card-title">Title: {{ $scenario->title }}</h5>
                        <a href="{{ route('scenarios.play', ['scenario_id => $scenario->id', 'id_desa => $scenario->desaTrainer_id']) }}" class="btn btn-success mt-auto">
                            <i class="fas fa-play text-white"></i>
                        </a>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection