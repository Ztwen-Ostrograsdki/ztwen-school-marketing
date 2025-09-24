<div class="p-6 max-w-6xl mt-20 mx-auto z-bg-secondary-light-opac shadow-2 shadow-sky-500">
    <div class="mb-3">
        <div class="flex items-center justify-between gap-x-2 mb-6">
            <h2 class="lg:text-lg md:text-lg sm:text-sm  font-semibold letter-spacing-1 uppercase text-sky-500 card">
                <span>Mes citations</span>
                <span class="ml-5 text-yellow-500 text-sm">
                   ({{ numberZeroFormattor(count($quotes)) }} enregistrées)
                </span>
            </h2>
            <div class="flex justify-end gap-x-2">
                <div class="flex items-center card">
                    @if(!$showForm)
                        @if($max_quotables > count($quotes))
                        <button
                            wire:click="showCreateForm"
                            class="bg-blue-600 text-gray-200 px-4 py-2 rounded-lg hover:bg-blue-800 transition cursor-pointer font-semibold letter-spacing-1"
                        >
                            <span wire:loading.remove wire:target='showCreateForm'>
                                Ajouter une citation
                            </span>
                            <span wire:target='showCreateForm' wire:loading>
                                <span>Chargement en cours...</span>
                                <span class="fas fa-rotate animate-spin"></span>
                            </span>
                        </button>
                        @else
                        <h6 class="text-gray-800 bg-amber-400 px-2 py-1.5 rounded-md animate-pulse font-semibold letter-spacing-1 text-right p-2">Nombre maximal de citations atteint</h6>
                        @endif
                    @endif
                </div>
            </div>
        </div>
        <hr class="border-sky-600 mb-2">
        <div class="flex items-center w-full justify-center card">
              <h6 class="w-full items-center flex justify-center gap-x-9 py-3 font-semibold letter-spacing-1 text-yellow-400">
                <span>
                    <span class="text-gray-300">Auteur : </span>
                    <span>{{ $user->getFullName() }}</span>
                </span>
              </h6>
            </div>
        <hr class="border-sky-600 mb-2">
    </div>

    <div class="w-full mx-auto mt-6">
        <!-- Formulaire déroulant -->
        <div 
            x-data="{ open: @entangle('showForm') }" 
            x-show="open" 
            x-collapse
            x-transition.opacity
            class="overflow-hidden bg-transparent p-4 rounded-2xl mb-6 shadow-sm"
        >
            <form wire:submit.prevent="save" class="bg-transparent flex flex-col gap-y-2">
                <div class="grid gap-4 mb-4 grid-cols-2">
                    <div class="col-span-2">
                        <label for="quote-content" class="block mb-2 letter-spacing-1 font-medium text-gray-900 dark:text-white">La citation </label>
                        <textarea wire:loading.class='disabled opacity-50' wire:target='insert' wire:model.blur='content' id="quote-content" rows="4" class="block p-2.5 w-full text-gray-400 bg-transparent rounded-lg border border-gray-300 focus:ring-blue-500 focus:border-blue-500 font-semibold letter-spacing-1" placeholder="Enoncez votre citation ici..."></textarea>                    
                        @error('content')
                            <small class="text-xs text-red-600 mt-2">{{ $message }}</small>
                        @enderror
                    </div>
                </div>

                <div class="flex gap-2">
                    <button wire:click='save' type="submit" class="px-4 py-2 bg-green-600 text-white rounded-lg cursor-pointer hover:bg-green-700 transition">
                        <span wire:loading.remove wire:target='save'>
                            <span class="fas fa-check"></span>
                            {{ $isEditing ? 'Mettre à jour' : 'Enregistrer' }}
                        </span>
                        <span wire:target='save' wire:loading>
                            <span>Chargement en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                    <button type="button" 
                        wire:click="hideForm" 
                        class="px-4 py-2 bg-gray-300 text-gray-700 rounded-lg cursor-pointer hover:bg-gray-500 hover:text-gray-100 transition">
                        <span wire:loading.remove wire:target='hideForm'>
                            <span class="fas fa-eye-slash"></span>
                            Annuler
                        </span>
                        <span wire:target='hideForm' wire:loading>
                            <span>Annulation en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                </div>
            </form>
        </div>
    </div>

    @if(!$showForm)
        <div class="">
            @if (count($quotes) > 0)
                <div class="w-full p-2 mx-auto flex flex-col gap-y-3">
                    @foreach ($quotes as $quote)
                        <div wire:key="citation-{{$user->id}}-{{$quote->id}}" class="border p-3 z-bg-secondary-light shadow rounded-2xl flex  justify-between hover:shadow-md transition flex-col">
                            <div class="flex w-full justify-between">
                                <h6 class="uppercase letter-spacing-1 text-sky-400 py-2">Citation {{ $loop->iteration }}</h6>
                                <div class="flex items-center justify-between gap-x-2">
                                    <button wire:click="showEditForm({{ $quote->id }})" class="bg-gray-600 text-white px-4 py-2 rounded-lg hover:bg-gray-800 transition cursor-pointer">
                                        <span wire:loading.remove wire:target='showEditForm({{$quote->id}})'>
                                            Modifier la citation
                                        </span>
                                        <span wire:target='showEditForm({{$quote->id}})' wire:loading>
                                            <span>Chargement en cours...</span>
                                            <span class="fas fa-rotate animate-spin"></span>
                                        </span>
                                    </button>

                                    <button wire:target='deleteQuote({{$quote->id}})'  wire:click="deleteQuote({{$quote->id}})" class="cursor-pointer bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-800 hover:text-gray-100 transition">
                                        <span wire:loading.remove wire:target='deleteQuote({{$quote->id}})'>
                                            Supprimer
                                        </span>
                                        <span wire:target='deleteQuote({{$quote->id}})' wire:loading>
                                            <span>Suppression en cours...</span>
                                            <span class="fas fa-rotate animate-spin"></span>
                                        </span>
                                    </button>
                                </div>
                            </div>
                            <hr class="border border-sky-600 my-2">

                            <h6 class="text-gray-400 font-semibold letter-spacing-1 my-1">
                                <blockquote>
                                    <span class="fas fa-quote-left"></span>
                                    {{ $quote->content }}
                                    <span class="fas fa-quote-right"></span>
                                </blockquote>
                                <span class="text-right mt-3 block text-sm text-sky-400 letter-spacing-1 font-semibold italic">
                                    @ {{ $quote->user->getFullName() }}
                                </span>
                            </h6>
                            <p class="text-right text-xs text-yellow-400 letter-spacing-1">
                                Publiée le {{ __formatDateTime($quote->created_at) }}
                            </p>
                        </div>
                    @endforeach
                </div>
                
            @endif
        </div>
    @endif
</div>







