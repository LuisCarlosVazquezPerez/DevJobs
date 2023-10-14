<?php

namespace App\Livewire;

use App\Models\Salario;
use App\Models\Vacante;
use Livewire\Component;
use App\Models\Categoria;
use Illuminate\Support\Carbon;
use Livewire\WithFileUploads;

class EditarVacante extends Component
{
    public $vacante_id;
    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;
    public $imagen_nueva;

    Use WithFileUploads;

    protected $rules = [
        'titulo' => 'required|string',
        'salario' => 'required',
        'categoria' => 'required',
        'empresa' => 'required',
        'ultimo_dia' => 'required',
        'descripcion' => 'required',
        'imagen_nueva' => 'nullable|image|max:1024' //? nullable dice que puede ir vacio pero en caso de ir algo tiene que ser una imagen
    ];


    public function mount(Vacante $vacante) //* $vacante es el que viene de la base de datos
    { //?EN AUTOMATICO SE PASA UNA INSTANCIA
        $this->vacante_id = $vacante->id;
        $this->titulo = $vacante->titulo; //*el ultimo titulo hace referencia al atributo en como se llama en la base de datos. 
        $this->salario = $vacante->salario_id; //*Osea en como viene de la base de datos
        $this->categoria = $vacante->categoria_id;
        $this->empresa = $vacante->empresa;
        $this->ultimo_dia = Carbon::parse($vacante->ultimo_dia)->format('Y-m-d'); //*Para que funcione la fecha
        $this->descripcion = $vacante->descripcion;
        $this->imagen = $vacante->imagen;
    }

    public function editarVacante()
    {
        $datos = $this->validate(); //!SI MODIFICO ESOS CAMBIOS SE VAN A $datos

        //*5 SI HAY UNA NUEVA IMAGEN
        if($this->imagen_nueva){
            $imagen = $this->imagen_nueva->store('public/vacantes');
            $datos['imagen'] = str_replace('public/vacantes/','',$imagen);
        }

        //* 1- ENCONTRAR LA VACANTE A EDITAR
        $vacante = Vacante::find($this->vacante_id);


        //* 2- ASIGNAR LOS VALORES
        $vacante->titulo = $datos['titulo'];
        $vacante->salario_id = $datos['salario'];
        $vacante->categoria_id = $datos['categoria'];
        $vacante->empresa = $datos['empresa'];
        $vacante->ultimo_dia = $datos['ultimo_dia'];
        $vacante->descripcion = $datos['descripcion'];
        $vacante->imagen = $datos['imagen'] ?? $vacante->imagen; //?Hay una nueva imagen? so asignalo '??' si no hay asignale el valor que tenia anteriormente.

        //* 3- GUARDAR LA VACANTE
        $vacante->save();

        //* 4- REDIRECCIONAR
        session()->flash('mensaje','La Vacante se actualizo correctamente');
        return redirect()->route('vacantes.index');
    }

    public function render()
    {
        //HACER LA CONSULTA A LA BD PARA LA VISTA
        $salarios = Salario::all();
        $categorias = Categoria::all();

        return view('livewire.editar-vacante', [
            'salarios' => $salarios,
            'categorias' => $categorias
        ]);
    }
}
