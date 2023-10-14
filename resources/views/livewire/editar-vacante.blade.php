<form class="md:w-1/2 space-y-5" wire:submit.prevent='editarVacante'>

    <div>
        <x-input-label for="titulo" :value="__('Titulo Vacante')" />
        <x-text-input id="titulo" class="block mt-1 w-full" type="text" wire:model="titulo" :value="old('titulo')" placeholder="Titulo Vacante" />
        @error('titulo')
        <livewire:mostrar-alerta :message="$message"/>
        @enderror
    </div>

    <div>
        <x-input-label for="salario" :value="__('Salario Mensual')" />
        <select for="salario" wire:model="salario" id="salario" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option>-- Seleccione --</option>
            @foreach ($salarios as $salario)
            <option value="{{$salario->id}}">{{$salario->salario}} </option>
            @endforeach
        </select>
        @error('salario')
        <livewire:mostrar-alerta :message="$message"/>
        @enderror
    </div>

    <div>
        <x-input-label for="categoria" :value="__('Categoria')" />
        <select for="categoria" wire:model="categoria" id="categoria" class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
            <option>-- Seleccione --</option>
            @foreach ($categorias as $categoria)
            <option value="{{$categoria->id}}">{{$categoria->categoria}} </option>
            @endforeach
        </select>
        @error('categoria')
        <livewire:mostrar-alerta :message="$message"/>
        @enderror
    </div>

    <div>
        <x-input-label for="empresa" :value="__('Empresa')" />
        <x-text-input id="empresa" class="block mt-1 w-full" type="text" wire:model="empresa" :value="old('empresa')" placeholder="Empresa ej. Google, Netflix, Uber" />
            @error('empresa')
            <livewire:mostrar-alerta :message="$message"/>
            @enderror
    </div>

    <div>
        <x-input-label for="ultimo_dia" :value="__('Ultimo Dia para postularse')" />
        <x-text-input id="ultimo_dia" class="block mt-1 w-full" type="date" wire:model="ultimo_dia" :value="old('ultimo_dia')" />
            @error('ultimo_dia')
            <livewire:mostrar-alerta :message="$message"/>
            @enderror
    </div>

    <div>
        <x-input-label for="descripcion" :value="__('Descripcion Puesto')" />
       <textarea class="w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm h-72" wire:model="descripcion" placeholder="Descripcion general del puesto, experiencia"></textarea>
    </div>

    <div>
        <x-input-label for="imagen" :value="__('Imagen')" />
        <x-text-input id="imagen" class="block mt-1 w-full" type="file" wire:model="imagen_nueva" accept="image/*"/>
     
        <div class="my-5 w-80">
            <x-input-label :value="__('Imagen Actual')" />
            <img src="{{asset('storage/vacantes/' . $imagen)}}" alt="{{'Imagen Vacante ' . $titulo}}"> {{--* asset apunta hacia archivos estaticos, siempre apunta a public --}}
        </div>

         <div class="my-5 w-80"> 
            {{-- ? ENLACE DE DATOS BIDIRECCIONAL / TWO WAY DATA BINDING --}}
            @if ($imagen_nueva)
                Imagen Nueva:
                <img src="{{$imagen_nueva->temporaryUrl()}}" alt="">
            @endif
        </div>

        @error('imagen_nueva')
        <livewire:mostrar-alerta :message="$message"/>
        @enderror
    </div>

    <x-primary-button>
       Guardar Cambios
    </x-primary-button>

 


</form>