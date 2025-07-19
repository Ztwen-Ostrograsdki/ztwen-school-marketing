<div class="w-full max-w-[85rem] py-3 px-4 sm:px-6 lg:px-8 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2">
    <div class="mt-10">
        <div>
            <h5 class="card letter-spacing-1 flex bg-black/70 text-center mx-auto flex-col gap-y-2 text-gray-200">
                <p class="py-2 relative inline-block text-transparent bg-clip-text text-xl  uppercase font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r"> 
                    <span class="">
                        BOUTIQUE: Les packs disponibles
                    </span>
                    <span class="card absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                </p>
            
            </h5>
        </div>
        <div class="w-full bg-transparent pt-12 p-4">
            <div class="grid gap-14 md:grid-cols-2 md:gap-5">
                
                <div data-aos-delay="150" class="rounded-xl bg-blue-800/80 border border-white p-6 text-center shadow-2xl card">
                    <div class="mx-auto flex h-20 w-20 -translate-y-16 transform items-center justify-center rounded-full my-0 shadow-lg bg-sky-500 shadow-sky-500/40">
                        <span class="fas fa-star"></span>
                        <span class="">BASIC</span>
                        <span class="fas fa-star"></span>
                    </div>
                    <h1 class="text-transparent my-0 bg-clip-text uppercase letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r text-base font-semibold lg:px-14 "> 
                        - Pack BASIC -
                    </h1>
                    <div>
                        <ul class="flex  flex-col text-transparent my-0 bg-clip-text gap-y-2 text-left font-semibold letter-spacing-1 from-gray-300 via-sky-500 to-zinc-200 bg-linear-to-r">
                            <li>Première page à plein temps pendant toute la durée d'abonnement</li>
                            <li>Publications des statistiques limitée</li>
                            <li>Notifications par par mail</li>
                            <li>Possibilité de faire des annonces (limitées)</li>
                            <li>Images (Max: 5 images) de votre école à la une</li>
                            <li>Contrôle du profil de votre école</li>
                        </ul>
                    </div>
                    <div class="my-5">
                        <h6 class="text-transparent bg-clip-text uppercase letter-spacing-2 from-orange-500 via-lime-500 to-blue-700 bg-linear-to-r text-base font-semibold lg:px-14 "> 
                            10 000 FCFA (TTC) / mois
                        </h6>
                    </div>

                    <div class="flex w-full justify-center items-center my-4">
                        <a href="{{route('pack.profil', ['uuid' => "basic", 'slug' => "pack-basic"])}}" class="cursor-pointer py-3 px-4 col-span-3 flex w-full justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-black from-purple-800 to-indigo-700 bg-linear-90 via-zinc-300 mx-auto hover:bg-gradient-to-r hover:from-indigo-500 hover:via-green-800 hover:text-white hover:to-indigo-400 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            <span>Souscrire à ce pack</span>
                            <span class="fas fa-check"></span>
                        </a>
                    </div>
                </div>

                <div data-aos-delay="150" class="rounded-xl bg-black/60 border border-white p-6 text-center shadow-2xl card">
                    <div class="mx-auto flex h-20 w-20 -translate-y-16 transform items-center justify-center rounded-full my-0 shadow-lg bg-green-500 shadow-green-500/40">
                        <span class="fas fa-star"></span>
                        <span class="">PRO</span>
                        <span class="fas fa-star"></span>
                    </div>
                    <h1 class="text-transparent my-0 bg-clip-text uppercase letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r text-base font-semibold lg:px-14 "> 
                        - Pack Pro -
                    </h1>
                    <div>
                        <ul class="flex  flex-col text-transparent my-0 bg-clip-text gap-y-2 text-left font-semibold letter-spacing-1 from-gray-300 via-sky-500 to-zinc-200 bg-linear-to-r">
                            <li>Première page à plein temps pendant toute la durée d'abonnement</li>
                            <li>Qui a visité ma page (Notifications)</li>
                            <li>Publications des statistiques illimitée</li>
                            <li>Notifications par SMS et par mail</li>
                            <li>Possibilité de faire des annonces (illimitées)</li>
                            <li>Images (Max: 15 images) de votre école à la une</li>
                            <li>Contrôle total et autonome du profil de votre école</li>
                        </ul>
                    </div>
                    <div class="my-4">
                        <h6 class="text-transparent bg-clip-text uppercase letter-spacing-2 from-orange-500 via-lime-500 to-blue-700 bg-linear-to-r text-base font-semibold lg:px-14 "> 
                            30 000 FCFA (TTC) / mois
                        </h6>
                    </div>

                    <div class="flex w-full justify-center items-center my-4">
                        <a href="{{route('pack.profil', ['uuid' => "pro", 'slug' => "pack-pro"])}}" class="cursor-pointer py-3 px-4 col-span-3 flex w-full justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-black from-blue-800 to-indigo-700 bg-linear-90 via-zinc-300 mx-auto hover:bg-gradient-to-r hover:from-indigo-500 hover:via-blue-800 hover:text-white hover:to-indigo-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                            <span>Souscrire à ce pack</span>
                            <span class="fas fa-check"></span>
                        </a>
                    </div>
                </div>
                
            </div>
        </div>
    </div>
</div>

