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
                <span class="uppercase">Abonnement : #{{ $subscription->ref_key }}</span>
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
                            <div class="grid flex-wrap gap-1.5 justify-between font-semibold letter-spacing-1 text-xs md:text-sm grid-cols-4">
                                <div class="flex flex-col gap-1.5 border rounded-lg shadow-sm shadow-amber-500 p-2 items-center ">
                                    <span>
                                        <span class="fas fa-images"></span>
                                        <span>Nbre d'images </span>
                                    </span>
                                    <span class="flex flex-col gap-2 font-thin justify-center">
                                        <span>
                                            <span>Total : </span>
                                            <span>
                                                <span class="text-amber-500">           {{ __zero($subscription->max_images) }}
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
                                <div class="flex flex-col gap-1.5 border rounded-lg shadow-sm shadow-amber-500 p-2 items-center">
                                    <span>
                                        <span class="fas fa-users"></span>
                                        <span>Nbre d'assistants </span>
                                    </span>
                                    <span class="flex flex-col gap-2 font-thin justify-center">
                                        <span>
                                            <span>Total : </span>
                                            <span>
                                                <span class="text-amber-500">           {{__zero($subscription->max_assistants)}}
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
                                                <span class="text-amber-500">           {{__zero($subscription->max_stats)}}
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
                                                <span class="text-amber-500">           {{__zero($subscription->max_infos)}}
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
                                        <span class="fas fa-cube animate-spin "></span>
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


