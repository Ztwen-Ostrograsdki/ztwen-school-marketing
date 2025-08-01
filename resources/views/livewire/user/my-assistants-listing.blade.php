<div class="w-full max-w-[85rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2">
    <div class="mt-10">
        <div>
            <h5 class="card letter-spacing-1 flex justify-between bg-black/70 border-sky-400 border-2 text-center mx-auto items-center px-2 gap-2 text-gray-200 rounded-sm">
                <p class="py-4 relative inline-block text-sm md:text-lg  uppercase font-bold letter-spacing-2 text-amber-600 text-start"> 
                    <span class="">
                        <span class="mx-1">#</span>
                        Mes demandes d'assistance envoyées : <span class="uppercase text-orange-500">
                        </span>
                    </span>
                </p>
                <span class="text-yellow-500 font-semibold">{{ __zero(count($my_assistants)) }}</span>
            </h5>
        </div>
        <div class="w-full bg-transparent pt-12">
            <div class="w-full bg-black/60 shadow-2xl border border-sky-500 shadow-gray-900 flex items-center justify-center min-h-full py-5 px-2">
                <div class="container max-w-6xl">
                    <div class="overflow-hidden">
                    <!-- Table Header -->
                        <div class="relative py-2">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="text-amber-500/65 font-semibold letter-spacing-1">
                                    <h2 class="text-sm sm:text-xl font-bold uppercase text-shadow shadow-amber-400">La liste de vos assistants</h2>
                                    <p class="text-gray-400 mt-1">Vous pouvez gérer vos différents assistants. </p>
                                </div>
                                <div class="text-xs sm:text-sm mt-4 md:mt-0 flex gap-x-2 justify-end">
                                    <a href="{{$user->to_profil_route()}}" class="block text-black cursor-pointer bg-yellow-300 focus:ring-2 focus:outline-none font-medium rounded-lg px-5 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                                        <span>
                                            <span class="fas fa-home mr-1"></span>
                                            Mon profil
                                        </span>
                                    </a>
                                    <button wire:click='generateAssistantTokenFor' class="block text-black cursor-pointer bg-green-400 focus:ring-2 focus:outline-none font-medium rounded-lg px-5 py-2 text-center hover:bg-green-800 focus:ring-green-800" type="button">
                                        <span wire:loading.remove wire:target='generateAssistantTokenFor'>
                                            <span class="fas fa-key mr-1"></span>
                                            Ajouter un assistant
                                        </span>
                                        <span wire:loading wire:target='generateAssistantTokenFor'>
                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                            <span>Un instant, en cours...</span>
                                        </span>
                                    </button>
                                    
                                    <button class="bg-red-600 cursor-pointer hover:bg-red-800 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                                        <span class="fas fa-trash mr-1"></span>
                                        Suppr. les assistants.
                                    </button>
                                </div>
                            </div>
                            <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                            
                        </div>
                        
                        <!-- Table -->
                        @if(count($my_assistants))
                        <div class="overflow-x-auto my-5 ">
                            <table class="min-w-full divide-y text-xs sm:text-sm letter-spacing-1 divide-gray-200 border">
                                <thead class="bg-black/50 text-sky-500 ">
                                    <tr class="tr-head">
                                        <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                            utilisateur | Assistant
                                        </th>
                                        <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                            Privilèges accordés
                                        </th>
                                        
                                        <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                            Statut
                                        </th>
                                        <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y text-gray-200 divide-gray-200">
                                    @foreach($my_assistants as $assistant_request)
                                        <tr wire:key="Liste-de-mes-assistants-'{{$assistant_request->id}}'" class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex items-center">
                                                    <div class="h-10 w-10 flex-shrink-0">
                                                        <img class="h-10 w-10 rounded-full object-cover border-sky-500 border" src="{{ user_profil_photo($assistant_request->assistant) }}" alt="">
                                                    </div>
                                                    <div class="ml-4">
                                                        <div class="">{{ $assistant_request->assistant->getFullName() }}</div>
                                                        <div class="text-sm text-amber-500">
                                                            {{ $assistant_request->assistant->email }}
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                @if($assistant_request->approved_at)
                                                <div class="flex flex-col text-center mx-auto bg-black/50 rounded-lg text-green-700 p-2 text-xs mt-1.5">
                                                    <span class="text-green-500">
                                                        Approuvée le {{ __formatDate($assistant_request->approved_at) }}
                                                    </span>
                                                    <span class="text-orange-300 text-center">
                                                        {{ __asAgo($assistant_request->approved_at) }}
                                                    </span>
                                                </div>
                                                @endif
                                                @if(!$assistant_request->is_active)
                                                <div class="flex flex-col text-center mx-auto bg-red-300 rounded-lg text-red-600 p-1.5 text-xs mt-1.5">
                                                    <span class="text-red-600 fas fa-user-lock"></span>
                                                    <span class="text-red-600 text-center">
                                                        Accès bloqué
                                                    </span>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap">
                                                <div class="flex flex-wrap gap-2">
                                                    @foreach ($assistant_request->privileges as $role)
                                                        <span class="p-1 border bg-gray-500 text-white hover:bg-gray-700 rounded-xl">{{ __translateRoleName($role) }}</span>
                                                    @endforeach
                                                    @if(!$assistant_request->is_active)
                                                        <span title="Cet utilisateur est vérouillé" class="fas fa-user-lock text-red-500 font-semibold ml-1.5 text-lg"></span>
                                                    @endif
                                                </div>
                                            </td>
                                            
                                            <td class="px-6 py-4 text-center whitespace-nowrap">
                                                @if($assistant_request->status == 'Approuvé' || $assistant_request->approved_at)
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">
                                                   Approuvé
                                                </span>
                                                @else
                                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-200 text-red-600">
                                                   En attente...
                                                </span>
                                                @endif
                                            </td>
                                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="flex flex-col gap-y-2.5">
                                                    <button wire:click="manageAssistant('{{$assistant_request->id}}', '{{$assistant_request->assistant->getFullName()}}')" class="block text-white cursor-pointer bg-blue-600 focus:ring-2 focus:outline-none font-medium rounded-lg px-5 py-2 text-center hover:bg-blue-800 focus:ring-blue-800" type="button">
                                                        <span wire:loading.remove wire:target="manageAssistant('{{$assistant_request->id}}', '{{$assistant_request->assistant->getFullName()}}')">
                                                            <span class="fas fa-user-edit mr-1"></span>
                                                            Editer
                                                        </span>
                                                        <span wire:loading wire:target="manageAssistant('{{$assistant_request->id}}', '{{$assistant_request->assistant->getFullName()}}')">
                                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                            <span>En cours...</span>
                                                        </span>
                                                    </button>
                                                    @if(!$assistant_request->is_active)
                                                        <button wire:click="unlockAccess('{{$assistant_request->id}}', '{{$assistant_request->assistant->getFullName()}}')" class="block text-white cursor-pointer bg-green-500 focus:ring-2 focus:outline-none font-medium rounded-lg px-5 py-2 text-center hover:bg-green-800 focus:ring-green-800" type="button">
                                                            <span wire:loading.remove wire:target="unlockAccess('{{$assistant_request->id}}', '{{$assistant_request->assistant->getFullName()}}')">
                                                                <span class="fas fa-unlock-keyhole mr-1"></span>
                                                                Devérouiller
                                                            </span>
                                                            <span wire:loading wire:target="unlockAccess('{{$assistant_request->id}}', '{{$assistant_request->assistant->getFullName()}}')">
                                                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                                <span>En cours...</span>
                                                            </span>
                                                        </button>
                                                    @else
                                                    <button wire:click="lockAccess('{{$assistant_request->id}}', '{{$assistant_request->assistant->getFullName()}}')" class="block text-black cursor-pointer bg-orange-300 focus:ring-2 focus:outline-none font-medium rounded-lg px-5 py-2 text-center hover:bg-orange-800 focus:ring-orange-800" type="button">
                                                        <span wire:loading.remove wire:target="lockAccess('{{$assistant_request->id}}', '{{$assistant_request->assistant->getFullName()}}')">
                                                            <span class="fas fa-user-lock mr-1"></span>
                                                            Verouiller
                                                        </span>
                                                        <span wire:loading wire:target="lockAccess('{{$assistant_request->id}}', '{{$assistant_request->assistant->getFullName()}}')">
                                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                            <span>En cours...</span>
                                                        </span>
                                                    </button>
                                                    @endif
                                                    <button wire:click="deleteAssistant('{{$assistant_request->id}}', '{{$assistant_request->assistant->getFullName()}}')" class="block text-white cursor-pointer bg-red-500 focus:ring-2 focus:outline-none font-medium rounded-lg px-5 py-2 text-center hover:bg-red-800 focus:ring-red-800" type="button">
                                                        <span wire:loading.remove wire:target="deleteAssistant('{{$assistant_request->id}}', '{{$assistant_request->assistant->getFullName()}}')">
                                                            <span class="fas fa-trash mr-1"></span>
                                                            Supprimer
                                                        </span>
                                                        <span wire:loading wire:target="deleteAssistant('{{$assistant_request->id}}', '{{$assistant_request->assistant->getFullName()}}')">
                                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                            <span>En cours...</span>
                                                        </span>
                                                    </button>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    
                                </tbody>
                            </table>
                        </div>
                        @else
                        <h6 class="text-center py-5 px-2 my-8 text-red-700 bg-red-300/80 rounded-lg font-semibold letter-spacing-1">
                            Vous n'avez aucune demande en cours!!!
                        </h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

