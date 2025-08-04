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
        <div class="border border-amber-600 rounded-md bg-black/60 backdrop-blur-lg py-2 px-5 mb-3.5 sm:px-10 shadow-4 shadow-sky-500 w-full mx-auto flex">
            <a class="text-amber-500 hover:text-amber-700 font-semibold uppercase letter-spacing-1 w-full" href="{{route('admin.packs.list')}}">
                <span class="fab fa-shopify"></span>
                la page des packs 
            </a>
        </div>
        <div class="border border-gray-200 rounded-xl bg-black/60 backdrop-blur-lg dark:border-gray-700 py-8 px-5 sm:px-10 shadow-4 shadow-sky-500 w-full mx-auto">
            <!-- Form -->
                <div class="w-full p-0 m-0">
                    <div class="w-full p-0 m-0">
                        <div class="text-amber-500">
                            <h5 class="letter-spacing-1 flex items-center justify-start pl-3 gap-x-4 gap-y-2 text-gray-200 text-lg font-semibold">
                                <span class="fab fa-shopify text-4xl text-yellow-500"></span>
                                <span>
                                    <span class="text-amber-500">
                                        @if($pack)
                                            Mise à jour des données du pack {{ $pack->name }}
                                        @else
                                            Insertion d'un nouveau pack
                                        @endif
                                    </span>
                                    <h6 class="text-yellow-400 font-semibold text-sm">
                                        Créer un pack pour les abonements sur la plateforme
                                    </h6>
                                </span>
                            </h5>
                            <h6 class="bg-yellow-500 py-2"></h6>
                        </div>
                        <div wire:loading wire:target='insert' class="text-center w-full mx-auto my-3">
                            <h5 class="w-full bg-success-400 text-lg text-amber-500 border border-amber-400 rounded-xl p-3 letter-spacing-2">
                            <span class="fa animate-spin fa-rotate"></span>
                            Traitement en cours...
                            </h5>
                        </div>
                        @if($errors->any())
                        <div class="text-center w-full mx-auto my-3">
                            <h5 class="w-full bg-red-200 text-lg text-red-600 border border-red-400 rounded-xl p-3 letter-spacing-2">
                            <span class="fa fa-warning"></span>
                              Le formulaire est incorrect!
                            </h5>
                        </div>
                        @endif

                    </div>
                    <form wire:submit.prevent='insert' class="text-xs sm:text-sm letter-spacing-1">
                        <div class="w-full mt-5">
                            <section class="bg-transparent">
                                <div class="py-8 mx-auto lg:py-16">
                                    <div >
                                        <div class="grid gap-4 grid-cols-6 sm:gap-6 ">
                                            <div class="col-span-6">
                                                <label for="name" class="block mb-2 font-thin text-white">Nom du pack</label>
                                                <select wire:model.live='name' id="name" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-transparent text-xs sm:text-sm  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option class="bg-indigo-950"  value="{{null}}">Liste des packs pré-insérés</option>
                                                    @foreach ($app_packs as $ap => $pck)
                                                        <option class="bg-indigo-950" value="{{$pck}}">{{$pck}}</option>
                                                    @endforeach
                                                </select>
                                                @error('name')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            
                                            <div class="col-span-3">
                                                <label for="price" class="block mb-2 font-thin text-gray-900 dark:text-white">Le prix en (FCFA)</label>
                                                
                                                <input wire:model.blur='price' type="number" step="500" name="price" id="price" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner combien coûte le pack" >
                                                @error('price')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="col-span-3">
                                                <label for="promo_price" class="block mb-2 font-thin text-gray-900 dark:text-white">Le prix promo en (FCFA)</label>
                                                <input disabled wire:model.blur='promo_price' type="number" step="500" name="promo_price" id="promo_price" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner le prix promotionnel" >
                                                @error('promo_price')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="col-span-3">
                                                <label for="discount" class="block mb-2 font-thin text-gray-900 dark:text-white">La réduction en %</label>
                                                
                                                <input wire:model.blur='discount' type="number" name="discount" id="discount" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner la réduction" >
                                                @error('discount')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                                
                                            </div>
                                            @if($name)
                                                <div class="col-span-6">
                                                    <h5 class="p-3 my-2 text-center border-y-2 border-y-amber-500">Quelques détails liés au pack 
                                                       <span class="text-amber-500">{{ $name }}</span> 
                                                    </h5>
                                                    <div class="flex flex-wrap gap-1.5 justify-between font-semibold letter-spacing-1">
                                                        <div class="flex gap-1.5 border rounded-lg shadow-sm shadow-amber-500 p-2 items-center">
                                                            <span>
                                                                <span class="fas fa-images"></span>
                                                                <span>Nbre d'images : </span>
                                                            </span>
                                                            <span class="text-amber-500">{{$max_images}}</span>
                                                        </div>
                                                        <div class="flex gap-1.5 border rounded-lg shadow-sm shadow-amber-500 p-2 items-center">
                                                            <span>
                                                                <span class="fas fa-users"></span>
                                                                <span>Nbre d'assistants : </span>
                                                            </span>
                                                            <span class="text-amber-500">{{$max_assistants}}</span>
                                                        </div>
                                                        <div class="flex gap-1.5 border rounded-lg shadow-sm shadow-amber-500 p-2 items-center">
                                                            <span>
                                                                <span class="fas fa-cart"></span>
                                                                <span>Nbre de stats : </span>
                                                            </span>
                                                            <span class="text-amber-500">{{$max_stats}}</span>
                                                        </div>
                                                        <div class="flex gap-1.5 border rounded-lg shadow-sm shadow-amber-500 p-2 items-center">
                                                            <span>
                                                                <span class="fas fa-news"></span>
                                                                <span>Nbre d'infos : </span>
                                                            </span>
                                                            <span class="text-amber-500">{{$max_infos}}</span>
                                                        </div>
                                                    </div> 
                                                </div>
                                                <div class="col-span-6 font-semibold letter-spacing-1">
                                                    <h5 class="p-3 my-2 text-center border-y-2 border-y-amber-500">Les privilège liés au pack 
                                                       <span class="text-amber-500">{{ $name }}</span> 
                                                    </h5>
                                                    <div class="flex flex-col gap-1.5">
                                                        @foreach ($privileges as $pr)
                                                            <span class="cursor-pointer flex items-center gap-x-2 hover:text-amber-500">
                                                                <span class="fas fa-cube animate-spin "></span>
                                                                <span>{{ $pr }}</span>
                                                            </span> 
                                                        @endforeach
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="flex w-full mx-auto justify-center items-center">
                                    <a type="button" wire:click='insert' wire:loading.class='opacity-50' wire:target='insert' class="cursor-pointer py-3 px-4 col-span-3 flex w-full justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-black from-blue-800 to-indigo-700 bg-linear-90 via-zinc-300 mx-auto hover:bg-gradient-to-r hover:from-indigo-500 hover:via-blue-800 hover:text-white hover:to-indigo-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                        <span>
                                            <span wire:loading.remove wire:target='insert'>
                                                @if($pack) Mettre à jour @else Lancer la création @endif
                                            </span>
                                            <span wire:loading wire:target='insert'>
                                                <span class="fas animate-spin fa-rotate"></span>
                                                Processus en cours...
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






