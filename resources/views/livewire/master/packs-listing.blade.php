<div class="w-full max-w-[85rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" x-data="{ show: false, currentImage: '', userName: '', email: '' }">
    
    <div class="mt-10">
        <div>
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-yellow-600 uppercase border border-yellow-500 bg-black/60 my-2">
                Administration : Liste des packs disponibles
                <span class="font-semibold letter-spacing-1 ml-2 text-yellow-500"> ({{ numberZeroFormattor(count($packs)) }}) </span>
            </h6>
        </div>
        <div class="flex justify-end my-2 bg-black/60 p-2 border-amber-500 border">
            <div class="flex justify-end gap-x-2 w-full text-xs">
                
                <button
                    wire:click="unlockAllUsersAccount"
                    class="bg-purple-400 text-gray-800 px-4 py-2 rounded-lg hover:bg-purple-700 hover:text-gray-900 transition cursor-pointer"
                >
                    <span wire:loading.remove wire:target='unlockAllUsersAccount'>
                        <span class="fas fa-unlock-keyhole"></span>
                        <span>Débloquer tous les comptes</span>
                    </span>
                    <span wire:target='unlockAllUsersAccount' wire:loading>
                        <span>Déblocage en cours...</span>
                        <span class="fas fa-rotate animate-spin"></span>
                    </span>
                </button>
                <button
                    wire:click="blockAllUsersAccount"
                    class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 hover:text-gray-900 transition cursor-pointer"
                >
                    <span wire:loading.remove wire:target='blockAllUsersAccount'>
                        <span class="fas fa-user-lock"></span>
                        <span>Bloquer tous les comptes</span>
                    </span>
                    <span wire:target='blockAllUsersAccount' wire:loading>
                        <span>Blocage en cours...</span>
                        <span class="fas fa-rotate animate-spin"></span>
                    </span>
                </button>
                <button
                    wire:click="mailMessageToAdmins"
                    class="bg-green-600 text-white px-4 py-2 rounded-lg hover:bg-green-800 hover:text-gray-900 transition cursor-pointer">
                    <span wire:loading.remove wire:target='mailMessageToAdmins'>
                        <span>Envoyez un message aux admins</span>
                        <span class="fas fa-paper-plane"></span>
                    </span>
                    <span wire:target='mailMessageToAdmins' wire:loading>
                        <span>Envoie en cours...</span>
                        <span class="fas fa-rotate animate-spin"></span>
                    </span>
                </button>
                <button type="button" class="collapse-toggle text-white cursor-pointer border rounded-md bg-sky-600 hover:bg-indigo-800 gap-x-2 flex items-center px-4" data-drawer-target="drawer-admin-navigation" data-drawer-show="drawer-admin-navigation" aria-controls="drawer-admin-navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span>Ouvrir le menu</span>
                </button>
            </div>
        </div>
        <div class="w-full bg-transparent pt-12">
            <div class="w-full bg-black/60 shadow-2xl border border-sky-500 shadow-gray-900 flex flex-col items-center justify-center min-h-full py-5 px-5">
                
                <div class="container max-w-6xl">
                    <div class="overflow-hidden">
                <!-- Table Header -->
                        <div class="relative py-2">
                            <div class="flex md:justify-between">
                                <div class="text-amber-500/65 font-semibold letter-spacing-1">
                                    <h2 class=" sm:text-xl font-bold uppercase text-shadow shadow-amber-400">La liste des packs</h2>
                                </div>
                                <div>
                                    <a class="bg-blue-500 p-2 text-white hover:bg-blue-800 rounded-md" href="{{route('create.pack', ['token' => config('app.my_token')])}}">
                                        <span class="fas fa-plus"></span>
                                        Ajouter un pack
                                    </a>
                                </div>
                                
                            </div>
                            <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                        </div>
                        <div class="mt-6 grid sm:grid-cols-5 gap-4">
                            <div class="relative flex-grow  sm:col-span-3">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input wire:model.live='search' type="text" class="pl-10 pr-4 py-2 border border-sky-600 bg-transparent rounded-lg w-full " placeholder="Recherche un utilisateur...">
                            </div>
                            
                        </div>
                    </div>
                    
                    <!-- Table -->
                    <div class="overflow-x-auto my-5">
                        @if(count($packs))
                        <table class="min-w-full divide-y text-xs sm: letter-spacing-1 divide-gray-200 border">
                            <thead class="bg-black/50 text-sky-500 ">
                                <tr>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        #N°
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        Pack
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        Prix
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        Reduction
                                    </th><th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        Images
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Stats
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Infos
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Assistants
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Privilèges
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Ecoles abonnées
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Par mail
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Par SMS
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y text-xs md:text-sm text-gray-200 divide-gray-200">
                                @foreach($packs as $pack)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150" >
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ __zero($loop->iteration) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex items-center gap-x-1.5">
                                                <a class="hover:underline hover:underline-offset-2" href="{{$pack->to_admin_pack_profil_route()}}" class="ml-4">
                                                    <div class="flex flex-col">
                                                        {{ $pack->name }}
                                                        @if(!$pack->is_active)
                                                        <small class="text-red-500 font-semibold mx-1 ml-1.5">
                                                            <span class="fas fa-lock"></span>
                                                            <small>Ce pack n'est pas actif</small>
                                                        </small>
                                                        @endif
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="text-xs mt-2 mb-1 font-semibold text-right">
                                                @if($pack->promoting)
                                                    <small class="text-green-800 border p-1 bg-green-300 rounded-md">En promo</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ $pack->price }} FCFA
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ $pack->discount }} %
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ __zero($pack->max_images) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ __zero($pack->max_infos) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ __zero($pack->max_stats) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ __zero($pack->max_assistants) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($pack->privileges as $privilege)
                                                    <small class="p-1 border bg-gray-500 text-white hover:bg-gray-700 rounded-md">{{ $privilege }}</small>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            @if(count($pack->schools()))
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($pack->schools() as $school)
                                                    <a href="{{ $school->to_profil_route() }}" class="p-1 border bg-gray-500 text-white hover:bg-gray-700 rounded-md">{{ $school->name }}</a>
                                                @endforeach
                                            </div>
                                            @else
                                            <span class="px-2 flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-600 text-center items-center justify-center mx-auto">
                                                Aucune donnée
                                            </span>
                                            @endif
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($pack->notify_by_email) bg-green-100 text-green-800 @else bg-red-200 text-red-600 @endif">
                                             {{ $pack->notify_by_email ? "Disponible" : "Indisponible" }}
                                            </span>
                                        </td>
                                         <td class="px-6 py-2 whitespace-nowrap text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($pack->notify_by_sms) bg-green-100 text-green-800 @else bg-red-200 text-red-600 @endif">
                                             {{ $pack->notify_by_sms ? "Disponible" : "Indisponible" }}
                                            </span>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-right  font-medium">
                                            <div class="flex gap-x-1.5">
                                                
                                                <button wire:click='deletePack({{$pack->id}})' class="block text-white cursor-pointer bg-red-600 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-red-800 focus:ring-red-800" type="button">
                                                    <span wire:loading.remove wire:target='deletePack({{$pack->id}})'>
                                                        <span class="fas fa-trash mr-1"></span>
                                                        Suppr.
                                                    </span>
                                                    <span wire:loading wire:target='deletePack({{$pack->id}})'>
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @if($pack->is_active)
                                                <button wire:click='hidePack({{$pack->id}})' class="block text-white cursor-pointer bg-yellow-500 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-700 focus:ring-yellow-800" type="button">
                                                    <span wire:loading.remove wire:target='hidePack({{$pack->id}})'>
                                                        <span class="fas fa-eye-slash mr-1"></span>
                                                        Masquer
                                                    </span>
                                                    <span wire:loading wire:target='hidePack({{$pack->id}})'>
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @else
                                                <button wire:click='unHidePack({{$pack->id}})' class="block text-white cursor-pointer bg-green-500 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-green-700 focus:ring-green-800" type="button">
                                                    <span wire:loading.remove wire:target='unHidePack({{$pack->id}})'>
                                                        <span class="fas fa-eye mr-1"></span>
                                                        Réafficher
                                                    </span>
                                                    <span wire:loading wire:target='unHidePack({{$pack->id}})'>
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @endif
                                                <button wire:click='loadPackDataFromConfig({{$pack->id}})' class="block text-white cursor-pointer bg-yellow-400 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-700 focus:ring-yellow-800" type="button">
                                                    <span wire:loading.remove wire:target='loadPackDataFromConfig({{$pack->id}})'>
                                                        <span class="fas fa-recycle mr-1"></span>
                                                        Recharger
                                                    </span>
                                                    <span wire:loading wire:target='loadPackDataFromConfig({{$pack->id}})'>
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
                        @else
                        <h6 class="text-center py-2 letter-spacing-1 font-semibold text-red-600 uppercase border border-red-500 bg-black/40 my-2">
                            Aucune donnée trouvée
                            @if($search && strlen($search) > 3)
                                pour le terme 
                                <span class="font-semibold letter-spacing-1 ml-2 underline underline-offset-4 text-yellow-500"> {{ $search }} </span>
                            @endif
                        </h6>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        class="fixed inset-0 bg-black/85 flex flex-col items-center justify-center z-50"
        style="display: none;"
        @click="show = false"
    >
        <h5 class="mx-auto flex flex-col gap-y-1 text-lg w-auto text-center py-3 font-semibold letter-spacing-1 bg-gray-950 my-3" >
            <span class=" text-sky-500 uppercase" x-text="userName"></span>
            <span class=" text-yellow-500" x-text="email"></span>
        </h5>
        <img :src="currentImage" alt="Zoom" class="w-screen md:max-w-xl max-h-[90vh] rounded shadow-xl border-2 border-white" @click.stop>
    </div>
    
</div>

