<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Panel de Administrador</title>
</head>
@extends('adminlte::page')

@section('title', 'Admin Dashboard')

@section('content_header')
    <h1 class="fw-bold">Panel de Administrador</h1>
@endsection

@section('content')
    <div class="row">
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1">
                        <i class="fas fa-fw fa-address-book"></i>
                        Usuarios
                    </h5>
                    <p class="card-text">Visualiza y gestiona los usuarios registrados en el sistema.</p>
                    <a href="{{ route('users') }}" class="btn btn-primary link-hover">Ir a Usuarios</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1">
                        <i class="fas fa-fw fa-map-marker-alt"></i>
                        Escenarios
                    </h5>
                    <p class="card-text">Consulta los escenarios registrados en el sistema.</p>
                    <a href="{{ route('scenarios.index') }}" class="btn btn-primary link-hover">Ir a Escenarios</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1">
                        <i class="fas fa-fw fa-notes-medical"></i>
                        DESA
                    </h5>
                    <p class="card-text">Consulta los DESAs registrados en el sistema.</p>
                    <a href="{{ route('desa-trainers.index') }}" class="btn btn-primary link-hover">Ir a DESA</a>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title mb-1">
                        <i class="fas fa-solid fa-play"></i>
                        Simulaciones
                    </h5>
                    <p class="card-text">Consulta las simulaciones actuales en el sistema.</p>
                    <a href="{{ route('playList') }}" class="btn btn-primary link-hover">Ir a Simulaciones</a>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('css')
    <style>
        .link-hover {
            transition: background-color 0.3s, transform 0.3s ease;
        }

        .link-hover:hover {
            background-color: #007bff;
            color: #fff;
            transform: scale(1.1);
        }

        .card {
            margin-bottom: 20px;
        }

        .card-title {
            font-size: 1.25rem;
            font-weight: bold;
        }

        .card-text {
            font-size: 1rem;
            margin-bottom: 15px;
        }
    </style>
@endsection
</html>