
  <!-- Main modal -->
  <div wire:ignore.self id="{{str_replace('#', '', $modal_name)}}" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
    <div class="relative p-4 w-full max-w-2xl mt-10 max-h-full">
        <!-- Modal content -->
        <div class="relative bg-black/85 border rounded-lg shadow ">
            <!-- Modal header -->
            <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600">
                <h3 class="text-lg font-semibold text-white">
                    Gestion des privilèges de l'assistant 
                    <span class="text-sky-300 underline underline-offset-4">{{ $assistant?->getFullName() }}</span>
                    <span class="text-amber-500 font-semibold letter-spacing-1 block text-sm"> {{ $school?->name }} </span>
                </h3>
                <button wire:click='hideModal' type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white">
                    <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                        <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                    </svg>
                    <span class="sr-only">Fermer</span>
                </button>
            </div>
            <!-- Modal body -->
            <form wire:ignore.self class="p-4 md:p-5">
                <div class="w-full my-2">
                    <h5 class="my-3 text-gray-500 xs:text-xs lg:text-base w-full">
                        <span>Veuillez sélectionner les privilèges</span>

                        <span class="float-right text-orange-300"> {{ count($selecteds) }} privilèges sélectionnés </span>
                    </h5>
                </div>
                <div class="mt-3 w-full mb-5 group overflow-y-auto p-3" style="max-height: 400px">

                    <table class="w-full text-sm text-center border rounded-lg rtl:text-right text-gray-500 dark:text-gray-400 xs:text-xs lg:text-base">
            
                        @if(count($roles) > 0)
                        <thead class="text-xs text-gray-900 uppercase bg-gray-50 dark:bg-blue-900 dark:text-gray-400 items-center">
                            <tr class="tr-head">
                                <th scope="col" class="px-6 py-4 text-left">
                                    N°
                                </th>
                                <th scope="col" class="px-6 py-4">
                                   Privilèges
                                </th>
                                <th scope="col" class="px-6 py-4 text-center">
                                    Action à effectuer 
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($roles as $role)
                            <tr wire:key="assistant-joined-to-role-{{$role->name}}" class="odd:bg-white odd:dark:bg-gray-900 even:bg-gray-50 even:dark:bg-gray-800 border-b dark:border-gray-700">
                                <th scope="row" class="px-6 py-1 text-left text-gray-400 whitespace-nowrap ">
                                    {{ __zero($loop->iteration) }}
                                </th>
                                <td class="px-6 py-1 text-left">
                                    {{ __translateRoleName($role->name) }} 
                                </td>
                                <td class="px-1 py-1">
                                    @if(!in_array($role->name, $selecteds))
                                    <span wire:click="pushIntoSelecteds('{{$role->name}}')" class="bg-blue-500 text-gray-950 cursor-pointer border inline-block w-full rounded-lg py-1 px-3">
                                        <span wire:loading.remove wire:target="pushIntoSelecteds('{{$role->name}}')">
                                            <span>Ajouter</span>
                                            <span class="fas fa-plus"></span>
                                        </span>
                                        <span wire:loading wire:target="pushIntoSelecteds('{{$role->name}}')">
                                            <span class="fas fa-rotate animate-spin"></span>
                                            <span class="text-xs">En cours...</span>
                                        </span>
                                        
                                    </span>
                                    @endif

                                    @if(in_array($role->name, $selecteds))
                                    <span  wire:click="retrieveFromSelecteds('{{$role->name}}')" class="bg-red-500 cursor-pointer text-gray-950 w-full inline-block border rounded-lg py-1 px-3">
                                        <span wire:loading.remove wire:target="retrieveFromSelecteds('{{$role->name}}')">
                                            <span>Retirer</span>
                                            <span class="fas fa-trash"></span>
                                        </span>
                                        <span wire:loading wire:target="retrieveFromSelecteds('{{$role->name}})'">
                                            <span class="fas fa-rotate animate-spin"></span>
                                            <span class="text-xs">En cours...</span>
                                        </span>
                                    </span>
                                    @endif
                                </td>
                            </tr>
                            @endforeach
                        
                        </tbody>
                        @endif 
                    </table>
                </div>
                @if($selecteds == [])
                    <div class="w-full my-2">
                        <span class="text-red-600">Veuiller selectionner les roles</span>
                    </div>
                @else
                <div class="w-full my-2 p-2">
                    <span wire:click="insert" class="border mx-auto cursor-pointer flex items-center text-center justify-center w-3/5 bg-blue-700 text-gray-100 hover:bg-blue-600 px-5 py-2 rounded-full">
                        <span wire:loading.remove wire:target='insert'>Mettre à jour</span>
                        <span wire:loading wire:target='insert' class="">Traitement en cours...</span>
                        <span wire:loading wire:target='insert' class="fas fa-rotate animate-spin"></span>
                    </span>
                </div>
                @endif

            </form>
        </div>
    </div>
</div> 
