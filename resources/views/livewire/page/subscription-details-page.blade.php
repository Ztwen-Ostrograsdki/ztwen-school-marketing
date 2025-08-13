<div class="w-full max-w-[100rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" >
    <div class="mt-10">
        <div>
            <h6 class="text-center py-2 letter-spacing-1 font-semibold text-green-400 uppercase border border-yellow-500 bg-black/60 my-2">
                Détails du l'abonnement {{ $subscription->ref_key }}
            </h6>
        </div>
        <div class="w-full bg-transparent pt-12">
            <div class="w-full bg-black/60 shadow-2xl border border-sky-500 shadow-gray-900 flex flex-col items-center justify-center min-h-full py-5 px-5">
                
                <div class="container w-full">
                    <div class="overflow-hidden">
                        <div class="col-span-6">
                            <h5 class="p-3 my-2 text-center border-y-2 border-y-amber-500">Quelques détails liés à l'abonnement 
                                <span class="text-amber-500">{{ $subscription->pack->name }}</span> 
                            </h5>
                            <div class="flex flex-wrap gap-1.5 justify-between font-semibold letter-spacing-1">
                                <div class="flex flex-col gap-1.5 border rounded-lg shadow-sm shadow-amber-500 p-2 items-center">
                                    <span>
                                        <span class="fas fa-images"></span>
                                        <span>Nbre d'images </span>
                                    </span>
                                    <span class="flex flex-col gap-2 font-thin justify-center">
                                        <span>
                                            <span>Total : </span>
                                            <span>
                                                <span class="text-amber-500">           {{$subscription->max_images}}
                                                </span>
                                            </span>
                                        </span>
                                        <span>
                                            <span>Utilisées : </span>
                                            <span class="text-amber-500">
                                                {{ __zero(count($subscription->images)) }}
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
                                                <span class="text-amber-500">           {{$subscription->max_assistants}}
                                                </span>
                                            </span>
                                        </span>
                                        <span>
                                            <span>Utilisées : </span>
                                            <span class="text-amber-500">
                                                {{ __zero(2) }}
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
                                                <span class="text-amber-500">           {{$subscription->max_stats}}
                                                </span>
                                            </span>
                                        </span>
                                        <span>
                                            <span>Utilisées : </span>
                                            <span class="text-amber-500">
                                                {{ __zero(3) }}
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
                                                <span class="text-amber-500">           {{$subscription->max_infos}}
                                                </span>
                                            </span>
                                        </span>
                                        <span>
                                            <span>Utilisées : </span>
                                            <span class="text-amber-500">
                                                {{ __zero(3) }}
                                            </span>
                                        </span>
                                    </span>
                                </div>
                            </div> 
                        </div>
                        <div class="col-span-6 font-semibold letter-spacing-1">
                            <h5 class="p-3 my-2 text-center border-y-2 border-y-amber-500">Les privilèges 
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


