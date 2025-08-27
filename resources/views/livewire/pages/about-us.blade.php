<div class="w-full max-w-[85rem] py-3 px-4 sm:px-6 lg:px-8 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2">
    <div class="sm:flex items-center max-w-screen-xl">
        <div class="sm:w-1/2 p-10">
            <div class="image object-center text-center card">
                <img src="{{asset('images/about-image.png')}}">
            </div>
        </div>
        <div class="sm:w-1/2 p-5">
            <div class="flex flex-col gap-y-3">
                <div class="flex items-center gap-x-4">
                    <h5 class="letter-spacing-1 border border-amber-600 w-full bg-black/70 text-center mx-auto flex-col gap-y-2 text-amber-600">
                        <p class="py-2 card relative w-full text-transparent bg-clip-text text-lg  uppercase font-bold letter-spacing-2 from-amber-700 via-gray-200 to-orange-600 bg-linear-to-r px-10">
                            A propos de 
                            <span class="">
                                {{ config('app.name') }}
                            </span>
                            <span class="card absolute -bottom-1 left-0 w-full from-amber-700 via-gray-200 to-orange-600 bg-linear-to-r h-1 rounded-full"></span>
                        </p>
                    </h5>
                    
                </div>
                <div class="text-gray-400 font-semibold letter-spacing-1 bg-black/80 p-2 shadow-2xl shadow-gray-800">
                    <div class="flex flex-col justify-center">
                        <h5 class="text-gray-300">
                            <span class="text-amber-500">
                                Notre plateforme {{ config('app.name') }}
                            </span>
                            est un espace innovant dédié à la promotion et la visibilité des écoles à travers tout le pays. Elle a pour mission de rapprocher les établissements scolaires des élèves, parents et partenaires, en offrant une vitrine moderne et accessible en ligne.
                        </h5>

                        <h6 class="text-amber-500 uppercase mt-3.5 mb-1.5 text-center border-y border-y-amber-600 py-2">#Nos services</h6>

                        <div>
                            <ul>
                                <li class="flex justify-between gap-x-2">
                                    <span class="fas fa-circle mt-1.5 text-amber-800"></span>
                                    <span>
                                        <span class="text-amber-800">
                                            Présentation détaillée des écoles :
                                        </span> 
                                        chaque établissement dispose d’une page dédiée avec son histoire, ses formations, ses infrastructures et ses contacts.
                                    </span>
                                </li>

                                <li class="flex justify-between gap-x-2">
                                    <span class="fas fa-circle mt-1.5 text-amber-700"></span>
                                    <span>
                                        <span class="text-amber-700">
                                            Statistiques et performances :
                                        </span>
                                        mise en avant des résultats scolaires, effectifs annuels et autres indicateurs clés pour guider les choix des parents et apprenants.
                                    </span>
                                </li>

                                <li class="flex justify-between gap-x-2">
                                    <span class="fas fa-circle mt-1.5 text-amber-600"></span>
                                    <span>
                                        <span class="text-amber-600">
                                            Localisation géographique :
                                        </span>
                                        un système de cartographie interactif pour retrouver facilement les écoles selon la ville, le département ou la région.
                                    </span>
                                </li>

                                <li class="flex justify-between gap-x-2">
                                    <span class="fas fa-circle mt-1.5 text-amber-500"></span>
                                    <span>
                                        <span class="text-amber-500">
                                            Publicité ciblée :
                                        </span>
                                        les établissements peuvent promouvoir leurs programmes, événements et campagnes d’inscription auprès d’un public pertinent.
                                    </span>
                                </li>

                                <li class="flex justify-between gap-x-2">
                                    <span class="fas fa-circle mt-1.5 text-amber-400"></span>
                                    <span>
                                        <span class="text-amber-400">
                                            Espace multimédia :
                                        </span>
                                        photos, vidéos et documents pour mieux découvrir la vie scolaire et l’environnement éducatif.
                                    </span>
                                </li>

                                <li class="flex justify-between gap-x-2">
                                    <span class="fas fa-circle mt-1.5 text-amber-300"></span>
                                    <span>
                                        <span class="text-amber-300">
                                            Moteur de recherche intelligent :
                                        </span>
                                        trouvez rapidement une école selon vos critères (nom, ville, type d’enseignement, contacts, etc.).
                                    </span>
                                </li>

                            </ul>
                        </div>
                        <h6 class="my-2.5 shadow-amber-500 shadow-sm rounded-md p-3 text-center border border-amber-500">
                            <span class="fas fa-quote"></span>
                            <span class="text-amber-500 mr-0.5">Notre vision</span> est de devenir la référence numérique pour l’information et la promotion des écoles, en valorisant leurs atouts et en facilitant l’orientation des élèves et étudiants.
                        </h6>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
