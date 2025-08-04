<div class="w-full max-w-[85rem] py-3 px-4 sm:px-6 lg:px-8 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2">
    <div class="mt-10">
        <div>
            <h5 class="card letter-spacing-1 flex bg-black/70 text-center mx-auto flex-col gap-y-2 text-gray-200 border rounded-sm">
                <p class="py-2 relative inline-block text-transparent bg-clip-text text-xl  uppercase font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r"> 
                    <span class="">
                        SOUSCRIPTION AU PACK: <span class="uppercase text-orange-500">{{ $pack_slug }}</span>
                    </span>
                    <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                </p>
            
            </h5>
        </div>
        <div class="w-full bg-transparent pt-12">
            <div class="flex justify-center items-center w-full">
                <div data-aos-delay="150" class="rounded-xl bg-black/60 border border-white p-6 text-center shadow-2xl w-full card">
                    
                    <h1 class="relative mb-5 text-right uppercase letter-spacing-2 text-base font-semibold"> 
                        Pack Pro
                        <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                    </h1>
                    
                    <div>
                        <ul class="flex  flex-col text-transparent my-0 bg-clip-text gap-y-2 text-left font-semibold letter-spacing-1 from-green-300 via-lime-500 to-sky-400 bg-linear-180">
                            <li class="flex gap-x-2 justify-start items-center">
                                <span class="fas fa-calendar-check"></span>
                                <span>
                                    Première page à plein temps pendant toute la durée d'abonnement
                                </span>
                            </li>
                            <li class="flex gap-x-2 justify-start items-center">
                                <span class="fas fa-eye"></span>
                                <span>
                                    Qui a visité ma page (Notifications)
                                </span>
                            </li>
                            <li class="flex gap-x-2 justify-start items-center">
                                <span class="fas fa-chart-line"></span>
                                <span>
                                    Publications des statistiques illimitée
                                </span>
                            </li>
                            <li class="flex gap-x-2 justify-start items-center">
                                <span class="fas fa-envelope"></span>
                                <span>
                                    Notifications par SMS et par mail
                                </span>
                            </li>
                            <li class="flex gap-x-2 justify-start items-center">
                                <span class="fas fa-newspaper"></span>
                                <span>
                                    Possibilité de faire des annonces (illimitées)
                                </span>
                            </li>
                            <li class="flex gap-x-2 justify-start items-center">
                                <span class="fas fa-images"></span>
                                <span>
                                    Images (Max: 15 images) de votre école à la une
                                </span>
                            </li>
                            <li class="flex gap-x-2 justify-start items-center">
                                <span class="fas fa-user-gear"></span>
                                <span>
                                    Contrôle total et autonome du profil de votre école
                                </span>
                            </li>
                        </ul>
                    </div>
                    <div class="my-4">
                        <h6 class="text-transparent bg-clip-text uppercase letter-spacing-2 from-orange-500 via-lime-500 to-blue-700 bg-linear-to-r text-base font-semibold lg:px-14 "> 
                            30 000 FCFA (TTC) / mois
                        </h6>
                    </div>

                    <div class="flex w-full justify-center items-center my-4">
                        <a type="button" wire:click='toPaymentPage' class="cursor-pointer py-3 px-4 col-span-3 flex w-full justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-black from-blue-800 to-indigo-700 bg-linear-90 via-zinc-300 mx-auto hover:bg-gradient-to-r hover:from-indigo-500 hover:via-blue-800 hover:text-white hover:to-indigo-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            <span>
                                <span wire:loading.remove wire:target='toPaymentPage'>Soumettre la demande</span>
                                <span wire:loading wire:target='toPaymentPage'>
                                    <span class="fas animate-spin fa-rotate"></span>
                                    Chargement en cours...
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

