<div class="w-full max-w-[85rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2">
    <div class="mt-10">
        <div>
            <h5 class="card letter-spacing-1 flex justify-between bg-black/70 border-sky-400 border-2 text-center mx-auto items-center px-2 gap-2 text-gray-200 rounded-sm">
                <p class="py-4 relative inline-block  text-sm md:text-lg  uppercase font-bold letter-spacing-2 text-amber-600 text-start"> 
                    <span class="">
                        <span class="mx-1">#</span>
                        Mes requêtes d'assistance reçues: <span class="uppercase text-orange-500">
                        </span>
                    </span>
                </p>
                <span class="text-yellow-500 font-semibold">{{ __zero(count($my_assistings)) }}</span>
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
                                    <h2 class="text-sm sm:text-xl font-bold uppercase text-shadow shadow-amber-400"></h2>
                                    <p class="text-gray-400 mt-1">
                                        Ici sont listées les requêtes qui vous ont été envoyées
                                    </p>
                                </div>
                                <div class="text-xs sm:text-sm mt-4 md:mt-0 flex gap-x-2 justify-end">
                                    <a href="{{$user->to_profil_route()}}" class="block text-black cursor-pointer bg-yellow-300 focus:ring-4 focus:outline-none font-medium rounded-lg px-5 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                                        <span>
                                            <span class="fas fa-home mr-1"></span>
                                            Mon profil
                                        </span>
                                    </a>
                                    <button class="bg-red-600 cursor-pointer hover:bg-red-800 text-white font-medium py-2 px-4 rounded-lg transition duration-150 ease-in-out">
                                        <span class="fas fa-trash mr-1"></span>
                                        Suppr. les requêtes.
                                    </button>
                                </div>
                            </div>
                            <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                            
                        </div>
                        
                        <!-- Table -->
                        @if(count($my_assistings))
                        <div class="overflow-x-auto my-5 ">
                            <table class="min-w-full divide-y text-xs sm:text-sm letter-spacing-1 divide-gray-200 border">
                                <thead class="bg-black/50 text-sky-500 ">
                                    <tr class="tr-head">
                                        <th scope="col" class="px-2 py-2 uppercase tracking-wider text-left">
                                            Ecoles
                                        </th>
                                        <th scope="col" class="px-2 py-2 uppercase tracking-wider">
                                            Privilèges accordés
                                        </th>
                                        <th scope="col" class="px-2 py-2 uppercase tracking-wider">
                                            Approuvée le
                                        </th>
                                        <th scope="col" class="px-2 py-2 uppercase tracking-wider">
                                            Durée
                                        </th> 
                                        <th scope="col" class="px-2 py-2 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y text-gray-200 divide-gray-200">
                                    @foreach($my_assistings as $assistant_request)
                                        <tr wire:key="Liste-de-mes-assistants-{{$assistant_request->id}}" class="hover:bg-gray-50 transition-colors duration-150">
                                            <td class="px-2 py-2 whitespace-nowrap">
                                                <a class="hover:underline hover:underline-offset-4" href="{{ $assistant_request->school->to_profil_route() }}" class="ml-4">
                                                    <div class="">{{ $assistant_request->school->name }}</div>
                                                    <div class="text-sm text-amber-400">
                                                        {{ $assistant_request->school->simple_name }}
                                                    </div>
                                                    <div class="text-sm text-green-700 text-right font-semibold my-1.5">
                                                        @if($assistant_request->approved_at)
                                                            <small class="rounded-md bg-green-300 p-1">Vous avez approuvé cette demande</small>
                                                        @endif
                                                        
                                                    </div>
                                                </a>
                                            </td>
                                            <td class="px-2 py-2 whitespace-nowrap">
                                                @if($assistant_request->is_active)
                                                    <div class="flex flex-wrap gap-2">
                                                        @foreach ($assistant_request->privileges as $role)
                                                            <span class="p-1 border bg-gray-500 text-white hover:bg-gray-700 rounded-xl">{{ __translateRoleName($role) }}</span>
                                                        @endforeach
                                                    </div>
                                                @else
                                                <div class="flex flex-col text-center mx-auto bg-red-300 rounded-lg text-red-600 p-1.5 text-xs mt-1.5">
                                                    <span class="text-red-600 fas fa-user-lock"></span>
                                                    <span class="text-red-600 text-center">
                                                        Accès bloqué
                                                    </span>
                                                </div>
                                                @endif
                                            </td>
                                            <td class="px-2 py-2 whitespace-nowrap">
                                                <div class="flex flex-col text-center mx-auto">
                                                    @if($assistant_request->approved_at)
                                                    <span class="text-green-500">
                                                        {{ __formatDateTime($assistant_request->approved_at) }}
                                                    </span>
                                                    <span class="text-orange-300 text-center text-xs">
                                                        {{ __asAgo($assistant_request->created_at, $assistant_request->approved_at) }}
                                                    </span>
                                                    @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold text-center rounded-full bg-orange-300 text-black">
                                                        Pas encore
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="px-2 py-2 text-center whitespace-nowrap">
                                                <div class="flex flex-col text-center mx-auto">
                                                    @if($assistant_request->approved_at)
                                                    <span class="text-green-500">
                                                        {{ __formatDateTime($assistant_request->approved_at) }}
                                                    </span>
                                                    <span class="text-orange-300 text-center text-xs">
                                                        {{ __asAgo($assistant_request->created_at, $assistant_request->approved_at) }}
                                                    </span>
                                                    @else
                                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold text-center rounded-full bg-orange-300 text-black">
                                                        Pas encore
                                                    </span>
                                                    @endif
                                                </div>
                                            </td>
                                            
                                            <td class="px-2 py-2 whitespace-nowrap text-right text-sm font-medium">
                                                <div class="justify-center gap-x-1.5 flex">
                                                    <button wire:click='deleteRequest({{$assistant_request->id}})' class="block text-white cursor-pointer bg-red-500 focus:ring-1 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-red-700 focus:ring-red-800" type="button">
                                                        <span wire:loading.remove wire:target='deleteRequest({{$assistant_request->id}})'>
                                                            <span class="fas fa-trash mr-1"></span>
                                                            Suppr.
                                                        </span>
                                                        <span wire:loading wire:target='deleteRequest({{$assistant_request->id}})'>
                                                            <span class="fas fa-rotate animate-spin"></span>
                                                        </span>
                                                    </button>
                                                    @if(!$assistant_request->approved_at)
                                                    <a href="{{$assistant_request->to_assistant_request_route()}}" class="block text-white cursor-pointer bg-blue-600 focus:ring-1 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-blue-800 focus:ring-blue-800" type="button">
                                                        Valider
                                                    </a>
                                                    @endif
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

