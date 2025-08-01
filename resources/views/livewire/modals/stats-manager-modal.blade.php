<div wire:ignore.self id="{{str_replace('#', '', $modal_name)}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-black/60 border border-sky-500 rounded-lg shadow-2xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-sm sm:text-lg font-semibold text-amber-700">
                        <span class="fas fa-user-plus mr-1.5"></span>
                        @if($stat_model) 
                        Edition d'une statistique
                        @else
                        Ajout d'une des statistique
                        @endif
                    </h3>
                    <button wire:click='hideModal' type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form wire:submit.prevent="insert" class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">
                        <div class="col-span-1">
                            <label for="exam" class="block mb-2 text-sm text-amber-400 font-medium ">Examen</label>
                            <select wire:model='exam' id="exam" class="bg-transparent border border-sky-400 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option class="text-sm text-white py-1.5 bg-black" >Selectionner l'examen</option>
                                @foreach ($exams as $k => $exm)
                                    <option class="text-white py-1.5 bg-black" value="{{$exm}}">{{$exm}}</option>
                                @endforeach
                            </select>
                            @error('exam')
                                <p  class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                        <div class="col-span-1">
                            <label for="year" class="block mb-2 text-sm text-amber-400 font-medium ">L'année</label>
                            <select wire:model.live='year' id="year" class="bg-transparent border border-sky-400 text-gray-900 text-sm rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 dark:border-gray-500 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                <option disabled class="text-sm text-white py-1.5 bg-black" >Selectionner l'année</option>
                                @for ($y = date('Y'); $y >= 1900; $y--)
                                    <option class="text-white py-1.5 bg-black" value="{{$y}}">{{$y}}</option>
                                @endfor
                            </select>
                            @error('year')
                                <p  class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                {{ $message }}
                                </p>
                            @enderror
                        </div>
                        <div class="col-span-2">

                            <label for="title" class="flex justify-between mb-2 text-sm text-amber-400 font-medium ">
                                <span>Références</span>
                                <span class="text-orange-500 letter-spacing-1 font-thin">(Optionnel)</span>
                            </label>

                            <input wire:model.blur='title' type="text" name="title" id="title" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="BEPC 2025, BAC 2025..." >
                            
                        </div>

                        <div class="col-span-1">
                            <label for="stat_value" class="block mb-2 text-sm text-amber-400 font-medium ">Le pourcentage</label>
                            <input wire:model.blur='stat_value' type="text" name="stat_value" id="stat_value" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="98" >
                            @error('stat_value')
                                <p  class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                {{ $message }}
                                </p>
                            @enderror
                        </div>
                        
                    </div>
                    <span wire:click.prevent="insert"  class="text-black cursor-pointer flex w-full mx-auto justify-center items-center focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-sky-500 hover:bg-sky-700 focus:ring-blue-800 letter-spacing-1 border border-sky-600">
                        <span wire:loading.remove wire:target='insert'>
                            <span class="fas fa-user-check mr-1.5"></span>
                            @if($stat_model)
                            Mettre à jour
                            @else
                            Enregistrer
                            @endif
                        </span>
                        <span class="" wire:loading wire:target='insert'>
                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                            <span>Enregistrement en cours...</span>
                        </span>
                    </span>
                </form>
            </div>
        </div>
    </div>