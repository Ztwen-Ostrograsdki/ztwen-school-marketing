<div wire:ignore.self id="{{str_replace('#', '', $modal_name)}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-black/80 border border-sky-500 rounded-lg shadow-2xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-sm sm:text-lg font-semibold text-amber-400">
                        <span class="fas fa-user-plus mr-1.5"></span>
                        Enroler un assistant
                    </h3>
                    <button wire:click='hideModal' type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form wire:submit.prevent="addAssistant" class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-2">
                            <label for="school_id" class="block mb-2 text-sm text-amber-400 font-medium ">L'école</label>
                            <select wire:model.live='school_id' id="school_id" class="bg-transparent border border-sky-400 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option class="text-sm text-white py-1.5 bg-black" >Selectionner l'école</option>
                                @foreach ($schools as $school)
                                    <option class="text-white py-1.5 bg-black px-2.5" value="{{$school->id}}">{{ $school->name }}</option>
                                @endforeach
                            </select>
                            @error('school_id') 
                                <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>

                        <div class="col-span-2">
                            <label for="assistant" class="block mb-2 text-sm text-amber-400 font-medium ">Email ou ID de l'utilisateur</label>
                            <input wire:model.blur='assistant' type="text" name="assistant" id="assistant" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner l'addresse mail ou l'ID de l'utilisateur ciblé" >
                            @error('assistant') 
                                <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                        
                        <div class="col-span-2">
                            <label for="assistant_roles" class="block mb-2 text-sm text-amber-400 font-medium ">Privilèges accordés</label>
                            <select wire:model.live='assistant_roles' multiple id="assistant_roles" class="bg-transparent border border-sky-400 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option class="text-sm text-white py-1.5 bg-black" >Selectionner les Privilèges</option>
                                @foreach ($roles as $role_name)
                                    <option class="text-white py-1.5 bg-black px-2.5" value="{{$role_name}}">{{ __translateRoleName($role_name) }}</option>
                                @endforeach
                            </select>
                            @error('assistant_roles') 
                                <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                        
                    </div>
                    <span wire:click.prevent="addAssistant"  class="text-black cursor-pointer flex w-full mx-auto justify-center items-center focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-sky-500 hover:bg-sky-700 focus:ring-blue-800 letter-spacing-1 border border-sky-600">
                        <span wire:loading.remove wire:target='addAssistant'>
                            <span class="fas fa-user-check mr-1.5"></span>
                            Soumettre la requête
                        </span>
                        <span class="" wire:loading wire:target='addAssistant'>
                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                            <span>Requête en cours...</span>
                        </span>
                    </span>
                </form>
            </div>
        </div>
    </div>