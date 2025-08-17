<div class="p-6 w-full mx-auto z-bg-secondary-light-opac shadow-2 shadow-sky-500 mt-10" x-data="{ show: false, currentImage: '', userName: '', email: '' }">
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
                    {{ __zero(count($pack->privileges)) }} privilèges accordés à ce pack
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
                            <th scope="col" class="px-2 py-4 uppercase tracking-wider text-left">
                                #N°
                            </th>
                            <th scope="col" class="px-2 py-4 uppercase tracking-wider">
                                Abonné
                            </th>
                            <th scope="col" class="px-2 py-4 uppercase tracking-wider">
                                Dates
                            </th>
                            <th scope="col" class="px-2 py-4 uppercase tracking-wider">
                                Détails payement
                            </th>
                            <th scope="col" class="px-2 py-4 uppercase tracking-wider">
                                Détails
                            </th>
                            <th scope="col" class="px-2 py-4 uppercase tracking-wider">
                                Détails Rest.
                            </th>
                            <th scope="col" class="px-2 py-4 uppercase tracking-wider">
                                Actions
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y text-gray-200 divide-gray-200">
                        @foreach ($pack->schools() as $school)
                            @php
                                $user = $school->user;

                                $subscription = $school->current_subscription();
                            @endphp
                        <tr wire:key='list-des-utilisateurs-abonnes-{{getRand(2999, 8888888)}}-de-ce-role' class="hover:bg-gray-50 transition-colors duration-150">
                            <td class="px-2 py-2 whitespace-nowrap">
                                <div class="">{{ numberZeroFormattor($loop->iteration) }}</div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap">
                                <div class="flex items-center hover:underline hover:underline-offset-2">
                                    <div @click="currentImage = '{{ user_profil_photo($user) }}'; userName = '{{ $user->getFullName() }}'; email = '{{ $user->email }}'; show = true" class="h-14 w-14 flex-shrink-0">
                                        <img class="h-14 w-14 rounded-full object-cover border-sky-500 border" src="{{ user_profil_photo($user) }}" alt="Photo de profil de {{ $user->getFullName() }}">
                                    </div>
                                    <div class="ml-4">
                                        <span class="flex gap-x-2 items-center">
                                            <a title="Voir les détails de l'abonnement {{$subscription->ref_key}}" class="" href="{{ $subscription->to_details_route() }}">
                                                {{$user->getFullName()}} 
                                            </a>
                                        </span>
                                        <div class="text-sm text-gray-500">
                                            <span class="fas fa-envelope mr-0.5"></span>
                                            {{ $user->email }}
                                        </div>
                                        <div class="text-sm text-indigo-600">
                                            <span class="fas fa-phone mr-0.5"></span>
                                            {{ $user->contacts }}
                                        </div>
                                    </div>
                                </div>
                                <div>
                                    <a href="{{$school->to_profil_route()}}" class="inline-block p-2 rounded-md bg-sky-700/60 my-1.5 hover:underline hover:underline-offset-2 hover:text-rose-300">
                                        <span>Ecole : </span>
                                        <span>
                                            {{ $school->name }}
                                        </span>
                                    </a>
                                </div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-right text-sm font-medium">
                                @if($school->current_subscription())
                                <div class="text-sm font-thin letter-spacing-1 text-gray-400 flex flex-col gap-y-1">
                                    <span>
                                        Souscrit le {{__formatDate($subscription->created_at) }}
                                    </span>
                                    <span>
                                        Validé le {{ __formatDate($subscription->validate_at) }}
                                    </span>
                                    <span class="{{ $subscription->remainingDaysColor }}">
                                        Expire le {{__formatDate($subscription->will_closed_at) }}
                                        <span>Soit dans {{ str_replace('restants', '', __formatDateDiff($subscription->will_closed_at)) }}</span>
                                    </span>
                                </div>
                                @else
                                    <span> Déjà expiré</span>
                                @endif
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap">
                                @if ($subscription->validate_at && $subscription->payment)
                                    <div class="flex justify-center items-center ">
                                        <span class="flex flex-wrap gap-1 font-thin justify-start">
                                            <span>
                                                <span>Status : </span>
                                                <span>
                                                    <span class="text-green-500">           {{ $subscription->payment_status }}
                                                    </span>
                                                </span>
                                            </span>
                                            <span>
                                                <span>Prix unitaire : </span>
                                                <span class="text-amber-500">
                                                    {{ __moneyFormat($subscription->unique_price) }}
                                                </span>
                                            </span>
                                            <span>
                                                <span>Nombre de mois : </span>
                                                <span class="text-amber-500">
                                                    {{ __zero($subscription->months) }}
                                                </span>
                                            </span>
                                            <span>
                                                <span>Reduction : </span>
                                                <span class="text-amber-500">
                                                    {{ $subscription->discount }} %
                                                </span>
                                            </span>
                                            <span>
                                                <span>Montant total : </span>
                                                <span class="text-amber-500">
                                                    {{ __moneyFormat($subscription->amount) }}
                                                </span>
                                            </span>
                                            <span>
                                                <span>Montant payé : </span>
                                                <span class="text-amber-500">
                                                    {{ __moneyFormat($subscription->payment->amount) }}
                                                </span>
                                            </span>
                                        </span>
                                    </div>
                                @endif
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap">
                                <div class="flex flex-col gap-y-1">
                                    <span class="flex justify-between">
                                        <span>Max Img : </span>
                                        <span> {{ $subscription->max_images }} </span>
                                    </span>
                                    <span class="flex justify-between">
                                        <span>Max Stats : </span>
                                        <span> {{ $subscription->max_stats }} </span>
                                    </span>
                                    <span class="flex justify-between">
                                        <span>Max Infos : </span>
                                        <span> {{ $subscription->max_infos }} </span>
                                    </span>
                                    <span class="flex justify-between">
                                        <span>Max Assist. : </span>
                                        <span> {{ $subscription->max_assistants }} </span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap">
                                <div class="flex flex-col gap-y-1 text-red-400">
                                    <span class="flex justify-between">
                                        <span>Img : </span>
                                        <span> {{ $subscription->remainingImages }} </span>
                                    </span>
                                    <span class="flex justify-between">
                                        <span>Stats : </span>
                                        <span> {{ $subscription->remainingStats }} </span>
                                    </span>
                                    <span class="flex justify-between">
                                        <span>Infos : </span>
                                        <span> {{ $subscription->remainingInfos }} </span>
                                    </span>
                                    <span class="flex justify-between">
                                        <span>Assist. : </span>
                                        <span> {{ $subscription->remainingAssistants }} </span>
                                    </span>
                                </div>
                            </td>
                            <td class="px-2 py-2 whitespace-nowrap text-center">
                                <div class="flex flex-col gap-y-1.5">
                                    <button wire:click='nofifySubscriberThatExpiredDateIsSoClose({{$subscription->id}})' class="block text-white cursor-pointer bg-orange-400 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-orange-700 focus:ring-orange-800" type="button">
                                        <span wire:loading.remove wire:target='nofifySubscriberThatExpiredDateIsSoClose({{$subscription->id}})'>
                                            <span class="fas fa-calendar mr-1"></span>
                                            Notifier date d'expiration
                                        </span>
                                        <span wire:loading wire:target='nofifySubscriberThatExpiredDateIsSoClose({{$subscription->id}})'>
                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                            <span>En cours...</span>
                                        </span>
                                    </button>
                                    <button wire:click='markAsExpired({{$subscription->id}})' class="block text-white cursor-pointer bg-red-600 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-red-800 focus:ring-red-800" type="button">
                                        <span wire:loading.remove wire:target='markAsExpired({{$subscription->id}})'>
                                            <span class="fas fa-hourglass-end mr-1"></span>
                                            Plannifier expiration
                                        </span>
                                        <span wire:loading wire:target='markAsExpired({{$subscription->id}})'>
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
                            <th class="px-3 py-2 text-center">#N°</th>
                            <th class="px-3 py-2 text-left">Privilèges</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="payments-tbody">
                        @foreach ($pack->privileges as $permission)
                            <tr wire:key='list-des-privileges-pack-{{getRand(2999, 8888888)}}-de-ce-role'>
                                <td class="px-2 py-2 text-gray-400 text-center">
                                    {{ numberZeroFormattor($loop->iteration) }}
                                </td>
                                <td class="px-2 py-2 text-gray-400 font-thin letter-spacing-1">
                                    {{ __translatePermissionName($permission) }}
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




