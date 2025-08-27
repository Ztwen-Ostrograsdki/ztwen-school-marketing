<div wire:ignore.self id="{{str_replace('#', '', $modal_name)}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        @if($image && $school)
        <div class="relative p-4 w-full max-w-lg max-h-full">
            <!-- Modal content -->
            <div class="relative bg-black/80 border border-sky-500 rounded-lg shadow-2xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-sm sm:text-lg font-semibold text-amber-400">
                        <span class="fas fa-user-plus mr-1.5"></span>
                        Edition image de 
                        
                        <span class="text-amber-600">
                            {{ $school->name }}
                        </span>
                    </h3>
                    <button wire:click='hideModal' type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form wire:submit.prevent="updateImageData" class="p-4 md:p-5">
                    <div class="grid gap-4 mb-4 grid-cols-2">

                        <div class="col-span-2">
                            <label for="title" class="block mb-2 text-sm text-amber-400 font-medium ">Le titre de l'image</label>
                            <input wire:model.blur='title' type="text" name="title" id="title" class="bg-transparent border border-gray-300 text-gray-900 text-sm rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5   dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner un titre à votre image" >
                            @error('title') 
                                <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                    {{ $message }}
                                </span> 
                            @enderror
                        </div>
                        
                        <div class="col-span-2">
                            <div class="border border-purple-500">
                                <div class="aspect-square bg-gray-100 relative group card">
                                    <img class="w-full h-full object-cover border shadow-sm" src="{{url('storage', $image->path)}}" alt="Image N° {{$image->title}} de l'école">
                                    <div  class="absolute top-2 left-1 items-center cursor-pointer bg-black/90 text-white inline-flex p-3 text-center  justify-center bg-opacity-70 opacity-80 group-hover:text-amber-500 transition-all duration-200">
                                        <div class="flex space-x-4 cursor-pointer text-center letter-spacing-2 text-xs">
                                            <span class="text-center"> {{ $title }} </span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <span wire:click.prevent="updateImageData"  class="text-black cursor-pointer flex w-full mx-auto justify-center items-center focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-2.5 text-center bg-sky-500 hover:bg-sky-700 focus:ring-blue-800 letter-spacing-1 border border-sky-600">
                        <span wire:loading.remove wire:target='updateImageData'>
                            <span class="fas fa-check mr-1.5"></span>
                            Mettre à jour
                        </span>
                        <span class="" wire:loading wire:target='updateImageData'>
                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                            <span>Mise à jour en cours...</span>
                        </span>
                    </span>
                </form>
            </div>
        </div>
        @endif
    </div>