<div wire:ignore.self id="{{str_replace('#', '', $modal_name)}}" tabindex="-1" aria-hidden="true" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">
        <div class="relative p-4 w-full max-w-md max-h-full">
            <!-- Modal content -->
            <div class="relative bg-black/80 border border-sky-500 rounded-lg shadow-2xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between p-4 md:p-5 border-b rounded-t dark:border-gray-600 border-gray-200">
                    <h3 class="text-sm sm:text-lg font-semibold text-amber-400">
                        <span class="fas fa-user-plus mr-1.5"></span>
                        Utilitaire de déconnexion
                    </h3>
                    <button wire:click='hideModal' type="button" class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm w-8 h-8 ms-auto inline-flex justify-center items-center dark:hover:bg-gray-600 dark:hover:text-white cursor-pointer">
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m1 1 6 6m0 0 6 6M7 7l6-6M7 7l-6 6"/>
                        </svg>
                        <span class="sr-only">Close modal</span>
                    </button>
                </div>
                <!-- Modal body -->
                <form wire:submit.prevent="hideModal" class="p-4 md:p-5">
                    <div class="flex gap-4 justify-center items-center">
                        <button wire:click.prevent="hideModal"  class="text-white cursor-pointer flex justify-center items-center focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-4 text-center bg-gray-500 hover:bg-gray-800 focus:ring-blue-800 letter-spacing-1 col-span-1">
                            <span>
                                <span class="fas fa-x mr-1.5"></span>
                                Annuler
                            </span>
                        </button>

                        <button wire:click.prevent="logout"  class="text-black cursor-pointer flex justify-center items-center focus:ring-4 focus:outline-none font-medium rounded-lg text-sm px-5 py-4 text-center bg-amber-500 hover:bg-amber-800 focus:ring-blue-800 letter-spacing-1 col-span-1">
                            <span wire:loading.remove wire:target='logout'>
                                <span class="fas fa-user-large-slash mr-1.5"></span>
                                Se déconnecter
                            </span>
                            <span class="" wire:loading wire:target='logout'>
                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                <span>Déconnexion en cours...</span>
                            </span>
                        </button>
                    </div>
                    
                </form>
            </div>
        </div>
    </div>