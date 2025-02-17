<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Gate;

class ExamenController extends Controller
{
    public function show($scenario)
    {
        return view('livewire.examen-component', ['scenario' => $scenario]);
    }
}
