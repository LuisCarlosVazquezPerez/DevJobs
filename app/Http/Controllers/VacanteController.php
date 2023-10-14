<?php

namespace App\Http\Controllers;

use App\Models\Vacante;
use Illuminate\Http\Request;

class VacanteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $this->authorize('viewAny', Vacante::class);
        return view('vacantes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $this->authorize('create', Vacante::class);
        return view('vacantes.create');
    }



    public function show(Vacante $vacante)
    {
        return view('vacantes.show', [
            'vacante' => $vacante
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vacante $vacante) //OBTENIENDO TODO EL REGISTRO COMPLETO DE LA BD
    {

        $this->authorize('update', $vacante); //?Esto viene de VacantePolicy

        return view('vacantes.edit', [
            'vacante' => $vacante
        ]);
    }
}
