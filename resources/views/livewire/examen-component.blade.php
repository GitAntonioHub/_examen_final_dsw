@extends('layouts.app')

@section('Simulación: ' . $scenario)

@section('content')
    <livewire:scenario-simulation :scenario="$scenario" />
    <div>
        <h1>{{ $scenario }}</h1>
        <button wire:click="previousScenario">Anterior</button>
        <button wire:click="nextScenario">Siguiente</button>
    </div>
@endsection