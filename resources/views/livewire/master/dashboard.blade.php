<div class="w-full py-3 mx-auto shadow-3 mt-8 shadow-sky-500 rounded-xl bg-black/70">
    <div class="m-0 p-3">
        <div class="m-0">
            <h5 class="letter-spacing-1 flex bg-black/70 mx-auto flex-col text-gray-200 border-b border-amber-500 m-0 p-2">
                <p class="py-2 text-sm sm:text-lg uppercase font-bold letter-spacing-2 "> 
                    <span class="uppercase">
                        Administration
                    </span>
                </p>
            </h5>
        </div>
        <div class="flex justify-end my-2">
            <button type="button" class="collapse-toggle text-white cursor-pointer border rounded-md bg-sky-600 hover:bg-indigo-800 flex gap-x-2 py-3 px-4" data-drawer-target="drawer-admin-navigation" data-drawer-show="drawer-admin-navigation" aria-controls="drawer-admin-navigation">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
                <span>Ouvrir le menu</span>
            </button>
        </div>

        <div class="grid flex-wrap gap-1.5 justify-between font-semibold letter-spacing-1 text-xs md:text-sm grid-cols-2 md:grid-cols-3 lg:grid-cols-5 ">
            <a href="{{route('admin.users.listing')}}" class="bg-neutral-primary-soft block max-w-xs rounded-base shadow-xs scale-95 hover:scale-100 text-gray-200 transition-transform ">
                <span>
                    <img class="rounded-t-base" src="{{asset('images/school14.jpg')}}" alt="" />
                </span>
                <div class="px-0 flex flex-col gap-y-1.5 bg-black/70 border-x border-b border-orange-400">
                    <span  class="px-2.5">
                        <h5 class="mt-3 text-lg font-semibold letter-spacing-1">
                            Les Utilisateurs
                        </h5>
                    </span>
                    <span class="inline-flex  items-center bg-brand-softer text-sm letter-spacing-1 font-semibold px-1.5 py-0.5 text-gray-500">
                        {{ __zero($users) }} Utilisateurs enrégistrés
                    </span>
                    <span class="py-2 ">
                        
                    </span>
                </div>
            </a>
            <a href="{{route('admin.schools.listing')}}" class="bg-neutral-primary-soft block max-w-xs shadow-xs scale-95 hover:scale-100 text-gray-200 transition-transform border-purple-600">
                <span>
                    <img class="rounded-t-base" src="{{asset('images/school12.jpg')}}" alt="" />
                </span>
                <div class="px-0 flex flex-col gap-y-1.5 bg-black/70  border-x border-b border-purple-400">
                    <span  class="px-2.5">
                        <h5 class="mt-3 text-lg font-semibold letter-spacing-1">
                            Les écoles
                        </h5>
                    </span>
                    <span class="inline-flex  items-center bg-brand-softer text-sm letter-spacing-1 font-semibold px-1.5 py-0.5 text-gray-500">
                        {{ __zero($schools) }} écoles enrégistrées
                    </span>
                    <span class="py-2 ">
                        
                    </span>
                </div>
            </a>
            <a href="{{route('packs.page')}}" class="bg-neutral-primary-soft block max-w-xs shadow-xs scale-95 hover:scale-100 text-gray-200 transition-transform border-green-600">
                <span>
                    <img class="rounded-t-base" src="{{asset('images/school1.jpg')}}" alt="" />
                </span>
                <div class="px-0 flex flex-col gap-y-1.5 bg-black/70  border-x border-b border-green-400">
                    <span  class="px-2.5">
                        <h5 class="mt-3 text-lg font-semibold letter-spacing-1">
                            Les Packs
                        </h5>
                    </span>
                    <span class="inline-flex  items-center bg-brand-softer text-sm letter-spacing-1 font-semibold px-1.5 py-0.5 text-gray-500">
                        {{ __zero($packs) }} packs disponibles
                    </span>
                    <span class="py-2 ">
                        
                    </span>
                </div>
            </a>

            <a href="{{route('admin.packs.abonnements.list')}}" class="bg-neutral-primary-soft block max-w-xs shadow-xs scale-95 hover:scale-100 text-gray-200 transition-transform border-green-600">
                <span>
                    <img class="rounded-t-base" src="{{asset('images/school15.jpg')}}" alt="" />
                </span>
                <div class="px-0 flex flex-col gap-y-1.5 bg-black/70  border-x border-b border-sky-400">
                    <span  class="px-2.5">
                        <h5 class="mt-3 text-xl font-semibold letter-spacing-1">
                            Les abonnements actifs
                        </h5>
                    </span>
                    <span class="inline-flex  items-center bg-brand-softer text-sm letter-spacing-1 font-semibold px-1.5 py-0.5 text-gray-500">
                        {{ __zero($subscriptions) }} abonnements actifs
                    </span>
                    <span class="py-2 ">
                        
                    </span>
                </div>
            </a>

            <a href="{{route('admin.packs.subscriptions.list')}}" class="bg-neutral-primary-soft block max-w-xs shadow-xs scale-95 hover:scale-100 text-gray-200 transition-transform border-amber-600">
                <span>
                    <img class="rounded-t-base" src="{{asset('images/school15.jpg')}}" alt="" />
                </span>
                <div class="px-0 flex flex-col gap-y-1.5 bg-black/70  border-x border-b border-fuchsia-500 ">
                    <span  class="px-2.5">
                        <h5 class="mt-3 text-lg font-semibold letter-spacing-1">
                            Les demandes d'abonnement
                        </h5>
                    </span>
                    <span class="inline-flex  items-center bg-brand-softer text-sm letter-spacing-1 font-semibold px-1.5 py-0.5 text-gray-500">
                        {{ __zero($subscription_demandes) }} demandes actives
                    </span>
                    <span class="py-2 ">
                        
                    </span>
                </div>
            </a>

            <a href="#" class="bg-neutral-primary-soft block max-w-xs shadow-xs scale-95 hover:scale-100 text-gray-200 transition-transform border-amber-600">
                <span>
                    <img class="rounded-t-base" src="{{asset('images/school20.jpg')}}" alt="" />
                </span>
                <div class="px-0 flex flex-col gap-y-1.5 bg-black/70  border-x border-b border-teal-500 ">
                    <span  class="px-2.5">
                        <h5 class="mt-3 text-lg font-semibold letter-spacing-1">
                            Les payements
                        </h5>
                    </span>
                    <span class="inline-flex  items-center bg-brand-softer text-sm letter-spacing-1 font-semibold px-1.5 py-0.5 text-gray-500">
                        {{ __zero($payments) }} payements effectués
                    </span>
                    <span class="py-2 ">
                        
                    </span>
                </div>
            </a>
        </div>
    </div>
    
</div>