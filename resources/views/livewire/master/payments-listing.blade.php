<div class="w-full max-w-[100rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" x-data="{ show: false, currentImage: '', userName: '', email: '' }">
    
    <div class="mt-10">
        <div>
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-green-400 uppercase border border-yellow-500 bg-black/60 my-2">
                Administration : Liste des payements effectués
                <span class="font-semibold letter-spacing-1 ml-2 text-yellow-500"> ({{ numberZeroFormattor(count($payments)) }}) </span>
            </h6>
        </div>
        <div class="flex justify-end my-2 bg-black/60 p-2 border-amber-500 border">
            <div class="flex justify-end gap-x-2 w-full text-xs">
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
                                    <h2 class=" sm:text-xl font-bold uppercase text-shadow shadow-amber-400">La liste des payements validés</h2>
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
                        @if(count($payments))
                        <table class="min-w-full divide-y text-xs sm: letter-spacing-1 divide-gray-200 border">
                            <thead class="bg-black/50 text-sky-500 ">
                                <tr>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        #N°
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        Objet
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        Reférence
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider text-left">
                                        Demandeur
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Montant Total payé
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Ecole abonnée
                                    </th>
                                    <th scope="col" class="px-6 py-4 uppercase tracking-wider">
                                        Date de payement
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
                                @foreach($payments as $payment)
                                    <tr class="hover:bg-gray-50 transition-colors duration-150" >
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="">
                                                {{ __zero($loop->iteration) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <a  href="{{$payment->subscription->to_details_route()}}" class="text-gray-400 font-semibold letter-spacing-1 flex flex-col gap-y-1 hover:underline underline-offset-2">
                                                @if($payment->subscription_upgrading_request_id)
                                                <span>
                                                   Réabonnement <br>
                                                   <span class="letter-spacing-1 text-amber-600">
                                                        #{{ $payment->ref }}
                                                   </span>
                                                </span>
                                                @else
                                                <span class="text-gray-400">
                                                   Abonnement
                                                   <br>
                                                   <span class="letter-spacing-1 text-amber-600">
                                                        #{{ $payment->ref }}
                                                   </span>
                                                </span>
                                                @endif
                                            </a>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <a href="{{$payment->subscription->to_details_route()}}" class="text-amber-600 font-semibold letter-spacing-1 flex flex-col gap-y-1 hover:underline hover:underline-offset-2">
                                                <div class="text-gray-400 font-semibold letter-spacing-1 flex flex-col gap-y-1">
                                                    @if($payment->subscription_upgrading_request_id)
                                                    <span>
                                                    Réabonnement 
                                                    </span>
                                                    @else
                                                    <span class="">
                                                    Abonnement
                                                    </span>
                                                    @endif
                                                </div>
                                                <span class="text-xs text-gray-500">
                                                    Du {{ __formatDate($payment->subscription->created_at) }}
                                                </span>
                                            </a>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex items-center gap-x-1.5">
                                                <div class="h-14 w-14 flex-shrink-0">
                                                    <img @click="currentImage = '{{ user_profil_photo($payment->user) }}'; userName = '{{ $payment->user->getFullName() }}'; email = '{{ $payment->user->email }}'; show = true" class="h-14 w-14 rounded-full object-cover border-sky-500 border" src="{{ user_profil_photo($payment->user) }}" alt="">
                                                </div>
                                                <a class="hover:underline block hover:underline-offset-2" href="{{$payment->user->to_profil_route()}}" class="ml-4">
                                                    <div class="">
                                                        {{ $payment->user->getFullName() }}
                                                        @if($payment->user->blocked)
                                                        <span title="Le compte de {{$payment->user->getFullName() }} a été bloqué depuis le {{__formatDateTime($payment->user->blocked_at)}}" class="fas fa-lock text-red-500 font-semibold mx-1 ml-1.5"></span>
                                                        @endif
                                                    </div>
                                                    <div class=" text-amber-500">
                                                        {{ $payment->user->email }}
                                                    </div>
                                                    <div class=" text-green-500">
                                                        <span class="fas fa-phone mr-0.5"></span>
                                                        {{ $payment->user->contacts }}
                                                    </div>
                                                </a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex flex-col gap-y-1 items-center text-center">
                                                <span class="flex flex-col gap-y-1 font-semibold letter-spacing-1">
                                                    <span>{{ __moneyFormat($payment->amount) }}</span>
                                                </span>
                                                <span class="flex flex-col gap-y-1">
                                                    @if(!$payment->upgrading_request)
                                                    <small class="font-semibold text-gray-500"> 
                                                        {{ __zero($payment->subscription->months) }} mois d'abonnement payés
                                                    </small>
                                                    @else
                                                        <small class="font-semibold text-gray-500"> {{ __zero($payment->upgrade_request->months) }} mois d'abonnement prolongés</small>
                                                    @endif
                                                </span>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap">
                                            <div class="flex flex-wrap gap-2">
                                                <a href="{{ $payment->subscription->school->to_profil_route() }}" class="p-2 {{randColor('bg-', ['blue', 'indigo', 'gray'])}} text-black hover:bg-lime-500 rounded-md hover:underline hover:underline-offset-2">{{ $payment->subscription->school->name }}</a>
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap" >
                                            <div class="flex flex-col gap-y-1.5">
                                                {{ __formatDate($payment->payed_at) }}
                                            </div>
                                        </td>
                                        <td class="px-6 py-2 whitespace-nowrap text-center" >
                                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full @if($payment->validate) bg-green-100 text-green-800 @else bg-red-200 text-red-600 @endif">
                                             {{ $payment->validate ? "Payé" : "Non payé" }}
                                            </span>
                                        </td>
                                        
                                        <td class="px-6 py-2 whitespace-nowrap text-right  font-medium" >
                                            <div class="flex gap-x-1.5">
                                                
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


