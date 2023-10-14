<?php

namespace App\Livewire;

use App\Models\Salario;
use Livewire\Component;
use App\Models\Categoria;
use App\Models\Vacante;
use Livewire\WithFileUploads;

class CrearVacante extends Component
{
    public $titulo;
    public $salario;
    public $categoria;
    public $empresa;
    public $ultimo_dia;
    public $descripcion;
    public $imagen;

    use WithFileUploads;

    protected $rules = [
        'titulo' => 'required|string',
        'salario' => 'required',
        'categoria' => 'required',
        'empresa' => 'required',
        'ultimo_dia' => 'required',
        'descripcion' => 'required',
        'imagen' => 'required|image|max:1024',

    ];

    public function crearVacante() //!ANTERIORMENTE LO HACIAMOS EN EL CONTROLLADOR, AHORA LA HACEMOS CON ESTA FUNCION DE LW
    {
        $datos =  $this->validate();

        //! ALMACENAR LA IMAGEN
        $imagen = $this->imagen->store('public/vacantes');
        $datos['imagen'] = str_replace('public/vacantes/','',$imagen); //*PARA QUITAR "public/vacantes/" porque solo quiero el nombre.
                //?Busca 'public/vantes/              y lo remplaza por '' nada,            toma la informacion de $imagen.

        //! CREAR LA VACANTE
        Vacante::create([
            'titulo' => $datos['titulo'],
            'salario_id' =>$datos['salario'],  //?salario viene del wire:model
            'categoria_id' =>$datos['categoria'], //?categoria viene del wire:model
            'empresa' =>$datos['empresa'],
            'ultimo_dia' =>$datos['ultimo_dia'],
            'descripcion' =>$datos['descripcion'],
            'imagen' =>$datos['imagen'],
            'user_id' => auth()->user()->id
        ]);

        //! CREAR UN MENSAJE
        session()->flash('mensaje','La vacante se publico correctamente');

        //! REDIRECCIONAR AL USUARIO
        return redirect()->route('vacantes.index');

    }


    public function render()
    {
        //! CONSULTAR BASE DE DATOS PARA PASAR INFORMACION HACIA LA VISTA
        $salarios = Salario::all();
        $categorias = Categoria::all();

        return view('livewire.crear-vacante', [
            'salarios' => $salarios,  //?PASAR LA VARIABLE $salarios hacia la vista
            'categorias' => $categorias
        ]);
    }
}
