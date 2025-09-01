<div class="w-full max-w-[100rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" x-data="{ show: false, currentImage: '', userName: '', email: '' }">
    
    <div class="mt-10">
        <div>
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-green-400 uppercase border border-yellow-500 bg-black/60 my-2">
                Administration : Liste des demandes d'abonnements
                <span class="font-semibold letter-spacing-1 ml-2 text-yellow-500"> ({{ numberZeroFormattor(count($subscriptions)) }}) </span>
            </h6>
        </div>
        <div class="flex justify-end my-2 bg-black/60 p-2 border-amber-500 border">
            <div class="flex justify-end gap-x-2 w-full text-xs">
                
                <button
                    wire:click="deleteAllRequests"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-700 hover:text-gray-900 transition cursor-pointer"
                >
                    <span wire:loading.remove wire:target='deleteAllRequests'>
                        <span class="fas fa-unlock-keyhole"></span>
                        <span>Supprimer toutes les demandes</span>
                    </span>
                    <span wire:target='deleteAllRequests' wire:loading>
                        <span>Suppression en cours...</span>
                        <span class="fas fa-rotate animate-spin"></span>
                    </span>
                </button>
                <button
                    wire:click="approvedAllRequests"
                    class="bg-green-400 text-white px-4 py-2 rounded-lg hover:bg-green-700 hover:text-gray-900 transition cursor-pointer"
                >
                    <span wire:loading.remove wire:target='approvedAllRequests'>
                        <span class="fas fa-user-lock"></span>
                        <span>Valider toutes les demandes</span>
                    </span>
                    <span wire:target='approvedAllRequests' wire:loading>
                        <span>Validation en cours...</span>
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
                
                <div class="container w-full">
                    <div class="overflow-hidden">
                <!-- Table Header -->
                        <div class="relative py-2">
                            <div class="flex md:justify-between">
                                <div class="text-green-400 font-semibold letter-spacing-1">
                                    <h2 class=" sm:text-xl font-bold uppercase text-shadow shadow-amber-400">La liste des demandes</h2>
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
                                <input wire:model.live='search' type="text" class="pl-10 pr-4 py-2 border border-sky-600 bg-transparent rounded-lg w-full " placeholder="Renseigner une référence pour filtrer une demande...">
                            </div>
                            
                        </div>
                    </div>
                    
                    <!-- Table -->
                    <div class="overflow-x-auto my-5">
                        @if(count($subscriptions))
                        <table class="min-w-full divide-y text-xs sm: letter-spacing-1 divide-gray-200 border">
                            <thead class="bg-black/50 text-sky-500 ">
                                <tr>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        #N°
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        Reférence
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        Demandeur
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        Pack
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        Prix / mois
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Montant Total à payer
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Ecoles abonnées
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Date de demande
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
                                        <td class="px-6 py-2 whitespace-nowrap" @if($souscription->has_upgrade_request) rowspan="2" @endif>
                                            <div class="">
                                                {{ __zero($loop->iteration) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <a href="{{$souscription->to_details_route()}}" class="text-amber-600 font-semibold letter-spacing-1 flex flex-col gap-y-1 hover:underline hover:underline-offset-2 hover:text-gray-400">
                                                <span>
                                                    {{ $souscription->ref_key }}
                                                </span>
                                                <span>
                                                    Du {{ __formatDateTime($souscription->created_at) }}
                                                </span>
                                            </a>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex items-center gap-x-1.5">
                                                <div class="h-14 w-14 flex-shrink-0">
                                                    <img @click="currentImage = '{{ user_profil_photo($souscription->user) }}'; userName = '{{ $souscription->user->getFullName() }}'; email = '{{ $souscription->user->email }}'; show = true" class="h-14 w-14 rounded-full object-cover border-sky-500 border" src="{{ user_profil_photo($souscription->user) }}" alt="">
                                                </div>
                                                <a class="hover:underline block hover:underline-offset-2" href="{{$souscription->user->to_profil_route()}}" class="ml-4">
                                                    <div class="">
                                                        {{ $souscription->user->getFullName() }}
                                                        @if($souscription->user->blocked)
                                                        <span title="Le compte de {{$souscription->user->getFullName() }} a été bloqué depuis le {{__formatDateTime($souscription->user->blocked_at)}}" class="fas fa-lock text-red-500 font-semibold mx-1 ml-1.5"></span>
                                                        @endif
                                                    </div>
                                                    <div class=" text-amber-500">
                                                        {{ $souscription->user->email }}
                                                    </div>
                                                    <div class=" text-green-500">
                                                        <span class="fas fa-phone mr-0.5"></span>
                                                        {{ $souscription->user->contacts }}
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-center">
                                                <a class="hover:underline hover:underline-offset-2" href="{{$souscription->pack->to_admin_pack_profil_route()}}" class="">
                                                    <div class="text-center">
                                                        {{ $souscription->pack->name }}
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="text-xs mt-2 mb-1 font-semibold flex flex-col items-center text-center">
                                                @if($souscription->promoting)
                                                    <small class="text-green-800 border p-1 bg-green-300 rounded-md">En promo</small>
                                                    <small class="text-yellow-500 mt-1.5">
                                                        Reduction : {{ $souscription->discount }} %
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ __moneyFormat($souscription->unique_price) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex flex-col gap-y-1 items-center text-center">
                                                {{ __moneyFormat($souscription->amount) }}
                                                <small class="text-orange-400"> {{ __zero($souscription->months) }} mois</small>
                                            </div>
                                            
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ $souscription->school->to_profil_route() }}" class="p-1 border bg-gray-500 text-white hover:bg-gray-700 rounded-md">{{ $souscription->school->name }}</a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ __formatDateTime($souscription->created_at) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($souscription->validate_at) bg-green-100 text-green-800 @else bg-red-200 text-red-600 @endif">
                                             {{ $souscription->validate_at ? "Payé" : "Non payé" }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-2 whitespace-nowrap text-right  font-medium">
                                            <div class="flex gap-x-1.5">
                                                <button wire:click='deleteSubscriptionRequest({{$souscription->id}})' class="block text-white cursor-pointer bg-red-600 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-red-800 focus:ring-red-800" type="button">
                                                    <span wire:loading.remove wire:target='deleteSubscriptionRequest({{$souscription->id}})'>
                                                        <span class="fas fa-trash mr-1"></span>
                                                        Suppr.
                                                    </span>
                                                    <span wire:loading wire:target='deleteSubscriptionRequest({{$souscription->id}})'>
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @if(!$souscription->validate_at)
                                                <button wire:click='approvedSouscription({{$souscription->id}})' class="block text-white cursor-pointer bg-green-500 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-green-700 focus:ring-green-800" type="button">
                                                    <span wire:loading.remove wire:target='approvedSouscription({{$souscription->id}})'>
                                                        <span class="fas fa-check mr-1"></span>
                                                        Approuver
                                                    </span>
                                                    <span wire:loading wire:target='approvedSouscription({{$souscription->id}})'>
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                <button wire:click='nofifySubscriberToPaidSubscriptionForValidation({{$souscription->id}})' class="block text-white cursor-pointer bg-blue-400 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-blue-700 focus:ring-blue-800" type="button">
                                                    <span wire:loading.remove wire:target='nofifySubscriberToPaidSubscriptionForValidation({{$souscription->id}})'>
                                                        <span class="fas fa-credit-card mr-1"></span>
                                                        Reclamer payement
                                                    </span>
                                                    <span wire:loading wire:target='nofifySubscriberToPaidSubscriptionForValidation({{$souscription->id}})'>
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @endif
                                            </div>  
                                        </td>
                                        @if($souscription->has_upgrade_request)
                                            <tr class="w-full font-semibold letter-spacing-2 ">
                                                <td colspan="6" class="px-6 py-2 whitespace-nowrap text-center bg-gray-900">
                                                    <span class="flex justify-center gap-x-1.5">
                                                        <span class="text-amber-200">{{ $souscription->has_upgrade_request->user->getFullName() }} a lancé une demande de réabonnement pour cette souscription</span>
                                                        <a href="{{$souscription->to_details_route()}}" class="text-amber-600 underline underline-offset-2 hover:text-gray-500"> #{{$souscription->ref_key}} </a>
                                                    </span>
                                                    <div class="flex justify-center flex-col gap-1.5">
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
                                                                    <span>Nombre de mois : </span>
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
                                                            <span class="text-sm font-semibold letter-spacing-1 text-gray-800 bg-green-400 p-2 rounded-md flex gap-x-3.5 justify-center items-center w-full">
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
                                                        <span class="text-amber-400 font-semibold letter-spacing-1 text-left underline underline-offset-2 animate-pulse">
                                                            Reférence réabonnement : #{{ $souscription->has_upgrade_request->ref_key }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-2 whitespace-nowrap bg-gray-900">
                                                    <div class="">
                                                        {{ __formatDateTime($souscription->has_upgrade_request->created_at) }}
                                                    </div>
                                                </td>
                                                <td class="px-6 py-2 whitespace-nowrap text-center bg-gray-900">
                                                    <div class="flex gap-1.5 flex-col">
                                                        <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($souscription->has_upgrade_request->validate_at) bg-green-100 text-green-800 @else bg-red-200 text-red-600 @endif">
                                                        {{ $souscription->has_upgrade_request->validate_at ? "Payé" : "Non payé" }}
                                                        </span>
                                                    </div>
                                                </td>
                                                <td class="px-6 py-2 whitespace-nowrap text-center bg-gray-900">
                                                    <div class="flex gap-x-1.5">
                                                        <button wire:click='deleteSubscriptionUpgradeRequest({{$souscription->has_upgrade_request->id}})' class="block text-white cursor-pointer bg-red-600 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-red-800 focus:ring-red-800" type="button">
                                                            <span wire:loading.remove wire:target='deleteSubscriptionUpgradeRequest({{$souscription->has_upgrade_request->id}})'>
                                                                <span class="fas fa-trash mr-1"></span>
                                                                Suppr.
                                                            </span>
                                                            <span wire:loading wire:target='deleteSubscriptionUpgradeRequest({{$souscription->has_upgrade_request->id}})'>
                                                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                                <span>En cours...</span>
                                                            </span>
                                                        </button>
                                                        @if(!$souscription->has_upgrade_request->validate_at)
                                                        <button wire:click='approvedSouscriptionUpgradeRequest({{$souscription->has_upgrade_request->id}})' class="block text-white cursor-pointer bg-green-500 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-green-700 focus:ring-green-800" type="button">
                                                            <span wire:loading.remove wire:target='approvedSouscriptionUpgradeRequest({{$souscription->has_upgrade_request->id}})'>
                                                                <span class="fas fa-check mr-1"></span>
                                                                Approuver
                                                            </span>
                                                            <span wire:loading wire:target='approvedSouscriptionUpgradeRequest({{$souscription->has_upgrade_request->id}})'>
                                                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                                <span>En cours...</span>
                                                            </span>
                                                        </button>
                                                        <button wire:click='nofifySubscriberToPaidSubscriptionUpgradeRequestForValidation({{$souscription->has_upgrade_request->id}})' class="block text-white cursor-pointer bg-blue-400 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-blue-700 focus:ring-blue-800" type="button">
                                                            <span wire:loading.remove wire:target='nofifySubscriberToPaidSubscriptionUpgradeRequestForValidation({{$souscription->has_upgrade_request->id}})'>
                                                                <span class="fas fa-credit-card mr-1"></span>
                                                                Reclamer payement
                                                            </span>
                                                            <span wire:loading wire:target='nofifySubscriberToPaidSubscriptionUpgradeRequestForValidation({{$souscription->has_upgrade_request->id}})'>
                                                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                                <span>En cours...</span>
                                                            </span>
                                                        </button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
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

