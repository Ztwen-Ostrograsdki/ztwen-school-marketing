<div class="p-6 w-full mx-auto z-bg-secondary-light-opac shadow-2 shadow-sky-500 mt-10">
    <style>
      tr{
			border: thin solid white !important;
      }

      tr:nth-child(odd) {
        
      }

      tr:nth-child(even) {
      background: #141b32;
      }
      

      table {
        border-collapse: collapse;
      }

      th, td{
        border: thin solid rgb(177, 167, 167);
      }
    </style>
    <div class="mb-6">
        <div class="flex items-center justify-between flex-col gap-x-2 mb-6  text-xs md:text-lg">
            <h2 class="sm:text-sm w-full gap-x-3  font-semibold flex justify-between letter-spacing-1 uppercase text-sky-500">
                <span>
                    Gestion : Profil pack
                    <span class="text-yellow-500">
                        {{ ($pack->name) }}
                    </span>
                </span>
                
                <span class="text-yellow-500">
                    {{ numberZeroFormattor(count($pack->privileges)) }} privilèges accordés à ce pack
                </span>
            </h2>
            <div class="flex justify-between gap-x-2 w-full mt-2 lg:text-base md:text-lg sm:text-xs xs:text-xs">
                <div class="">
                    <a href="{{ route('admin.packs.list') }}" class="bg-gray-500 text-black px-4 py-2 rounded-lg hover:bg-gray-600 hover:text-gray-300 transition cursor-pointer"
                    >
                        <span>
                            <span class="fas fa-chevron-left mr-2.5"></span>
                            <span>Retour</span>
                        </span>
                    </a>
                </div>
                <div class="flex justify-end gap-x-1.5">
                    <button type="button" class="collapse-toggle text-white cursor-pointer border rounded-md bg-sky-600 hover:bg-indigo-800 flex gap-x-2 py-2 px-4" data-drawer-target="drawer-admin-navigation" data-drawer-show="drawer-admin-navigation" aria-controls="drawer-admin-navigation">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                        <span>Ouvrir le menu</span>
                    </button>
                    
                    <div class="flex items-center gap-x-1.5">
                        <a href="{{ $pack->to_pack_edition_route() }}" class="bg-indigo-400 text-black px-4 py-2 rounded-lg hover:bg-indigo-700 hover:text-gray-300 transition cursor-pointer"
                        >
                            <span>
                                <span class="fas fa-pen"></span>
                                <span>Editer</span>
                            </span>
                        </a>
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
                </div>
            </div>

        </div>
        <hr class="border-sky-600 mb-2">
    </div>

  <!-- Tableau des paiements -->
  <div class=" rounded-lg shadow  z-bg-secondary-light p-3">
    @if ($pack)
        <div class="mt-4 p-3 mx-auto text-xs md:text-lg overflow-x-auto">
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-yellow-600 uppercase border border-yellow-500 bg-black/60 my-2">
                Liste des écoles abonnées et leurs privilèges
                <span class="font-semibold letter-spacing-1 ml-2 text-yellow-500"> ({{ numberZeroFormattor(count($pack->schools())) }}) </span>
            </h6>
            @if(count($pack->schools()) > 0)
            <div class="overflow-x-auto my-5">
                <table class="min-w-full divide-y text-xs sm:text-sm letter-spacing-1 divide-gray-200 ">
                    <thead class="bg-black/50 text-sky-500 ">
                        <tr>
                            <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                #N°
                            </th>
                            <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                Ecole
                            </th>
                            <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                abonnés au pack {{ ($pack->name) }} depuis
                            </th>
                            <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-gray-200 divide-gray-200">
                        @foreach ($pack->users() as $user)
                        <tr wire:key='list-des-utilisateurs-abonnes-{{getRand(2999, 8888888)}}-de-ce-role' class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="">{{ numberZeroFormattor($loop->iteration) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                <div class="h-10 w-10 flex-shrink-0">
                                    <img class="h-10 w-10 rounded-full object-cover border-sky-500 border" src="{{ user_profil_photo($user) }}" alt="Photo de profil de {{ $user->getFullName() }}">
                                </div>
                                <div class="ml-4">
                                    <span class="flex gap-x-2 items-center">
                                        <a title="Charger le profil de {{$user->getFullName()}}" class="" href="{{ $user->to_profil_route() }}">
                                            {{$user->getFullName()}} 
                                        </a>
                                    </span>
                                    <div class="text-sm text-gray-500">
                                        {{ $user->email }}
                                    </div>
                                </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @php
                                    $user_role = $user->userRoles()->where('role_id', $pack->id)->first();
                                @endphp
                                {{ $user_role ? __formatDateTime($user_role->created_at) : 'Date non renseignée' }}

                                @if($user_role)
                                <span class="text-yellow-600 text-xs ml-3">
                                    ( {{ $user_role->created_at->diffForHumans() }} ) 
                                </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <span wire:click="removeUserFromRole({{$user->id}})" class="flex hover:bg-red-700 text-gray-300 border rounded-md bg-red-600 gap-x-3 w-full justify-center items-center">
                                    <span class=" px-2 py-1" title="Retirer lz rôle {{ $pack->name }} à {{$user->getFullName()}}">
                                        <span wire:target="removeUserFromRole({{$user->id}})" wire:loading.remove>
                                            <span class="fas fa-trash"></span>
                                            <span class="hidden lg:inline">Retirer le rôle</span>
                                        </span>
                                        <span wire:target="removeUserFromRole({{$user->id}})" wire:loading>
                                            <span>Traitement en cours...</span>
                                            <span class="fas fa-rotate animate-spin"></span>
                                        </span>
                                    </span>
                                </span>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            @else
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-sky-500">
                Aucun utilisateurs abonnés au pack
                <span class="text-yellow-500">
                    {{ ($pack->name) }}
                </span>
            </h6>
            @endif
        </div>

        <div class="p-3 mx-auto my-4 mt-6">
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-yellow-600 uppercase border border-yellow-500 bg-black/60  my-2">
                Liste des privilèges liés au pack

                <span class="font-semibold letter-spacing-1 ml-2 text-yellow-300"> ({{ numberZeroFormattor(count($pack->privileges)) }}) </span>
            </h6>
            @if(count($pack->privileges) > 0)
                <table class="min-w-full divide-y divide-gray-200 text-sm border">
                    
                    <thead class="bg-gray-900 text-gray-300 font-semibold">
                        <tr>
                            <th class="px-3 py-4 text-center">#N°</th>
                            <th class="px-3 py-4 text-left">Privilèges</th>
                            <th class="px-3 py-4 text-center">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="payments-tbody">
                        @foreach ($pack->privileges as $permission)
                            <tr wire:key='list-des-privileges-pack-{{getRand(2999, 8888888)}}-de-ce-role'>
                                <td class="px-2 py-2 text-gray-400 text-center">
                                    {{ numberZeroFormattor($loop->iteration) }}
                                </td>
                                <td class="px-2 py-2 text-gray-300 font-medium">
                                    {{ __translatePermissionName($permission) }}
                                <td class="px-2 py-2 text-center text-gray-400 font-semibold">
                                    
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <h6 class="text-center py-2 letter-spacing-1 font-semibold text-sky-500">
                    Aucun privilèges liés à ce rôle 
                    <span class="text-yellow-500">
                        {{ $pack->name }}
                    </span>
                </h6>
            @endif
        </div>
    @endif
  </div>
</div>




