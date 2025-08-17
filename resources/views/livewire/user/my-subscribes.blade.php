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
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        #N°
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        Pack
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
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
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ __zero($loop->iteration) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-center my-0">
                                                <a class="" href="{{$souscription->to_details_route()}}" class="text-center">
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
                                            <div class="text-amber-600 font-semibold letter-spacing-1">
                                                {{ $souscription->ref_key }}
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
                                        <td class="px-6 py-2 whitespace-nowrap">
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
                                        <td class="px-6 py-2 whitespace-nowrap text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($souscription->validate_at) bg-green-100 text-green-800 @else bg-red-200 text-red-600 @endif">
                                             {{ $souscription->validate_at ? "Payé" : "Non payé" }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-2 whitespace-nowrap text-right  font-medium">
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
                                                @endif
                                            </div>  
                                        </td>
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

