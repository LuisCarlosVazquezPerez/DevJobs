<?php

namespace App\Livewire;

use App\Models\Vacante;
use App\Notifications\NuevoCandidato;
use Livewire\Component;
use Livewire\WithFileUploads;

class PostularVacante extends Component
{
    use WithFileUploads; //!HABILITA LA CARGA DE ARACHIVOS
    public $cv;
    public $vacante;

    protected $rules = [
        'cv' => 'required|mimes:pdf'
    ];

    public function mount(Vacante $vacante) //!CUANDO EL COMPONENTE HA SIDO INSTANCIADO PARA PASAR INFORMACION ESPECIFICA
    {
        $this->vacante = $vacante;
    }


    public function postularme()
    {
        //? ALMACENAR CV EN EL DISCO DURO

        $datos =  $this->validate();
        //! ALMACENAR LA IMAGEN
        $cv = $this->cv->store('public/cv');
        $datos['cv'] = str_replace('public/cv/', '', $cv); //*PARA QUITAR "public/vacantes/" porque solo quiero el nombre.
        //*Busca 'public/vantes/              y lo remplaza por '' nada,            toma la informacion de $imagen.



        //? CREAR EL CANDIDATO A LA VACANTE
        $this->vacante->candidatos()->create([
            'user_id'=>auth()->user()->id,
            'cv' => $datos['cv']
        ]);

        //? CREAR NOTIFICACION Y ENVIAR EL EMAIL
        $this->vacante->reclutador->notify(new NuevoCandidato($this->vacante->id,$this->vacante->titulo,auth()->user()->id));        

        //? MOSTRAR EL USUARIO UN MENSAJE DE OK
        session()->flash('mensaje','Se envio correctamente tu informacion, mucha suerte!');
        return redirect()->back();
    }

    public function render()
    {
        return view('livewire.postular-vacante');
    }
}
