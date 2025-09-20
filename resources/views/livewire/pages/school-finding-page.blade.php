<div class="w-full max-w-[90rem] maxw py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" x-data="{ show: false, currentImage: '', schoolName: '', simple_name: '', title: '' }">
    <div class="card mx-auto mt-10">
        <h5 class="text-amber-500 bg-black/75 py-4 px-2 rounded-lg letter-spacing-1 font-bold text-xl flex items-center justify-between gap-y-1">
            <span># Trouvez une école</span>
            <span class="ml-4 text-gray-300"> 
                @if(count($schools) > 0) 
                    Nous avons trouvé 
                    <span class="text-amber-600">{{ numberZeroFormattor(count($schools)) }}</span> 
                    écoles 
                @endif 
            </span>
        </h5>
    </div>
    <div class="card mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-lg shadow-2xl my-3 p-3">
        <div class="w-full mx-auto border rounded-lg border-gray-500 px-2 mb-5">
            <span class="inline-block py-3 letter-spacing-2 text-amber-500 w-full text-center text-sm font-semibold border-b mb-1 border-gray-500">
                Renseignez le système d'enseignement, le département et la ville souhaités
            </span>
            <div class="grid md:grid-cols-4 md:gap-6 mt-2">
                <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                    <label for="find_school_system" class="block mb-1 text-sm font-medium text-gray-400">Le Système d'enseignement souhaité</label>
                    <select aria-describedby="helper-text-find_school_system" wire:model.live='system' id="find_school_system" class="bg-inherit border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      <option class="z-bg-secondary-light-opac" value="{{null}}">Le système d'enseignement souhaité</option>
                      @foreach ($systems as $sk => $sys)
                        <option class="z-bg-secondary-light-opac" value="{{$sys}}">{{$sys}}</option>
                      @endforeach
                    </select>
                    @error('system')
                    <p id="helper-text-find_school_system" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                      {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                    <label for="find_school_level" class="block mb-1 text-sm font-medium text-gray-400">Les niveaux d'enseignement souhaités</label>
                    <select aria-describedby="helper-text-find_school_level" wire:model.live='level' id="find_school_level" class="bg-inherit border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      <option class="z-bg-secondary-light-opac" value="{{null}}">Le niveau d'enseignement souhaité</option>
                      @foreach ($levels as $lk => $lev)
                        <option class="z-bg-secondary-light-opac" value="{{$lev}}">{{$lev}}</option>
                      @endforeach
                    </select>
                    @error('level')
                    <p id="helper-text-find_school_level" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                      {{ $message }}
                    </p>
                    @enderror
                </div>
                <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                    <label for="find_school_department" class="block mb-1 text-sm font-medium text-gray-400">Le département ciblé</label>
                    <select aria-describedby="helper-text-find_school_department" wire:model.live='department' id="find_school_department" class="bg-inherit border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      <option class="z-bg-secondary-light-opac" value="{{null}}">Le département</option>
                      @foreach ($departments as $dk => $dep)
                        <option class="z-bg-secondary-light-opac" value="{{$dep}}">{{$dep}}</option>
                      @endforeach
                    </select>
                    @error('department')
                    <p id="helper-text-find_school_department" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                      {{ $message }}
                    </p>
                    @enderror
                </div>
                @if($department)
                <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                    <label for="find_school_city" class="block mb-1 text-sm font-medium text-gray-400">La commune ciblée</label>
                    <select aria-describedby="helper-text-find_school_city" wire:model.live='city' id="find_school_city" class="bg-transparent border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500">
                      <option class="z-bg-secondary-light-opac" value="{{null}}">La commune</option>
                      @foreach ($cities[$department_key] as $ck => $jcity)
                        <option class="z-bg-secondary-light-opac" value="{{$jcity}}">{{$jcity}}</option>
                      @endforeach
                    </select>
                    @error('city')
                    <p id="helper-text-find_school_city" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                      {{ $message }}
                    </p>
                    @enderror
                </div>
                @endif

            </div>
        </div>

        <div class="w-full bg-transparent rounded-md shadow mb-3">
            <div class="relative flex-grow  sm:col-span-3">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <svg class="h-5 w-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                        <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd" />
                    </svg>
                </div>
                <input wire:model.live='search' type="text" class="pl-10 pr-4 py-2 border border-sky-600 bg-transparent rounded-lg w-full " placeholder="Ecrivez un mot clé...">
            </div>
        </div>
        @if($department || $city || strlen($search) > 4 || $system || $level)
        <div class="justify-between grid grid-cols-2 gap-2 my-2 letter-spacing-1 font-medium">
            
            <button wire:loading.class='opacity-50' wire:target='findSchool' wire:click='findSchool' class="cursor-pointer py-4 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-white bg-blue-600 hover:bg-blue-800 disabled:opacity-50  disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                <span wire:loading.remove wire:target='findSchool'>
                    <span>Lancer la recherche</span>
                    <span class="fas fa-search"></span>
                </span>
                <span wire:loading wire:target="findSchool">
                    <span class="animate-spin fas fa-rotate"></span>
                    Recherche en cours...
                </span>
            </button>

            <button wire:loading.class='opacity-50' wire:target='resetSearchData' wire:click='resetSearchData' class="cursor-pointer py-4 px-4 inline-flex justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-white bg-gray-500 hover:bg-gray-600 disabled:opacity-50  disabled:pointer-events-none dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600">
                <span wire:loading.remove wire:target='resetSearchData'>
                    <span>Réinitialiser les données</span>
                    <span class="fas fa-trash"></span>
                </span>
                <span wire:loading wire:target="resetSearchData">
                    <span class="animate-spin fas fa-rotate"></span>
                    Réinitialisation en cours...
                </span>
            </button>
        </div>
        @endif
    </div>
    <div class="card mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-lg shadow-2xl">
        <div class="">
            @if(count($schools) > 0)
            <div class="font-semibold letter-spacing-1 text-gray-300 text-xs md:text-lg flex flex-col mx-auto p-5 text-left gap-y-16">
                @foreach ($schools as $school)
                    <div wire:key="find_school-{{$school->id}}" class="shadow-sm shadow-amber-400 bg-black/75 p-3 rounded-md opacity-60 transition-opacity hover:opacity-100 flex flex-col">
                        <div class="w-full my-2 border p-2 rounded-md">
                            <a href="{{$school->to_profil_route()}}" class="text-amber-600 py-2 text-lg md:text-3xl"> 
                                <div class="hover:text-pink-300 hover:underline hover:underline-offset-2 flex justify-between">
                                    <span class="text-indigo-500 hover:text-pink-300">
                                        <span></span>
                                    </span>
                                    <span>
                                        <span class="">{{ $school->name }}</span>
                                        (<span>{{ $school->simple_name }}</span>)
                                    </span>
                                </div>
                                <hr class="border border-amber-600">
                            </a>
                            <div class="w-full ">
                                <div class="my-2 italic">
                                    <p>
                                        Située au {{ $school->geographic_position }} du {{ $school->country }} dans le département de {{ $school->department }}, plus précisement dans la ville de {{ $school->city }}, l'école (<span class="lowercase">{{ $school->getSchoolType() }}</span>) <a href="{{$school->to_profil_route()}}" class="text-yellow-400 font-bold">{{ $school->name }}</a> a été fondée en {{ $school->creation_year }} par <span class="text-sky-500 font-bold">{{ $school->created_by }}</span>.
                                        <br>
                                    </p>
                                    <p>
                                        L'école, dépuis sa création acceuille en moyenne plus de <span class="text-amber-500 font-semibold">{{ __formatNumber3($school->capacity) }}</span> apprenants.
                                        Reconnue par ses <a href="{{$school->to_profil_route()}}" class="underline underline-offset-3 hover:text-rose-300">statistiques remarquables aux différents examens</a>, il va sans doute, que <a href="{{$school->to_profil_route()}}" class="text-yellow-400 font-bold">{{ $school->name }}</a> est une école de reférence pour garantir un avenir meillleur à la jeunesse de la nation.
                                    </p>
                                </div>
                                <h5 class="flex justify-end gap-x-1.5 ">
                                    <span class="text-yellow-300">Contacts : </span> 
                                    <span class="text-gray-400">
                                        <span class="fas fa-phone mr-1"></span>
                                        <span class="">{{ $school->contacts }}</span>
                                    </span>
                                </h5>

                                <h5 class="flex justify-end gap-x-1.5 ">
                                    <span class="text-yellow-300">Localisation : </span>
                                    <span class="text-gray-400">
                                        <span class="fas fa-map-location-dot mr-1 text-gray-400"></span>
                                        <span>{{ $school->country }}</span> - 
                                        <span>{{ $school->department }}</span> - 
                                        <span>{{ $school->city }}</span>
                                    </span>
                                </h5>
                                @if($school->user_id !== auth_user_id())
                                <div class="w-full flex justify-center items-center my-2 ">
                                    <a href="{{$school->to_profil_route()}}" class="bg-green-400 cursor-pointer hover:bg-green-700 text-black font-medium py-3 px-2 hover:underline underline-offset-2 rounded-lg transition duration-150 ease-in-out w-full text-center">
                                        <span class="text-center">
                                            Charger le profil de
                                            <span class="fas fa-quote-left"></span>
                                            {{ $school->name }}
                                            <span class="fas fa-quote-right"></span>
                                        </span>
                                    </a>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
            @else
                <div class="letter-spacing-1 py-8 text-lg text-center text-gray-300 animate-pulse font-semibold">
                    @if($searching)
                        <h5 class="p-3 text-red-600">
                            Oupppppps, aucune école n'a été trouvée pour vos données de recherche
                        </h5>
                    @else
                        <h5 class="p-3">
                            Veuillez renseigner les données à cibler puis lancer votre 
                        </h5>
                    @endif
                </div>
            @endif
        </div>
    </div>

</div>
