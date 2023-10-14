<div>
    <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">

        @forelse ($vacantes as $vacante)
            {{-- ? ES UNA MEZCLA DE FOREACH Y UN IF EN UNA SOLA LINEA --}}
            <div class="p-6 bg-white border-b border-gray-200 md:flex md:justify-between md:items-center">

                <div class="space-y-3">
                    <a href="{{route('vacantes.show', $vacante->id)}}" class="text-xl font-bold"> {{ $vacante->titulo }}</a>
                    <p class="text-sm text-gray-600 font-bold">{{ $vacante->empresa }}</p>
                    <p class="text-sm text-gray-500">Ultimo dia: {{ $vacante->ultimo_dia->format('d/m/Y') }}</p>
                </div>

                <div class="flex flex-col gap-3 items-stretch mt-5 md:mt-0 text-center md:flex-row">
                    <a href="{{route('candidatos.index', $vacante)}}"
                        class="bg-slate-800 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase">
                       {{$vacante->candidatos->count()}} Candidatos</a>
                    <a href="{{ route('vacantes.edit', $vacante->id) }}"
                        class="bg-blue-800 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase">Editar</a>
                    <button wire:click="$dispatch('mostrarAlerta', {{ $vacante->id }})"
                        class="bg-red-600 py-2 px-4 rounded-lg text-white text-xs font-bold uppercase">Eliminar</button>
                </div>

            </div>
        @empty {{-- ? SI NO DETECTA NADA ENTONCECS MUESTRA LO SIGUIENTE --}}
            <p class="p-3 text-center text-sm text-gray-600">No hay vacantes que mostrar</p>
        @endforelse

    </div>

    <div class="mt-10">
        {{ $vacantes->links() }}
    </div>

    @push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
 
    <script>
        document.addEventListener('livewire:initialized', () => {
 
            Livewire.on('mostrarAlerta', (vacanteId) => { //PRIMERA FORMA (DESDE EL SCRIP)
                Swal.fire({
                title: '¿Eliminar Vacante?',
                text: "una vacante eliminada no se puede recuperar",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, Eliminar!',
                cancelButtonText: 'Cancelar'
                }).then((result) => {
                if (result.isConfirmed) {
                    // eliminar la vacante desde el servidor
                    Livewire.dispatch('eliminarVacante', {vacante: vacanteId}) //SEGUNDA FORMAS (DESDE EL COMPONENTE)
                    Swal.fire(
                    'Eliminado!',
                    'La vacante ha sido eliminada',
                    'success'
                    )
                }
                })
            }) 
        })
    </script>
@endpush

</div>
