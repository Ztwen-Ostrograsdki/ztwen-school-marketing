<div class="w-full max-w-[100rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" >
    <div class="mt-10">
        <div class="flex flex-col">
            @if(url()->previous() !== url()->current())
            <a class="bg-black/60 hover:bg-black/40 text-white hover:underline underline-offset-2 rounded-sm p-2 mb-3 uppercase font-semibold letter-spacing-1" href="{{url()->previous() ?? auth_user()->to_profil_route()}}">
                <span class="fas fa-hand-point-left"></span>
                <span>
                    Retour
                </span>
            </a>
            @endif
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-green-400  border border-yellow-500 bg-black/60 my-2 letter-spacing-2 flex flex-col gap-y-1">
                <span class="uppercase flex justify-between items-center px-4">
                    <span class="fas fa-arrow-trend-up animate-pulse text-xl @if($subscription->has_upgrade_request && $subscription->has_upgrade_request->validate_at) text-green-600 @elseif($subscription->has_upgrade_request && !$subscription->has_upgrade_request->validate_at) text-red-400 @else hidden @endif"></span>
                    <span>Abonnement : #{{ $subscription->ref_key }}</span>
                    <span></span>
                </span>
                <span>
                    <span class="text-sm font-thin letter-spacing-1 text-gray-400">
                        <span>
                            Souscrit le {{__formatDate($subscription->created_at) }}
                        </span>
                        <span> - </span>
                        <span>
                            Validé le {{ __formatDate($subscription->validate_at) }}
                        </span>
                        <span> - </span>
                        @if($subscription->remainingsDays > 0)
                        <span>
                            Expire le {{__formatDate($subscription->will_closed_at) }}
                            <span>Soit dans {{ str_replace('restants', '', __formatDateDiff($subscription->will_closed_at)) }}</span>
                        </span>
                        @else
                        <span>
                            Expiré depuis le {{__formatDate($subscription->will_closed_at) }}
                            <span>Il y a déjà {{ str_replace('restants', '', __formatDateDiff($subscription->will_closed_at)) }}</span>
                        </span>
                        @endif
                    </span>
                </span>
                <span class="text-gray-500 text-sm flex flex-col items-center justify-center my-2.5 px-3 py-2">
                    <span class="uppercase text-green-600">
                        Détenteur
                    </span>
                    <span class="">
                        <span class="flex gap-x-2">
                            <span>
                                <span class="fas fa-user"></span>
                                <span>
                                    {{ $subscription->subscriber->getUserNamePrefix(true) }}
                                </span>
                            </span>
                            <span> - </span>
                            <span>
                                <span class="fas fa-phone"></span>
                                <span>
                                    {{ $subscription->subscriber->contacts }}
                                </span>
                            </span>
                            <span> - </span>
                            <span>
                                <span class="fas fa-envelope"></span>
                                <span>
                                    {{ $subscription->subscriber->email }}
                                </span>
                            </span>
                        </span>
                    </span>
                </span>
            </h6>
        </div>

        @if($subscription->has_upgrade_request)
        <div class="w-full bg-black/60 shadow-2xl border border-sky-500 shadow-gray-900 flex flex-col items-center justify-center min-h-full p-3">
            <div>
                <div class="font-semibold letter-spacing-2 ">
                    <div class="text-center">
                        <div class="flex justify-between">
                            <span class="font-thin letter-spacing-1 rounded-md p-1 animate-pulse px-3 @if($subscription->has_upgrade_request->validate_at) bg-green-300 @else bg-red-300 @endif" >
                                @if($subscription->has_upgrade_request->validate_at)
                                <span class="text-green-800">Abonnement prolongé</span>
                                @else
                                <span class="text-red-800">Prolongement en cours ...</span>
                                @endif
                                <span class="fas fa-arrow-trend-up text-xl @if($subscription->has_upgrade_request->validate_at) text-green-600 @elseif(!$subscription->has_upgrade_request->validate_at) text-red-400 @else hidden @endif"></span>
                            </span>
                            <span class="flex justify-center gap-x-1.5">
                                <span class="text-amber-200">{{ $subscription->has_upgrade_request->user->getFullName() }} a lancé une demande de réabonnement pour cette souscription</span>
                                <span class="text-amber-600 underline underline-offset-2"> #{{$subscription->ref_key}} </span>
                            </span>
                            <span></span>
                        </div>
                        <div class="flex justify-center flex-col gap-1.5">

                            @if ($subscription->has_upgrade_request)
                                <div class="flex justify-center p-2 items-center ">
                                    <span class="flex flex-wrap gap-5 font-thin justify-center">
                                        <span>
                                            <span>Status : </span>
                                            <span>
                                                <span class="text-green-500">           {{ $subscription->has_upgrade_request->payment_status }}
                                                </span>
                                            </span>
                                        </span>
                                        <span>
                                            <span>Prix unitaire : </span>
                                            <span class="text-amber-500">
                                                {{ __moneyFormat($subscription->has_upgrade_request->unique_price) }}
                                            </span>
                                        </span>
                                        <span>
                                            <span>Nombre de mois prolongés : </span>
                                            <span class="text-amber-500">
                                                {{ __zero($subscription->has_upgrade_request->months) }}
                                            </span>
                                        </span>
                                        <span>
                                            <span>Reduction : </span>
                                            <span class="text-amber-500">
                                                {{ $subscription->has_upgrade_request->discount }} %
                                            </span>
                                        </span>
                                        <span>
                                            <span>Montant total : </span>
                                            <span class="text-amber-500">
                                                {{ __moneyFormat($subscription->has_upgrade_request->amount) }}
                                            </span>
                                        </span>
                                        <span>
                                            <span>Montant payé : </span>
                                            <span class="text-amber-500">
                                                {{ __moneyFormat($subscription->has_upgrade_request->payment?->amount) }}
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <span class="mb-1.5">
                                    <span class="text-sm font-semibold letter-spacing-1 text-gray-800 bg-green-400 p-2 rounded-md flex gap-x-3.5 justify-center items-center w-full">
                                        <span>
                                            Souscrit le {{__formatDateTime($subscription->has_upgrade_request->created_at) }}
                                        </span>
                                        <span> - </span>
                                        <span>
                                            @if($subscription->has_upgrade_request->validate_at)
                                                Validé le {{ __formatDate($subscription->has_upgrade_request->validate_at) }}
                                            @else
                                                <span class="bg-amber-500 p-1 px-3 rounded-md">En attente, pas encore traitée!</span>
                                            @endif
                                        </span>
                                    </span>
                                </span>
                            @endif
                        </div>
                    </div>
                    <div class="px-6 py-2 flex justify-between">
                        <span class="text-amber-400 font-semibold letter-spacing-1">
                            Ref : #{{ $subscription->has_upgrade_request->ref_key }}
                        </span>
                        <span class="py-2 px-5 inline-block text-xs leading-5 font-semibold rounded-full @if($subscription->has_upgrade_request->validate_at) bg-green-100 text-green-800 @else bg-red-200 text-red-600 @endif">
                        {{ $subscription->has_upgrade_request->validate_at ? "Payé" : "Non payé" }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
        @endif

        <div class="w-full bg-transparent pt-12">
            <div class="w-full bg-black/60 shadow-2xl border border-sky-500 shadow-gray-900 flex flex-col items-center justify-center min-h-full py-5 px-5">
                <div class="container w-full">
                    <div class="overflow-hidden">
                        <div class="col-span-6 font-semibold letter-spacing-1">
                            <h5 class="p-3 my-2 text-center border-y-2 border-y-amber-500 bg-black/60">Statut et payement 
                                <span class="text-amber-500"></span> 
                            </h5>
                            <div class="flex justify-center gap-1.5">
                                @if ($subscription->validate_at && $subscription->payment)
                                    <div class="flex justify-center p-4 items-center ">
                                        <span class="flex flex-wrap gap-5 font-thin justify-center">
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
                            </div>
                        </div>
                        <div class="col-span-6">
                            <h5 class="p-3 my-2 text-center border-y-2 border-y-amber-500 letter-spacing-2 font-semibold bg-black/60">Quelques détails liés à l'abonnement 
                                <span class="text-amber-500"> #{{ $subscription->ref_key }}</span> 
                            </h5>
                            <div class="grid flex-wrap gap-1.5 justify-between font-semibold letter-spacing-1 text-xs md:text-sm grid-cols-5">
                                <div class="flex flex-col gap-1.5 border rounded-lg shadow-sm shadow-amber-500 p-2 items-center ">
                                    <span>
                                        <span class="fas fa-images"></span>
                                        <span>Nbre d'images </span>
                                    </span>
                                    <span class="flex flex-col gap-2 font-thin justify-center">
                                        <span>
                                            <span>Total : </span>
                                            <span>
                                                <span class="text-amber-500"> {{ __zero($subscription->max_images) }}
                                                </span>
                                            </span>
                                        </span>
                                        <span>
                                            <span>Uses : </span>
                                            <span class="text-amber-500">
                                                {{ __zero(count($subscription->images)) }}
                                            </span>
                                        </span>
                                        <span>
                                            <span>Rest. : </span>
                                            <span class="text-amber-500">
                                                {{ __zero($subscription->remainingImages) }}
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <div class="flex flex-col gap-1.5 border rounded-lg shadow-sm shadow-amber-500 p-2 items-center ">
                                    <span>
                                        <span class="fas fa-video"></span>
                                        <span>Nbre de vidéos </span>
                                    </span>
                                    <span class="flex flex-col gap-2 font-thin justify-center">
                                        <span>
                                            <span>Total : </span>
                                            <span>
                                                <span class="text-amber-500"> {{ __zero($subscription->max_videos) }}
                                                </span>
                                            </span>
                                        </span>
                                        <span>
                                            <span>Uses : </span>
                                            <span class="text-amber-500">
                                                {{ __zero(count($subscription->videos)) }}
                                            </span>
                                        </span>
                                        <span>
                                            <span>Rest. : </span>
                                            <span class="text-amber-500">
                                                {{ __zero($subscription->remainingVideos) }}
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <div class="flex flex-col gap-1.5 border rounded-lg shadow-sm shadow-amber-500 p-2 items-center">
                                    <span>
                                        <span class="fas fa-users"></span>
                                        <span>Nbre d'assistants </span>
                                    </span>
                                    <span class="flex flex-col gap-2 font-thin justify-center">
                                        <span>
                                            <span>Total : </span>
                                            <span>
                                                <span class="text-amber-500"> {{__zero($subscription->max_assistants)}}
                                                </span>
                                            </span>
                                        </span>
                                        <span>
                                            <span>Uses : </span>
                                            <span class="text-amber-500">
                                                {{ __zero(count($subscription->assistants)) }}
                                            </span>
                                        </span>
                                        <span>
                                            <span>Rest. : </span>
                                            <span class="text-amber-500">
                                                {{ __zero($subscription->remainingAssistants) }}
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <div class="flex flex-col gap-1.5 border rounded-lg shadow-sm shadow-amber-500 p-2 items-center">
                                    <span>
                                        <span class="fas fa-chart-line"></span>
                                        <span>Nbre de stats </span>
                                    </span>
                                    <span class="flex flex-col gap-2 font-thin justify-center">
                                        <span>
                                            <span>Total : </span>
                                            <span>
                                                <span class="text-amber-500"> {{__zero($subscription->max_stats)}}
                                                </span>
                                            </span>
                                        </span>
                                        <span>
                                            <span>Uses : </span>
                                            <span class="text-amber-500">
                                                {{ __zero(count($subscription->stats)) }}
                                            </span>
                                        </span>
                                        <span>
                                            <span>Rest. : </span>
                                            <span class="text-amber-500">
                                                {{ __zero($subscription->remainingStats) }}
                                            </span>
                                        </span>
                                    </span>
                                </div>
                                <div class="flex flex-col gap-1.5 border rounded-lg shadow-sm shadow-amber-500 p-2 items-center">
                                    <span>
                                        <span class="fas fa-newspaper"></span>
                                        <span>Nbre d'infos </span>
                                    </span>
                                    <span class="flex flex-col gap-2 font-thin justify-center">
                                        <span>
                                            <span>Total : </span>
                                            <span>
                                                <span class="text-amber-500"> {{__zero($subscription->max_infos)}}
                                                </span>
                                            </span>
                                        </span>
                                        <span>
                                            <span>Uses : </span>
                                            <span class="text-amber-500">
                                                {{ __zero(count($subscription->infos)) }}
                                            </span>
                                        </span>
                                        <span>
                                            <span>Rest. : </span>
                                            <span class="text-amber-500">
                                                {{ __zero($subscription->remainingInfos) }}
                                            </span>
                                        </span>
                                    </span>
                                </div>
                            </div> 
                        </div>
                        <div class="col-span-6 font-semibold letter-spacing-1">
                            <h5 class="p-3 my-2 text-center border-y-2 border-y-amber-500 bg-black/60">Les privilèges 
                                <span class="text-amber-500"></span> 
                            </h5>
                            <div class="flex flex-col gap-1.5">
                                @foreach ($subscription->privileges as $pr)
                                    <span class="cursor-pointer flex items-center gap-x-2 hover:text-amber-500">
                                        <span class="fas fa-cube"></span>
                                        <span>{{ $pr }}</span>
                                    </span> 
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


