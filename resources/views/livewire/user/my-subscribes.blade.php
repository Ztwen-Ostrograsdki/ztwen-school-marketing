<div class="w-full max-w-[100rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" x-data="{ show: false, currentImage: '', userName: '', email: '' }">
    
    <div class="mt-10">
        <div>
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-green-400 uppercase border border-yellow-500 bg-black/60 my-2">
                Mes demandes et abonnements
                <span class="font-semibold letter-spacing-1 ml-2 text-yellow-500"> ({{ numberZeroFormattor(count($subscriptions)) }}) </span>
            </h6>
        </div>
        
        <div class="w-full bg-transparent pt-12">
            <div class="w-full bg-black/60 shadow-2xl border border-sky-500 shadow-gray-900 flex flex-col items-center justify-center min-h-full py-5 px-5">
                
                <div class="container w-full">
                    <div class="overflow-hidden">
                <!-- Table Header -->
                        <div class="relative py-2">
                            <div class="flex md:justify-between">
                                <div class="text-green-400 font-semibold letter-spacing-1">
                                    <h2 class=" sm:text-xl font-bold uppercase text-shadow shadow-amber-400">La liste des demandes | Abonnements actifs</h2>
                                </div>
                                <div>
                                    
                                </div>
                            </div>
                            <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                        </div>
                        <div class="mt-6 w-full">
                            <div class="relative flex-grow  sm:col-span-3">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                                <input wire:model.live='search' type="text" class="pl-10 pr-4 py-2 border border-sky-600 bg-transparent rounded-lg w-full " placeholder="Renseigner une référence...">
                            </div>
                            
                        </div>
                    </div>
                    
                    <!-- Table -->
                    <div class="overflow-x-auto my-5">
                        @if(count($subscriptions))
                        <table class="min-w-full divide-y text-xs sm: letter-spacing-1 divide-gray-200 border">
                            <thead class="bg-black/50 text-sky-500 ">
                                <tr>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-center">
                                        #N°
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-center">
                                        Pack
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-center">
                                        Reférence
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Montant Total
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Ecoles abonnées
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        <div class="flex flex-col">
                                            <span>Date de demande</span>
                                            <span>Date de validation</span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        <div class="flex flex-col">
                                            <span>Expire le</span>
                                            <span>Jours restants</span>
                                        </div>
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Statut
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Actions
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="divide-y text-xs md:text-sm text-gray-200 divide-gray-200">
                                @foreach($subscriptions as $souscription)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150" >
                                        <td class="px-6 py-2 whitespace-nowrap " @if($souscription->has_upgrade_request) rowspan="2" @endif>
                                            <div class="">
                                                {{ __zero($loop->iteration) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-center my-0">
                                                <a class="hover:underline hover:underline-offset-2 hover:text-gray-300" href="{{$souscription->to_details_route()}}" class="text-center">
                                                    <div class="text-center">
                                                        {{ $souscription->pack->name }}
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="text-xs mt-2 mb-1 font-semibold flex flex-col items-center text-center">
                                                <div class="my-1 text-gray-400 text-xs">
                                                    {{ __moneyFormat($souscription->unique_price) }} / mois
                                                </div>
                                                @if($souscription->promoting)
                                                    <small class="text-yellow-500 mt-1.5">
                                                        Reduction : {{ $souscription->discount }} %
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-amber-600 font-semibold letter-spacing-1 hover:underline hover:underline-offset-2 hover:text-gray-300 flex flex-col gap-y-1.5 items-center">
                                                <a class="text-center" href="{{$souscription->to_details_route()}}">
                                                    #{{ $souscription->ref_key }}
                                                </a>
                                                <span class="px-2 inline-block text-xs leading-5 text-center font-semibold rounded-full @if($souscription->will_closed_at > now()) bg-green-100 text-green-800 @else bg-red-200 text-red-600 @endif">
                                                {{ $souscription->will_closed_at > now() ? "Actif" : "Expiré" }}
                                                </span>
                                                @if($souscription->upgraded)
                                                <span class="px-2 inline-block text-xs leading-5 text-center font-thin rounded-full bg-amber-200 text-amber-800">
                                                    Abonnement prolongé
                                                </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex flex-col gap-y-1 items-center text-center">
                                                <span class="flex flex-col gap-y-1">
                                                    <span>{{ __moneyFormat($souscription->amount) }}</span>
                                                    @if($souscription->has_upgrade_request?->validate_at)
                                                        <span class="text-xs text-green-400 font-semibold"> + {{ __moneyFormat($souscription->has_upgrade_request->amount) }}</span>
                                                    @endif
                                                </span>
                                                <span class="flex flex-col gap-y-1">
                                                    <small class="text-orange-400"> {{ __zero($souscription->months) }} mois</small>
                                                    @if($souscription->has_upgrade_request?->validate_at)
                                                        <small class="text-xs text-green-400 font-semibold"> + {{ __zero($souscription->has_upgrade_request->months) }} mois prolongés</small>
                                                    @endif
                                                </span>
                                                
                                            </div>
                                            
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ $souscription->school->to_profil_route() }}" class="p-1 border bg-gray-500 text-white hover:bg-gray-700 rounded-md">{{ $souscription->school->name }}</a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex flex-col gap-y-1.5">
                                                <span>
                                                    {{ __formatDateTime($souscription->created_at) }}
                                                </span>
                                                @if($souscription->validate_at)
                                                    <span class="text-green-400">
                                                        {{ __formatDateTime($souscription->validate_at) }}
                                                    </span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap"  @if($souscription->has_upgrade_request?->validate_at) rowspan="2" @endif>
                                            <div class="flex flex-col gap-y-1.5">
                                                @if($souscription->validate_at && $souscription->will_closed_at)
                                                    <span>
                                                        {{ __formatDateTime($souscription->will_closed_at) }}
                                                    </span>
                                                    <span class="text-green-400 text-center font-semibold letter-spacing-1">
                                                        {{ __formatDateDiff($souscription->will_closed_at) }}
                                                    </span>
                                                @else
                                                    <span class="text-red-200 font-semibold letter-spacing-1">Pas encore validé</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-center" @if($souscription->has_upgrade_request?->validate_at) rowspan="2" @endif>
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($souscription->validate_at) bg-green-100 text-green-800 @else bg-red-200 text-red-600 @endif">
                                             {{ $souscription->validate_at ? "Payé" : "Non payé" }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-2 whitespace-nowrap text-right  font-medium" @if($souscription->has_upgrade_request?->validate_at) rowspan="2" @endif>
                                            <div class="flex gap-x-1.5">
                                                <button wire:click='displaySubscriptionDetails({{$souscription->id}})' class="block text-white cursor-pointer bg-blue-500 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-blue-700 focus:ring-blue-800" type="button">
                                                    <span wire:loading.remove wire:target='displaySubscriptionDetails({{$souscription->id}})'>
                                                        <span class="fas fa-eye mr-1"></span>
                                                        Afficher les détails
                                                    </span>
                                                    <span wire:loading wire:target='displaySubscriptionDetails({{$souscription->id}})'>
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @if(!$souscription->validate_at)
                                                    <button wire:click='notifyAdminsThatPaymentHasBeenDone({{$souscription->id}})' class="block text-white cursor-pointer bg-green-500 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-green-700 focus:ring-green-800" type="button">
                                                        <span wire:loading.remove wire:target='notifyAdminsThatPaymentHasBeenDone({{$souscription->id}})'>
                                                            <span class="fas fa-check-double mr-1"></span>
                                                            Notifier payement effectuer validation
                                                        </span>
                                                        <span wire:loading wire:target='notifyAdminsThatPaymentHasBeenDone({{$souscription->id}})'>
                                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                            <span>En cours...</span>
                                                        </span>
                                                    </button>
                                                @else
                                                    @unless($souscription->has_upgrade_request && !$souscription->has_upgrade_request->validate_at)
                                                    <a href="{{$souscription->to_upgrading_route()}}" class="text-black cursor-pointer bg-green-500 w-auto focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-green-700 focus:ring-yellow-800">
                                                        <span class="w-full flex items-center px-1.5">
                                                            <span class="fas fa-up-long mr-1"></span>
                                                            prolonger
                                                        </span>
                                                    </a>
                                                    @endunless
                                                @endif
                                            </div>  
                                        </td>
                                        @if($souscription->has_upgrade_request)
                                            <tr class="w-full font-semibold letter-spacing-2">
                                                <td colspan="5" class="px-6 py-2 whitespace-nowrap text-center bg-gray-900">
                                                    <span class="flex justify-center gap-x-1.5">
                                                        <span class="text-amber-200"> Vous ({{ $souscription->has_upgrade_request->user->getFullName() }}) avez lancé un réabonnement pour cette souscription</span>
                                                        <span class="text-amber-600 underline underline-offset-2"> #{{$souscription->ref_key}} </span>
                                                    </span>
                                                    <div class="flex justify-center flex-col gap-1.5">
                                                        @if ($souscription->has_upgrade_request)
                                                            <div class="flex justify-center p-2 items-center ">
                                                                <span class="flex flex-wrap gap-5 font-thin justify-center">
                                                                    <span>
                                                                        <span>Status : </span>
                                                                        <span>
                                                                            <span class="text-green-500">           {{ $souscription->has_upgrade_request->payment_status }}
                                                                            </span>
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <span>Prix unitaire : </span>
                                                                        <span class="text-amber-500">
                                                                            {{ __moneyFormat($souscription->has_upgrade_request->unique_price) }}
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <span>Nombre de mois prolongés : </span>
                                                                        <span class="text-amber-500">
                                                                            {{ __zero($souscription->has_upgrade_request->months) }}
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <span>Reduction : </span>
                                                                        <span class="text-amber-500">
                                                                            {{ $souscription->has_upgrade_request->discount }} %
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <span>Montant total : </span>
                                                                        <span class="text-amber-500">
                                                                            {{ __moneyFormat($souscription->has_upgrade_request->amount) }}
                                                                        </span>
                                                                    </span>
                                                                    <span>
                                                                        <span>Montant payé : </span>
                                                                        <span class="text-amber-500">
                                                                            {{ __moneyFormat($souscription->has_upgrade_request->payment?->amount) }}
                                                                        </span>
                                                                    </span>
                                                                </span>
                                                            </div>
                                                            <span class="mb-1.5">
                                                                <span class="font-semibold letter-spacing-1 text-gray-800 bg-green-400 p-1 rounded-md flex gap-x-3.5 justify-center items-center w-full">
                                                                    <span>
                                                                        Souscrit le {{__formatDate($souscription->has_upgrade_request->created_at) }}
                                                                    </span>
                                                                    <span> - </span>
                                                                    <span>
                                                                        @if($souscription->has_upgrade_request->validate_at)
                                                                            Validé le {{ __formatDate($souscription->has_upgrade_request->validate_at) }}
                                                                        @else
                                                                            <span class="bg-amber-500 p-1 px-3 rounded-md">En attente, pas encore traitée!</span>
                                                                        @endif
                                                                    </span>
                                                                </span>
                                                            </span>
                                                        @endif
                                                    </div>
                                                </td>
                                                @if(!$souscription->has_upgrade_request->validate_at)
                                                <td colspan="3" class="px-6 py-2 whitespace-nowrap text-center">
                                                    <button wire:click='notifyAdminsThatPaymentHasBeenDone({{$souscription->id}})' class="block text-white cursor-pointer w-full bg-green-500 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-green-700 focus:ring-green-800" type="button">
                                                        <span wire:loading.remove wire:target='notifyAdminsThatPaymentHasBeenDone({{$souscription->id}})'>
                                                            <span class="fas fa-check-double mr-1"></span>
                                                            Notifier payement effectuer pour la validation
                                                        </span>
                                                        <span wire:loading wire:target='notifyAdminsThatPaymentHasBeenDone({{$souscription->id}})'>
                                                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                            <span>En cours...</span>
                                                        </span>
                                                    </button>
                                                </td>
                                                @endif
                                            </tr>
                                        @endif
                                    </tr>
                                    
                                @endforeach
                            </tbody>
                        </table>
                        @else
                        <h6 class="text-center py-2 letter-spacing-1 font-semibold text-red-600 uppercase border border-red-500 bg-black/40 my-2">
                            Vous n'avez aucun abonnement actif présentement
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
</div>

