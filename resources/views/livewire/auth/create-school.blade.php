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
                        <div wire:loading.remove wire:target='insert' class="text-center">
                            <h5 class="letter-spacing-1 flex flex-col gap-y-2 text-gray-200">
                                <p class="py-2 relative inline-block text-transparent bg-clip-text text-xl  uppercase font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r"> 
                                    <span class="">
                                        Insertion d'une nouvelle école
                                        <img src="a/af/Flag_of_South_Africa.svg" alt="">
                                    </span>
                                    <span class="absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                                </p>
                            
                            </h5>
                        </div>
                        <div wire:loading wire:target='insert' class="text-center w-full mx-auto my-3">
                            <h5 class="w-full bg-success-400 text-gray-900 border rounded-xl p-3 letter-spacing-2 border-r-gray-800 border-gray-900">
                            <span class="fa animate-spin fa-rotate"></span>
                            Traitement en cours...
                            </h5>
                        </div>

                    </div>
                    <form wire:submit.prevent='insert' class="text-xs sm:text-sm letter-spacing-1">
                        <div class="w-full mt-5">
                            <section class="bg-transparent">
                                <div class="py-8 mx-auto lg:py-16">
                                    <div >
                                        <div class="grid gap-4 sm:grid-cols-6 sm:gap-6 ">
                                            <div class="sm:col-span-4">
                                                <label for="name" class="block mb-2 font-thin text-white">Nom complet de l'ecole</label>
                                                <input type="text" name="name" id="name" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner le nom complet de votre école" >
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label for="simple_name" class="block mb-2 font-thin text-gray-900 dark:text-white">Sigle de l'école</label>
                                                <input type="text" name="simple_name" id="simple_name" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner le sigle ou le diminutif de votre école" >
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="system" class="block mb-2 font-thin text-gray-900 dark:text-white">Enseignement</label>
                                                <select id="system" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-transparent text-xs sm:text-sm  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option class="bg-indigo-950"  value="{{null}}">Système d'enseignement</option>
                                                    @foreach ($systems as $syst => $sv)
                                                        <option class="bg-indigo-950" value="{{$sv}}">{{$sv}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="level" class="block mb-2 font-thin text-gray-900 dark:text-white">Niveau</label>
                                                <select wire:model.live='level' id="level" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-transparent text-xs sm:text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option class="bg-indigo-950"  value="{{null}}">Les Niveaux</option>
                                                    @foreach ($levels as $lev => $lv)
                                                        <option class="bg-indigo-950" value="{{$lv}}">{{$lv}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label for="country" class="block mb-2 font-thin text-gray-900 dark:text-white">Pays</label>
                                                <select id="country" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-transparent text-xs sm:text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option class="bg-indigo-950"  value="{{null}}">Le pays</option>
                                                    @foreach ($countries as $countr => $cv)
                                                        <option class="bg-indigo-950" value="{{ucwords($cv)}}">{{ucwords($cv)}}</option>
                                                    @endforeach
                                                </select>
                                            </div>

                                            <div class="sm:col-span-2">
                                                <label for="department" class="block mb-2 font-thin text-gray-900 dark:text-white">Département</label>
                                                <select wire:model.live='department' id="department" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-transparent text-xs sm:text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option class="bg-indigo-950"  value="{{null}}">Le département</option>
                                                    @foreach ($departments as $dep => $depv)
                                                        <option class="bg-indigo-950" value="{{$depv}}">{{$depv}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @if($department)
                                            <div class="sm:col-span-2">
                                                <label for="city" class="block mb-2 font-thin text-gray-900 dark:text-white">Ville</label>
                                                <select wire:model.live='city' id="city" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-transparent text-xs sm:text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option class="bg-indigo-950" value="{{null}}">La ville</option>
                                                    @foreach ($cities[$department_key] as $ct => $ctv)
                                                        <option class="bg-indigo-950" value="{{$ctv}}">{{$ctv}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            @else
                                            <div class="sm:col-span-2">
                                                <label for="city_f" class="block mb-2 font-thin text-gray-900 dark:text-white">Ville</label>
                                                <select disabled id="city_f" class=" border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-indigo-500/40 text-xs sm:text-sm dark:border-gray-600 dark:placeholder-gray-400 text-gray-950 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option selected="">Sélectionner le département</option>
                                                </select>
                                            </div>
                                            @endif
                                            
                                            <div class="sm:col-span-3">
                                                <label for="capacity" class="block mb-2 font-thin text-gray-900 dark:text-white">Capacité (nombre d'apprenants/étudiants)</label>
                                                <input type="number" name="capacity" id="capacity" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Préciser une quantité" >
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="contacts" class="block mb-2 font-thin text-gray-900 dark:text-white">Contacts joignables</label>
                                                <input type="text" name="contacts" id="contacts" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner les contacts joignables" >
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label for="devise" class="block mb-2 font-thin text-white">Dévise ou Slogan de votre école</label>
                                                <input type="text" name="devise" id="devise" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Dites quelques qui constitue la base de votre école: UNE DEVISE, UN SLOGAN" >
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label for="contacts" class="block mb-2 font-thin text-gray-900 dark:text-white">3 Images de votre école</label>
                                                <input multiple type="file" name="images" id="images" class=" border border-gray-300 text-gray-900 rounded-lg cursor-pointer focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 before:p-2 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner 3 images de votre école" >
                                            </div>
                                            
                                            
                                            
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="flex w-full mx-auto justify-center items-center">
                                    <a type="button" wire:click='insert' wire:loading.class='opacity-50' wire:target='insert' class="cursor-pointer py-3 px-4 col-span-3 flex w-full justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-black from-blue-800 to-indigo-700 bg-linear-90 via-zinc-300 mx-auto hover:bg-gradient-to-r hover:from-indigo-500 hover:via-blue-800 hover:text-white hover:to-indigo-700 disabled:opacity-50 disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                                        <span>
                                            <span wire:loading.remove wire:target='insert'>Lancer la création</span>
                                            <span wire:loading wire:target='insert'>
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






