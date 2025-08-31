<div class="w-full max-w-[85rem] py-3 px-4 sm:px-6 lg:px-8 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2">
    <div class="flex h-full items-center mt-8">
        <main class="w-full max-w-3xl mx-auto py-2">

        <div class="hidden md:block">
            <div class="top-blue w-[250px] h-[250px] from-green-300 to-zinc-300 via-green-300 bg-linear-90 rounded-full absolute top-[89%] left-[70%]"></div>
            <div class="top-blue w-[250px] h-[250px] from-blue-300 to-gray-300 via-purple-300 bg-linear-90 rounded-full absolute top-[90%] left-[78%]"></div>

            <div class="top-blue w-[250px] h-[250px] bg-blue-400 rounded-full absolute top-[30%] right-[70%]"></div>
            <div class="top-blue w-[250px] h-[250px] from-sky-300 to-indigo-300 via-green-300 bg-linear-90 rounded-full absolute top-[12%] left-[14%]"></div>
            <div class="top-blue w-[100px] h-[100px] from-blue-300 to-gray-300 via-purple-300 bg-linear-90 rounded-full absolute  top-[33%] right-[8%]"></div>
            <div class="top-blue w-[100px] h-[100px] from-blue-300 to-gray-300 via-purple-300 bg-linear-90 rounded-full absolute  top-[40%] left-[5%]"></div>
            <div class="top-blue w-[100px] h-[100px] bg-blue-400 rounded-full absolute  bottom-[30%] right-[10%]"></div>
            <div class="top-blue w-[50px] h-[50px] bg-purple-400 rounded-full absolute  bottom-[70%] right-[2%]"></div>
            <div class="top-blue w-[100px] h-[100px] from-sky-300 to-indigo-300 via-green-300 bg-linear-90 rounded-full absolute  top-[12%] left-[14%]"></div>
            <div class="top-blue w-[100px] h-[100px] from-purple-300 to-gray-300 via-indigo-500 bg-linear-90 rounded-full absolute  top-[8%] left-[30%]"></div>
            <div class="top-blue w-[60px] h-[60px] from-purple-300 to-gray-300 via-sky-300 bg-linear-90 rounded-full absolute  bottom-[8%] left-[10%]"></div>
        </div>

        <div class="md:hidden">
            <div class="top-blue w-[50px] h-[50px] from-blue-300 to-gray-300 via-purple-300 bg-linear-90 rounded-full absolute  top-[20%] right-[8%]"></div>
            <div class="top-blue w-[50px] h-[50px] from-blue-300 to-gray-300 via-purple-300 bg-linear-90 rounded-full absolute  top-[2%] left-[3%]"></div>
            <div class="top-blue w-[50px] h-[50px] bg-blue-400 rounded-full absolute  bottom-[-120%] right-[10%]"></div>
            <div class="top-blue w-[50px] h-[50px] bg-purple-400 rounded-full absolute  bottom-[-125%] right-[2%]"></div>
            <div class="top-blue w-[50px] h-[50px] from-sky-300 to-indigo-300 via-green-300 bg-linear-90 rounded-full absolute  top-[50%] left-[-4%]"></div>
            <div class="top-blue w-[50px] h-[50px] from-purple-300 to-gray-300 via-indigo-500 bg-linear-90 rounded-full absolute  top-[-3%] left-[55%]"></div>
            <div class="top-blue w-[45px] h-[45px] from-purple-300 to-gray-300 via-green-200 bg-linear-90 rounded-full absolute  top-[14%] left-[35%]"></div>
            <div class="top-blue w-[60px] h-[60px] from-purple-300 to-gray-300 via-sky-300 bg-linear-90 rounded-full absolute  bottom-[-158%] left-[10%]"></div>
        </div>
            <div class="border border-gray-200 rounded-xl bg-black/60 backdrop-blur-lg dark:border-gray-700 py-8 px-5 shadow-4 shadow-sky-500 w-full mx-auto">
            <!-- Form -->
                <div class="w-full p-0 m-0">
                    <div class="w-full p-0 m-0">
                        <div wire:loading.remove wire:target='subscribe' class="text-center">
                            <h5 class="letter-spacing-1 flex flex-col gap-y-2 text-gray-200">
                                <p class="py-2 relative inline-block text-lg uppercase font-bold letter-spacing-2 text-sky-500 "> 
                                    <span class="">
                                        Prolongement de la durée de l'abonnement
                                        <a href="#" class="text-amber-400 hover:text-sky-600"> 
                                            {{ $subscription->ref_key }}
                                        </a>
                                    </span>
                                </p>
                            </h5>
                            <p class="font-semibold letter-spacing-1 text-xs text-amber-500 py-2.5 border-y border-y-amber-500">
                                Valider le prolongement de votre abonnement en cours <span><span class="fab fa-shopify"></span> #{{$subscription->ref_key}} </span>
                            </p>
                        </div>
                        <div wire:loading wire:target='subscribe' class="text-center w-full mx-auto my-3">
                            <h5 class="w-full bg-success-400 text-gray-900 border rounded-xl p-3 letter-spacing-2 border-r-gray-800 border-gray-900">
                            <span class="fa animate-spin fa-rotate"></span>
                            Traitement en cours...
                            </h5>
                        </div>
                    </div>
                    <form wire:submit.prevent='subscribe' class="text-xs sm:text-sm letter-spacing-1">
                        <div class="w-full mt-5">
                            <section class="bg-transparent">
                                <div class="py-8 mx-auto lg:py-16">
                                    <div >
                                        <div class="grid gap-4 sm:grid-cols-6 sm:gap-6 ">
                                            <div class="sm:col-span-3">
                                                <label for="receiver_name" class="block mb-2 font-thin text-white">Demandeur</label>
                                                <input wire:model.blur='receiver_name' type="text" name="receiver_name" id="receiver_name" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner le nom complet de votre école" >
                                                @error('receiver_name')
                                                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="email" class="block mb-2 font-thin text-gray-900 dark:text-white">Email de reception</label>
                                                <input wire:model.blur='email' type="email" name="email" id="email" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Votre addresse mail de réception" >
                                                @error('email')
                                                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="school_name" class="block mb-2 font-thin text-gray-900 dark:text-white">Ecole concernée</label>
                                                <input disabled wire:model.blur='school_name' type="text" name="school_name" id="school_name" class="border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-amber-300 dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner l'école concernée">
                                                @error('school_name')
                                                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="receiver_contact" class="block mb-2 font-thin text-gray-900 dark:text-white">Contacts joignables</label>
                                                <input wire:model.blur='receiver_contact' type="text" name="receiver_contact" id="receiver_contact" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner les contacts joignables" >
                                                @error('receiver_contact')
                                                    <p class="text-xs text-red-600 mt-2">{{ $message }}</p>
                                                @enderror
                                            </div>

                                            <div class="relative sm:col-span-3">
                                                <label for="amount_to_show" class="block mb-2 font-thin text-gray-900 dark:text-white">Prix du pack / mois</label>
                                                <input disabled wire:model='amount_to_show' type="text" id="amount_to_show"  class="bg-gray-600/50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pe-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Montant du pack par mois" required />
                                                <div class="absolute inset-y-0 end-0 top-7 flex items-center pe-3.5 pointer-events-none">
                                                    <span class="">FCFA</span>
                                                </div>
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label for="reduction" class="flex justify-between mb-2 font-thin text-gray-900 dark:text-white">
                                                    La Réduction
                                                    <span class="text-orange-400 letter-spacing-1">
                                                        - {{ $reduction_as_money }}
                                                    </span>
                                                </label>
                                                <input disabled wire:model.live='reduction_to_show' type="text" name="reduction" id="reduction" class=" border border-gray-300 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-gray-600/50 text-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="La Réduction sur le prix du pack" >
                                            </div>

                                            <div class="sm:col-span-3">
                                                <label for="months" class="block mb-2 font-thin text-gray-900 dark:text-white">Nombre de mois</label>
                                                <input wire:model.live='months' type="number" name="months" id="months" class=" border border-gray-300 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent text-gray-900 dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Nombre de mois" >

                                            </div>
                                            
                                            <div class="relative sm:col-span-3">
                                                <label for="total" class="flex justify-between mb-2 font-thin text-gray-900 dark:text-white">Montant total à payer
                                                    <span class=" text-orange-500 font-semibold letter-spacing-1 text-right"> {{$months}} mois </span>
                                                </label>
                                                <input disabled wire:model.live='total' type="text" id="total"  class="bg-gray-600/50 border border-gray-300 rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full pe-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Montant total à payer" required />
                                                <div class="absolute inset-y-0 end-0 top-7 flex items-center pe-3.5 pointer-events-none">
                                                    <span class="">FCFA</span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="flex w-full gap-x-1.5 mx-auto justify-center items-center">
                                    <a class="w-1/2 bg-orange-300 text-black hover:bg-orange-500 text-center py-3 rounded-lg" href="{{ $subscription->to_details_route() }}">
                                        <span class="arrow-left mr-3"></span>
                                        <span>Details de l'abonnement en cours</span>
                                    </a>
                                    <a type="button" wire:click='subscribe' wire:loading.class='opacity-50' wire:target='subscribe' class="cursor-pointer w-1/2 py-3 px-4 col-span-3 flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-whte bg-blue-600 hover:bg-blue-900 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                        <span>
                                            <span wire:loading.remove wire:target='subscribe'>Lancer la demande</span>
                                            <span wire:loading wire:target='subscribe'>
                                                <span class="fas animate-spin fa-rotate"></span>
                                                Création en cours...
                                            </span>
                                        </span>
                                    </a>
                                </div>
                            </section>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
    </div>
</div>







