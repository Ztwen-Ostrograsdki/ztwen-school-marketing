<div class="p-6 w-full mx-auto z-bg-secondary-light-opac shadow-2 mt-10 shadow-sky-500">
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
        <div class="flex items-center justify-between flex-col gap-x-2 mb-6 lg:text-lg md:text-lg sm:text-xs xs:text-xs">
            <h2 class="text-sm md:text-lg w-full flex gap-x-3  font-semibold letter-spacing-1 uppercase text-sky-500">Les roles administrateurs
            </h2>
            <div class="flex justify-end gap-x-2 w-full mt-2 lg:text-base md:text-lg sm:text-xs xs:text-xs">
                <button type="button" class="collapse-toggle text-white cursor-pointer border rounded-md bg-sky-600 hover:bg-indigo-800 flex gap-x-2 py-2 px-4" data-drawer-target="drawer-admin-navigation" data-drawer-show="drawer-admin-navigation" aria-controls="drawer-admin-navigation">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span>Ouvrir le menu</span>
                </button>
                <button
                    wire:click="toggleSelectionsCases"
                    class="bg-zinc-600 text-white px-4 py-2 rounded-lg hover:bg-zinc-700 hover:text-gray-500 transition"
                >
                    <span wire:loading.remove wire:target='toggleSelectionsCases'>
                        <span class="fas fa-check"></span>
                        <span>De/Cocher</span>
                    </span>
                    <span wire:target='toggleSelectionsCases' wire:loading>
                        <span class="fas fa-rotate animate-spin"></span>
                    </span>
                </button>
                <div class="items-center hidden">
                    <button
                        wire:click="addNewSpatieRole"
                        class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 hover:text-gray-900 transition cursor-pointer"
                    >
                        <span wire:loading.remove wire:target='addNewSpatieRole'>
                            <span class="fas fa-plus"></span>
                            <span>Ajouter un nouveau rôle</span>
                        </span>
                        <span wire:target='addNewSpatieRole' wire:loading>
                            <span>Chargement en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                </div>
                <div class="flex gap-x-2 items-center">
                    <button
                        wire:click="printRolesDetails"
                        class="bg-purple-600 text-white px-4 py-2 rounded-lg hover:bg-purple-700 hover:text-gray-900 transition cursor-pointer"
                    >
                        <span wire:loading.remove wire:target='printRolesDetails'>
                            <span>Imprimer</span>
                            <span class="fas fa-print"></span>
                        </span>
                        <span wire:target='printRolesDetails' wire:loading>
                            <span>Impression en cours...</span>
                            <span class="fas fa-rotate animate-spin"></span>
                        </span>
                    </button>
                    @if(__isMaster())
                        @if($selected_roles AND count($selected_roles) > 0)
                            <button
                                wire:click="deleteRoles"
                                class="bg-red-600 text-white px-4 py-2 rounded-lg hover:bg-red-700 hover:text-gray-900 transition cursor-pointer"
                            >
                                <span wire:loading.remove wire:target='deleteRoles'>
                                    <span>Supprimer les rôles en masse</span>
                                    <span class="fas fa-trash"></span>
                                </span>
                                <span wire:target='deleteRoles' wire:loading>
                                    <span>Suppression en cours...</span>
                                    <span class="fas fa-rotate animate-spin"></span>
                                </span>
                            </button>
                        @endif
                    @endif
                </div>
            </div>
            <div class="w-full">
                
                <h2 class="text-sm md:text-lg mx-0  font-semibold letter-spacing-1 uppercase text-yellow-500 text-right my-2 underline underline-offset-2">
                    <span class="">
                        {{ numberZeroFormattor(count($roles)) }} rôles disponibles
                    </span>
                </h2>
            </div>
        </div>
        <hr class="border-sky-600 mb-2">
        
    </div>

  <!-- Tableau des paiements -->
  <div class="overflow-x-auto shadow border border-sky-700 z-bg-secondary-light">
    @if (count($roles) > 0)
        @if($selected_roles AND count($selected_roles) > 0)
            <h6 class="w-full text-zinc-400 text-right font-semibold letter-spacing-2 p-2">
                <span class="text-yellow-400">
                    {{ numberZeroFormattor(count($selected_roles)) }}
                </span> roles admins sélectionnés
            </h6>
        @endif
        <table class="min-w-full divide-y divide-gray-200 text-sm overflow-x-scroll">
        <thead class="bg-gray-900 text-cyan-400 font-semibold">
            <tr>
                <th class="px-3 py-4 text-center">#N°</th>
                <th class="px-3 py-4 text-left">Rôles</th>
                <th class="px-3 py-4 text-center">Permissions ou privilèges accordés au rôle</th>
                @if(__isMaster() && !$display_select_cases)
                    <th class="px-3 py-4 text-center">Actions</th>
                @endif
                @if($display_select_cases)
                    <th class="px-3 py-4 text-center">
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
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-100" id="payments-tbody">
            @foreach ($roles as $role)
                @php
                    $permissions = $role->permissions;
                @endphp
                    <tr wire:key='list-des-roles-administrations-{{getRand(2999, 8888888)}}'>
                        <td class="px-2 py-2 text-gray-400 text-center @if(in_array($role->id, $selected_roles)) bg-green-500 text-gray-900 border-gray-900 border @endif ">
                            {{ numberZeroFormattor($loop->iteration) }}
                        </td>
                        <td class="px-2 py-2 text-gray-300 font-medium text-center">
                            <a class="block" href="{{route('admin.role.profil', ['role_id' => $role->id])}}">
                                {{ __translateRoleName($role->name) }}
                            </a>
                            <span class="text-yellow-400 text-xs rounded-lg p-2 bg block">
                                <span>{{ numberZeroFormattor(count($permissions)) }}</span>
                                <span>permission(s) accordée(s)</span>
                            </span>
                        </td>
                        <td class="px-2 py-2 text-green-600">
                        <span class="flex flex-wrap gap-2">
                            @foreach ($permissions as $permission)
                                <span class="border border-gray-400 px-2 py-1 cursor-pointer bg-gray-800 hover:bg-gray-900 text-gray-400 hover:text-gray-100 text-xs"> 
                                    <span>
                                        <span>{{ __translatePermissionName($permission->name) }}</span>
                                    </span>
                                </span>
                            @endforeach
                        </span>
                        </td>
                        @if(__isMaster())
                            @if(!$display_select_cases)
                            <td class="px-2 py-2 text-center">
                                <span class="flex gap-x-3 w-full justify-center items-center">
                                    <span wire:click="deleteRole({{$role->id}})" class="hover:bg-red-500 text-gray-300 border rounded-md bg-red-600 px-2 py-1" title="Supprimer le rôle {{ __translateRoleName($role->name) }}">
                                        <span wire:target="deleteRole({{$role->id}})" wire:loading.remove>
                                            <span class="fas fa-trash"></span>
                                            <span class="hidden lg:inline">Suppr.</span>
                                        </span>
                                        <span wire:target="deleteRole({{$role->id}})" wire:loading>
                                            <span class="fas fa-rotate animate-spin"></span>
                                            <span>Suppression en cours...</span>
                                        </span>
                                    </span>
                                </span>
                            </td>
                            @endif
                        @endif
                        @if($display_select_cases)
                        <td>
                            <span wire:click="pushOrRetrieveFromSelectedRoles({{$role->id}})" class="w-full mx-auto text-center font-bold inline-block cursor-pointer">
                                <span wire:loading.remove wire:target="pushOrRetrieveFromSelectedRoles({{$role->id}})">
                                    @if(in_array($role->id, $selected_roles))
                                        <span class="fas fa-user-check text-green-600"></span>
                                    @else
                                        <span class="text-xs text-zinc-500">Cliquer pour ajouter</span>
                                    @endif
                                </span>
                                <span wire:loading wire:target="pushOrRetrieveFromSelectedRoles({{$role->id}})">
                                    <span class="fas fa-rotate animate-spin"></span>
                                </span>
                            </span>
                        </td>
                        @endif
                    </tr>
                @endforeach
            <!-- Lignes dynamiques -->
        </tbody>
        </table>
    @else
        <div class="w-full text-center py-4 border-none bg-red-300 text-red-600 text-base">
            <span class="fas fa-trash"></span>
            <span>Oupps aucune données trouvées!!!</span>
        </div>
    @endif
  </div>

  <!-- Modal Ajouter / Éditer -->
  
</div>




