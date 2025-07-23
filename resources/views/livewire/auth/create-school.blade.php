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
            <div class="border border-gray-200 rounded-xl bg-black/60 backdrop-blur-lg dark:border-gray-700 py-8 px-5 sm:px-10 shadow-4 shadow-sky-500 w-full mx-auto">
            <!-- Form -->
                <div class="w-full p-0 m-0">
                    <div class="w-full p-0 m-0">
                        <div class="">
                            <h5 class="letter-spacing-1 flex items-center justify-start pl-3 gap-x-4 gap-y-2 text-gray-200 text-lg font-semibold">
                                <span class="fas fa-school text-4xl text-yellow-500"></span>
                                <span>
                                    <span class="">
                                        @if($school)
                                            Mise à jour des données de l'école {{ $school->name }}
                                        @else
                                            Insertion d'une nouvelle école
                                        @endif
                                    </span>
                                    <h6 class="text-yellow-400 font-semibold text-sm">
                                        Créer une école que vous aller gérer sur notre plateforme
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

                    </div>
                    <form wire:submit.prevent='insert' class="text-xs sm:text-sm letter-spacing-1">
                        <div class="w-full mt-5">
                            <section class="bg-transparent">
                                <div class="py-8 mx-auto lg:py-16">
                                    <div >
                                        <div class="grid gap-4 sm:grid-cols-6 sm:gap-6 ">
                                            <div class="sm:col-span-4">
                                                <label for="name" class="block mb-2 font-thin text-white">Nom complet de l'ecole</label>
                                                <input wire:model.blur='name' type="text" name="name" id="name" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner le nom complet de votre école" >
                                                @error('name')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label for="simple_name" class="block mb-2 font-thin text-gray-900 dark:text-white">Sigle de l'école</label>
                                                <input wire:model.blur='simple_name' type="text" name="simple_name" id="simple_name" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner le sigle ou le diminutif de votre école" >
                                                @error('simple_name')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="system" class="block mb-2 font-thin text-gray-900 dark:text-white">Enseignement</label>
                                                <select wire:model.live='system' id="system" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-transparent text-xs sm:text-sm  dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option class="bg-indigo-950"  value="{{null}}">Système d'enseignement</option>
                                                    @foreach ($systems as $syst => $sv)
                                                        <option class="bg-indigo-950" value="{{$sv}}">{{$sv}}</option>
                                                    @endforeach
                                                </select>
                                                @error('system')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="level" class="block mb-2 font-thin text-gray-900 dark:text-white">Niveau</label>
                                                <select wire:model.live='level' id="level" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-transparent text-xs sm:text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option class="bg-indigo-950"  value="{{null}}">Les Niveaux</option>
                                                    @foreach ($levels as $lev => $lv)
                                                        <option class="bg-indigo-950" value="{{$lv}}">{{$lv}}</option>
                                                    @endforeach
                                                </select>
                                                @error('level')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-2">
                                                <label for="country" class="block mb-2 font-thin text-gray-900 dark:text-white">Pays</label>
                                                <select wire:model.live='country' id="country" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-transparent text-xs sm:text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option class="bg-indigo-950"  value="{{null}}">Le pays</option>
                                                    @foreach ($countries as $countr => $cv)
                                                        <option class="bg-indigo-950" value="{{ucwords($cv)}}">{{ucwords($cv)}}</option>
                                                    @endforeach
                                                </select>
                                                @error('country')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>

                                            <div class="sm:col-span-2">
                                                <label for="department" class="block mb-2 font-thin text-gray-900 dark:text-white">Département</label>
                                                <select wire:model.live='department' id="department" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-transparent text-xs sm:text-sm dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option class="bg-indigo-950"  value="{{null}}">Le département</option>
                                                    @foreach ($departments as $dep => $depv)
                                                        <option class="bg-indigo-950" value="{{$depv}}">{{$depv}}</option>
                                                    @endforeach
                                                </select>
                                                @error('department')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
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
                                                @error('city')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            @else
                                            <div class="sm:col-span-2">
                                                <label for="city_f" class="block mb-2 font-thin text-gray-900 dark:text-white">Ville</label>
                                                <select disabled id="city_f" class=" border border-gray-300 rounded-lg focus:ring-primary-500 focus:border-primary-500 block w-full p-2.5 bg-indigo-500/40 text-xs sm:text-sm dark:border-gray-600 dark:placeholder-gray-400 text-gray-950 dark:focus:ring-primary-500 dark:focus:border-primary-500">
                                                    <option selected="">Sélectionner le département</option>
                                                </select>
                                                @error('city')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            @endif
                                            
                                            <div class="sm:col-span-3">
                                                <label for="capacity" class="block mb-2 font-thin text-gray-900 dark:text-white">Capacité (nombre d'apprenants/étudiants)</label>
                                                <input wire:model.blur='capacity' type="number" name="capacity" id="capacity" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Préciser une quantité" >
                                                @error('capacity')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-3">
                                                <label for="contacts" class="block mb-2 font-thin text-gray-900 dark:text-white">Contacts joignables</label>
                                                <input wire:model.blur='contacts' type="text" name="contacts" id="contacts" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Renseigner les contacts joignables" >
                                                @error('contacts')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            <div class="sm:col-span-6">
                                                <label for="quotes" class="block mb-2 font-thin text-white">Dévise ou Slogan de votre école</label>
                                                <input wire:model.blur='quotes' type="text" name="devise" id="devise" class=" border border-gray-300 text-gray-900 rounded-lg focus:ring-primary-600 focus:border-primary-600 block w-full p-2.5 bg-transparent dark:border-gray-600 dark:placeholder-gray-400 dark:text-white dark:focus:ring-primary-500 dark:focus:border-primary-500" placeholder="Dites quelques qui constitue la base de votre école: UNE DEVISE, UN SLOGAN" >
                                                @error('quotes')
                                                    <p class="mt-2 ml-2 text-xs text-red-500 letter-spacing-2 ">
                                                    {{ $message }}
                                                    </p>
                                                @enderror
                                            </div>
                                            @if(!$school)
                                            <div class="sm:col-span-6 ">
                                                <label for="images" class="block mb-2 font-thin text-gray-900 dark:text-white">{{ $max_images }} Images de votre école</label>
                                                <div class="">
                                                    <div class="flex items-center justify-center w-full">
                                                        {{-- Upload zone --}}
                                                        @if(!$images)
                                                        <div class="flex items-center justify-center w-full">
                                                            <label for="images" class="flex flex-col items-center justify-center w-full h-64 border-2 border-dashed rounded-lg cursor-pointer  dark:bg-gray-700 dark:border-gray-600 dark:hover:border-gray-500 dark:hover:bg-gray-600 @error('images') shadow-red-500 shadow-sm @enderror @error('images.*') shadow-red-500 shadow-sm @enderror ">
                                                                @if(!$images)
                                                                    <div wire:loading.remove wire:target='images' class="flex flex-col items-center justify-center pt-5 pb-6">
                                                                        <svg class="w-8 h-8 mb-4 text-gray-500" ...></svg>
                                                                        <p class="mb-2 text-sm text-gray-500 text-center"><span class="font-semibold">Sélectionner des images</span> ou glisser-déposer</p>
                                                                        <p class="text-xs text-gray-500 text-center">SVG, PNG, JPG ou GIF</p>
                                                                    </div>
                                                                @endif
                                                                <input multiple wire:model.live="images" name="images" id="images" type="file" class="hidden" />
                                                            </label>
                                                        </div>
                                                        @endif

                                                        {{-- Thumbnails preview --}}
                                                        @if($images)
                                                            <div class="w-full flex flex-col gap-2 justify-between items-center">
                                                                <div class="w-full grid grid-cols-2 md:grid-cols-3 gap-2">
                                                                    @foreach ($images as $key => $image)
                                                                        <div class="group relative border rounded overflow-hidden" style="z-index: 2000 !important;" x-data="{ show: false }"
                                                                            x-init="setTimeout(() => show = true, {{ $key * 100 }})"
                                                                            x-show="show"
                                                                            x-transition:enter="transition ease-out duration-500"
                                                                            x-transition:enter-start="opacity-0 scale-90"
                                                                            x-transition:enter-end="opacity-100 scale-100">
                                                                            <img src="{{ $image->temporaryUrl() }}" class="object-cover w-full h-32" alt="Preview">
                                                                            <span wire:click="removeImage({{ $key }})"
                                                                                class="absolute inset-0 bg-red-600 bg-opacity-80 text-white text-xs font-semibold opacity-0 group-hover:opacity-70 transition duration-300 flex items-center justify-center cursor-pointer">
                                                                                ✖ Retirer cette image
                                                                            </span>
                                                                        </div>
                                                                    @endforeach
                                                                </div>
                                                                
                                                                <div class="w-full">
                                                                    <label for="images" class="flex flex-col        items-center justify-center py-5 w-full border-2 border-dashed rounded-lg cursor-pointer bg-gray-700 border-gray-600 hover:border-gray-500 hover:bg-gray-600 @error('images') shadow-red-500 shadow-sm @enderror @error('images.*') shadow-red-500 shadow-sm @enderror ">
                                                                        <div wire:loading.remove wire:target='images' class="flex flex-col items-center justify-center">
                                                                            <p class="mb-2 text-sm text-gray-500 text-center"><span class="font-semibold">Sélectionner de nouvelles images</span> ou glisser-déposer</p>
                                                                            <p class="text-xs text-gray-500 text-center">SVG, PNG, JPG ou GIF</p>
                                                                        </div>
                                                                        <input multiple wire:model.live="images" name="images" id="images" type="file" class="hidden" />
                                                                    </label>
                                                                </div>
                                                            </div>
                                                        @endif

                                                    </div> 

                                                    <div class="bg-transparent w-full p-2 text-center py-6 my-2" wire:loading wire:target='images'>
                                                        <span class=" text-yellow-400 text-center text-base letter-spacing-2">
                                                        <span class="fas fa-rotate animate-spin"></span>
                                                        Chargement des images en cours... Veuillez patientez!
                                                        </span>
                                                    </div>

                                                    @error('images') 
                                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                                            {{ $message }}
                                                        </span> 
                                                    @enderror
                                                    @error('images.*') 
                                                        <span class="text-red-500 text-xs py-2 ml-1 font-semibold letter-spacing-1">
                                                            {{ $message }}
                                                        </span> 
                                                    @enderror
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
                                                @if($school) Mettre à jour @else Lancer la création @endif
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






