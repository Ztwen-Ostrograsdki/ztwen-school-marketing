<div class="w-full max-w-[100rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" x-data="{ show: false, currentImage: '', userName: '', email: '' }">
    
    <div class="mt-10">
        <div>
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-green-400 uppercase border border-yellow-500 bg-black/60 my-2">
                Administration : Liste des abonnements approuvés | payés
                <span class="font-semibold letter-spacing-1 ml-2 text-yellow-500"> ({{ numberZeroFormattor(count($subscriptions)) }}) </span>
            </h6>
        </div>
        <div class="flex justify-end my-2 bg-black/60 p-2 border-amber-500 border">
            <div class="flex justify-end gap-x-2 w-full text-xs">
                
                <button
                    wire:click="nofifySubscribersThatExpiredDateIsSoClose"
                    class="bg-amber-600 text-white px-4 py-2 rounded-lg hover:bg-amber-800 hover:text-gray-900 transition cursor-pointer truncate"
                >
                    <span wire:loading.remove wire:target='nofifySubscribersThatExpiredDateIsSoClose'>
                        <span class="fas fa-calendar-day"></span>
                        <span>Envoyer rappels d'expiration d'abonnements</span>
                    </span>
                    <span wire:target='nofifySubscribersThatExpiredDateIsSoClose' wire:loading>
                        <span>Suppression en cours...</span>
                        <span class="fas fa-rotate animate-spin"></span>
                    </span>
                </button>
                <button
                    wire:click="exiredAllDelayedsSubscriptions"
                    class="bg-red-500 text-white px-4 py-2 rounded-lg hover:bg-red-800 hover:text-gray-900 transition cursor-pointer"
                >
                    <span wire:loading.remove wire:target='exiredAllDelayedsSubscriptions'>
                        <span class="fas fa-hourglass-end"></span>
                        <span>Expirer les abonnemnts dépassés</span>
                    </span>
                    <span wire:target='exiredAllDelayedsSubscriptions' wire:loading>
                        <span>Processus en cours...</span>
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
                                        Montant Total payé
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Ecole abonnée
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Date d'expiration <br>
                                        Nombre de jours restants
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
                                @foreach($subscriptions as $subscription)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150" >
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ __zero($loop->iteration) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-amber-600 font-semibold letter-spacing-1 flex flex-col gap-y-1">
                                                <span>
                                                    {{ $subscription->ref_key }}
                                                </span>
                                                <span class="text-xs text-gray-400">
                                                    Du {{ __formatDateTime($subscription->created_at) }}
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex items-center gap-x-1.5">
                                                <div class="h-14 w-14 flex-shrink-0">
                                                    <img @click="currentImage = '{{ user_profil_photo($subscription->user) }}'; userName = '{{ $subscription->user->getFullName() }}'; email = '{{ $subscription->user->email }}'; show = true" class="h-14 w-14 rounded-full object-cover border-sky-500 border" src="{{ user_profil_photo($subscription->user) }}" alt="">
                                                </div>
                                                <a class="hover:underline block hover:underline-offset-2" href="{{$subscription->user->to_profil_route()}}" class="ml-4">
                                                    <div class="">
                                                        {{ $subscription->user->getFullName() }}
                                                        @if($subscription->user->blocked)
                                                        <span title="Le compte de {{$subscription->user->getFullName() }} a été bloqué depuis le {{__formatDateTime($subscription->user->blocked_at)}}" class="fas fa-lock text-red-500 font-semibold mx-1 ml-1.5"></span>
                                                        @endif
                                                    </div>
                                                    <div class=" text-amber-500">
                                                        {{ $subscription->user->email }}
                                                    </div>
                                                    <div class=" text-green-500">
                                                        <span class="fas fa-phone mr-0.5"></span>
                                                        {{ $subscription->user->contacts }}
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="text-center">
                                                <a class="hover:underline hover:underline-offset-2" href="{{$subscription->pack->to_admin_pack_profil_route()}}" class="">
                                                    <div class="text-center">
                                                        {{ $subscription->pack->name }}
                                                    </div>
                                                </a>
                                            </div>
                                            <div class="text-xs mt-2 mb-1 font-semibold flex flex-col items-center text-center">
                                                @if($subscription->promoting)
                                                    <small class="text-green-800 border p-1 bg-green-300 rounded-md">En promo</small>
                                                    <small class="text-yellow-500 mt-1.5">
                                                        Reduction : {{ $subscription->discount }} %
                                                    </small>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ __moneyFormat($subscription->unique_price) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex flex-col gap-y-1 items-center text-center">
                                                {{ __moneyFormat($subscription->amount) }}
                                                <small class="text-orange-400"> {{ __zero($subscription->months) }} mois</small>
                                            </div>
                                            
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ $subscription->school->to_profil_route() }}" class="p-1 border bg-gray-500 text-white hover:bg-gray-700 rounded-md">{{ $subscription->school->name }}</a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex flex-col gap-y-1.5">
                                                @if($subscription->validate_at && $subscription->will_closed_at)
                                                    <span>
                                                        {{ __formatDateTime($subscription->will_closed_at) }}
                                                    </span>
                                                    <span class="text-green-400 text-center font-semibold letter-spacing-1">
                                                        {{ __formatDateDiff($subscription->will_closed_at) }}
                                                    </span>
                                                @else
                                                    <span class="text-red-200 font-semibold letter-spacing-1">Pas encore validé</span>
                                                @endif
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-center">
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($subscription->validate_at) bg-green-100 text-green-800 @else bg-red-200 text-red-600 @endif">
                                             {{ $subscription->validate_at ? "Payé" : "Non payé" }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-2 whitespace-nowrap text-right  font-medium">
                                            <div class="flex gap-x-1.5">
                                                <button wire:click='deleteSubscriptionRequest({{$subscription->id}})' class="block hidden text-white cursor-pointer bg-red-600 focus:ring-2 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-red-800 focus:ring-red-800" type="button">
                                                    <span wire:loading.remove wire:target='deleteSubscriptionRequest({{$subscription->id}})'>
                                                        <span class="fas fa-trash mr-1"></span>
                                                        Suppr.
                                                    </span>
                                                    <span wire:loading wire:target='deleteSubscriptionRequest({{$subscription->id}})'>
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                
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


