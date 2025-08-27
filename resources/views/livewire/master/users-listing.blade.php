<div class="w-full py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" x-data="{ show: false, currentImage: '', userName: '', email: '' }">
    
    <div class="mt-10">
        <div>
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-yellow-600 uppercase border border-yellow-500 bg-black/60 my-2">
                Administration : Liste des utilisateurs de la plateforme
                <span class="font-semibold letter-spacing-1 ml-2 text-yellow-500"> ({{ numberZeroFormattor(count($users)) }}) </span>
            </h6>
        </div>
        <div class="flex justify-end my-2 bg-black/60 p-2 border-amber-500 border">
            <div class="flex justify-end gap-x-2 w-full text-xs">
                <button
                    wire:click="toggleSelectionsCases"
                    class="bg-zinc-600 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 hover:text-gray-500 transition cursor-pointer"
                >
                    <span wire:loading.remove wire:target='toggleSelectionsCases'>
                        <span class="fas fa-check"></span>
                        <span>De/Cocher</span>
                    </span>
                    <span wire:target='toggleSelectionsCases' wire:loading>
                        <span class="fas fa-rotate animate-spin"></span>
                    </span>
                </button>
                @if(!empty($selected_users))
                    <button
                        wire:click="unlockSelectedsUsersAccount"
                        class="bg-purple-400 text-gray-700 px-4 py-2 rounded-lg hover:bg-purple-700 hover:text-gray-900 transition cursor-pointer"
                    >
                        <span wire:loading.remove wire:target='unlockSelectedsUsersAccount'>
                            <span class="fas fa-unlock-keyhole"></span>
                            <span>Débloquer les comptes sélectionnés</span>
                        </span>
                        <span wire:target='unlockSelectedsUsersAccount' wire:loading>
                            <span>Déblocage en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                    <button
                        wire:click="blockSelectedsUsersAccount"
                        class="bg-orange-600 text-white px-4 py-2 rounded-lg hover:bg-orange-700 hover:text-gray-900 transition cursor-pointer"
                    >
                        <span wire:loading.remove wire:target='blockSelectedsUsersAccount'>
                            <span class="fas fa-user-lock"></span>
                            <span>Bloquer les comptes sélectionnés</span>
                        </span>
                        <span wire:target='blockSelectedsUsersAccount' wire:loading>
                            <span>Blocage en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                    <button
                        wire:click="removeAllAssignments"
                        class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 hover:text-gray-900 transition cursor-pointer"
                    >
                        <span wire:loading.remove wire:target='removeAllAssignments'>
                            <span class="fas fa-trash"></span>
                            <span>Supprimer toutes les attributions</span>
                        </span>
                        <span wire:target='removeAllAssignments' wire:loading>
                            <span>Suppression en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>

                    
                @else
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
                @endif
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
                @if($selected_users AND count($selected_users) > 0)
                    <h6 class="w-full text-indigo-400 text-right font-semibold letter-spacing-2 p-2 text-sm ">
                        <span class="text-yellow-500">
                            {{ numberZeroFormattor(count($selected_users)) }}
                        </span> utilisateurs sélectionnés
                    </h6>
                @endif
                <div class="container w-full">
                    <div class="overflow-hidden">
                <!-- Table Header -->
                        <div class="relative py-2">
                            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                                <div class="text-amber-500/65 font-semibold letter-spacing-1">
                                    <h2 class=" sm:text-xl font-bold uppercase text-shadow shadow-amber-400">La liste des utilisateurs</h2>
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
                            <div class="sm:col-span-2">
                                <select wire:model.live='section' class="border border-sky-500 rounded-lg px-4 py-2  w-full bg-transparent">
                                    @foreach ($sections as $k => $sec)
                                        <option class="bg-black/90 text-sky-700" value="{{$k}}">{{ $sec }}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Table -->
                    <div class="overflow-x-auto my-5">
                        @if(count($users))
                        <table class="min-w-full divide-y text-xs sm: letter-spacing-1 divide-gray-200 border">
                            <thead class="bg-black/50 text-sky-500 ">
                                <tr>
                                    @if(__isMaster() && !$display_select_cases)
                                    <th scope="col" class="px-2 py-4 uppercase tracking-wider text-left">
                                        #N°
                                    </th>
                                    @else
                                    <th scope="col" class="px-2 py-4 uppercase tracking-wider">
                                        <button
                                            wire:click="toggleSelectAll"
                                            class="bg-zinc-600 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 hover:text-gray-500 transition"
                                            >
                                            <span wire:loading.remove wire:target='toggleSelectAll'>
                                                <span class="fas fa-check-double"></span>
                                                <span>Tout dé/cocher</span>
                                            </span>
                                            <span wire:target='toggleSelectAll' wire:loading>
                                                <span class="fas fa-rotate animate-spin"></span>
                                            </span>
                                        </button>
                                    </th>
                                    @endif
                                    <th scope="col" class="px-2 py-4 uppercase tracking-wider text-left">
                                        Utilisateurs
                                    </th>
                                    <th scope="col" class="px-2 py-4 uppercase tracking-wider text-left">
                                        Contacts
                                    </th>
                                    <th scope="col" class="px-2 py-4 uppercase tracking-wider">
                                        Addresse
                                    </th>
                                    <th scope="col" class="px-2 py-4 uppercase tracking-wider">
                                        Roles
                                    </th>
                                    <th scope="col" class="px-2 py-4 uppercase tracking-wider">
                                        Ecoles
                                    </th>
                                    <th scope="col" class="px-2 py-4 uppercase tracking-wider">
                                        Abonnements
                                    </th>
                                    @if(__isMaster() && !$display_select_cases)
                                        <th scope="col" class="px-2 py-4 uppercase tracking-wider">
                                            Actions
                                        </th>
                                    @endif
                                </tr>
                            </thead>
                            <tbody class="divide-y text-xs md:text-sm text-gray-200 divide-gray-200">
                                @foreach($users as $user)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150" @if(in_array($user->id, $selected_users)) style="background: #19191a !important; text-color: gray; opacity: 0.5;" @endif>
                                        @if($display_select_cases && !$user->isMaster())
                                        <td class="px-2 py-2 whitespace-nowrap text-right  font-medium">
                                            <span wire:click="pushOrRetrieveFromSelectedUsers({{$user->id}})" class="w-full mx-auto text-center font-bold inline-block cursor-pointer">
                                                <span wire:loading.remove wire:target="pushOrRetrieveFromSelectedUsers({{$user->id}})">
                                                    @if(in_array($user->id, $selected_users))
                                                        <span class="fas fa-user-check text-green-600"></span>
                                                    @else
                                                        <span class="text-xs text-zinc-500">Cliquer pour ajouter</span>
                                                    @endif
                                                </span>
                                                <span wire:loading wire:target="pushOrRetrieveFromSelectedUsers({{$user->id}})">
                                                    <span class="fas fa-rotate animate-spin"></span>
                                                </span>
                                            </span>
                                        </td>
                                        @else
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ __zero($loop->iteration) }}
                                            </div>
                                        </td>
                                        @endif
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="flex items-center gap-x-1.5">
                                                <div class="h-10 w-10 flex-shrink-0">
                                                    <img @click="currentImage = '{{ user_profil_photo($user) }}'; userName = '{{ $user->getFullName() }}'; email = '{{ $user->email }}'; show = true" class="h-10 w-10 rounded-full object-cover border-sky-500 border" src="{{ user_profil_photo($user) }}" alt="">
                                                </div>
                                                <a class="hover:underline block hover:underline-offset-2" href="{{$user->to_profil_route()}}" class="ml-4">
                                                    <div class="">
                                                        {{ $user->getFullName() }}
                                                        @if($user->blocked)
                                                        <span title="Le compte de {{$user->getFullName() }} a été bloqué depuis le {{__formatDateTime($user->blocked_at)}}" class="fas fa-lock text-red-500 font-semibold mx-1 ml-1.5"></span>
                                                        @endif
                                                    </div>
                                                    <div class=" text-amber-500">
                                                        {{ $user->email }}
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="text-xs mt-2 mb-1 font-semibold text-right">
                                                @if($user->emailVerified())
                                                    <small class="text-green-800 border p-1 bg-green-300 rounded-md">Compte vérifié le {{ __formatDate($user->email_verified_at) }}</small>
                                                @else
                                                    <small class="text-red-700 border p-1 bg-red-300 rounded-md">Email non vérifié</small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ $user->contacts }}
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ $user->address }}
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($user->roles as $role)
                                                    <small class="p-1 border bg-gray-500 text-white hover:bg-gray-700 rounded-md">{{ __translateRoleName($role->name) }}</small>
                                                @endforeach
                                            </div>
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap">
                                            @if(count($user->schools))
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($user->schools as $school)
                                                    <a href="{{ $school->to_profil_route() }}" class="p-1 border bg-gray-500 text-white hover:bg-gray-700 rounded-md">{{ $school->name }}</a>
                                                @endforeach
                                            </div>
                                            @else
                                            <span class="px-2 flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-600 text-center items-center justify-center mx-auto">
                                                Aucune donnée
                                            </span>
                                            @endif
                                        </td>
                                        <td class="px-2 py-2 whitespace-nowrap text-center">
                                            @if($user->schools)
                                                @if($user->current_subscription())
                                                    <a href="{{ $user->current_subscription()->to_details_route() }}" class="px-2 inline-flex text-xs leading-5 font-semibold rounded-md bg-green-100 text-green-800 flex-col hover:underline hover:underline-offset-2">
                                                      Actif ({{ $user->current_subscription()->ref_key }} )
                                                      <span>Jusqu'au {{__formatDate($user->current_subscription()->will_closed_at) }}</span>
                                                    </a>
                                                @else
                                                    <span class="px-2 flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-600 text-center items-center justify-center mx-auto">
                                                        Aucun abonnement actif
                                                    </span>
                                                @endif
                                            @else
                                                <span class="px-2 flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-600 text-center items-center justify-center mx-auto">
                                                    Aucune donnée
                                                </span>
                                            @endif
                                        </td>
                                        @if(!$display_select_cases)
                                        <td class="px-2 py-2 whitespace-nowrap text-right  font-medium">
                                            <div class="flex gap-x-1.5">
                                                @if(!$user->confirmeds())
                                                <button wire:click='confirmUserEmail({{$user->id}})' class="block text-white cursor-pointer bg-green-400 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-green-600 focus:ring-green-800" type="button">
                                                    <span wire:loading.remove wire:target='confirmUserEmail({{$user->id}})'>
                                                        <span class=" fas fa-user-check"></span>
                                                        <span>Email</span>
                                                    </span>
                                                    <span wire:loading wire:target='confirmUserEmail({{$user->id}})'>
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @endif
                                                <button wire:click='deleteAccount({{$user->id}})' class="block text-white cursor-pointer bg-red-600 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-red-800 focus:ring-red-800" type="button">
                                                    <span wire:loading.remove wire:target='deleteAccount({{$user->id}})'>
                                                        <span class="fas fa-trash mr-1"></span>
                                                        Suppr.
                                                    </span>
                                                    <span wire:loading wire:target='deleteAccount({{$user->id}})'>
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @if(!$user->blocked)
                                                <button wire:click='blockUserAccount({{$user->id}})' class="block text-white cursor-pointer bg-yellow-500 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-700 focus:ring-yellow-800" type="button">
                                                    <span wire:loading.remove wire:target='blockUserAccount({{$user->id}})'>
                                                        <span class="fas fa-user-lock mr-1"></span>
                                                        Bloquer
                                                    </span>
                                                    <span wire:loading wire:target='blockUserAccount({{$user->id}})'>
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @else
                                                <button wire:click='unlockUserAccount({{$user->id}})' class="block text-white cursor-pointer bg-green-500 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-green-700 focus:ring-green-800" type="button">
                                                    <span wire:loading.remove wire:target='unlockUserAccount({{$user->id}})'>
                                                        <span class="fas fa-user-unlock mr-1"></span>
                                                        Debloquer
                                                    </span>
                                                    <span wire:loading wire:target='unlockUserAccount({{$user->id}})'>
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @endif
                                            </div>  
                                        </td>
                                        @endif
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

