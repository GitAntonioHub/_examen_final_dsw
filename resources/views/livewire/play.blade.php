@extends('layouts.app')

@section('title', 'Simulación: ' . $scenario->title)

@section('content')
    <livewire:scenario-simulation :scenario="$scenario" />
@endsection