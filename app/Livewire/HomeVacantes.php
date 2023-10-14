<?php

namespace App\Livewire;

use App\Models\Vacante;
use Livewire\Component;
use Livewire\WithPagination;

class HomeVacantes extends Component
{

    use WithPagination; //PARA HACER PAGINACION CON LIVEWIRE

    public $termino;
    public $categoria;
    public $salario;

    protected $listeners = ['terminosBusqueda' => 'buscar']; //PARA LOS EMIT

    //ESTE ES EL PADRE DE FILTRAR VACANTES
    public function buscar($termino, $categoria, $salario)
    {
        $this->termino = $termino;
        $this->categoria = $categoria;
        $this->salario = $salario;
    }

    public function render()
    {
        $vacantes = Vacante::all();

        $vacantes = Vacante::when($this->termino, function($query){ //WHEN SE EJECutA SI HAY UN TERMINO
            $query->where('titulo', 'LIKE', "%" . $this->termino . "%"); //LO QUE HACE EL "%" ES BUSCAR LA PALABRA
        })
        ->when($this->termino, function($query){
            $query->orWhere('empresa','LIKE', "%" . $this->termino . "%");
        })
        ->when($this->categoria, function($query){
            $query->where('categoria_id',$this->categoria);
        })
        ->when($this->salario, function($query){
            $query->where('salario_id',$this->salario);
        })
        
        ->paginate(5);

        return view('livewire.home-vacantes', [
            'vacantes' => $vacantes
        ]);
    }
}
