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


            
            
            <div class="border border-gray-200 rounded-xl bg-black/60 backdrop-blur-lg dark:border-gray-700 py-4 px-5 shadow-4 shadow-sky-500 w-full mx-auto">
            <!-- Form -->
                <div class="w-full p-0 m-0">
                    <div class="w-full p-0 m-0">
                        <div wire:loading.remove wire:target='register' class="text-center">
                            <h5 class="letter-spacing-1 flex flex-col gap-y-2 text-gray-200 py-3">
                                @auth
                                <p class="py-2 relative inline-block text-lg  uppercase font-bold letter-spacing-2 text-amber-500"> 
                                    <span class="">
                                        {{ $title }}
                                    </span>
                                    <span class="absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                                </p>
                                @else
                                <p class="py-2 relative inline-block text-transparent bg-clip-text text-xl  uppercase font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r"> 
                                    <span class="">
                                        {{ $title }}
                                    </span>
                                    <span class="absolute -bottom-1 left-0 w-full from-indigo-700 via-lime-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                                </p>  
                                @endauth
                            </h5>
                            @if($updating == false)
                            <p class="mt-4 text-sm block text-gray-600 dark:text-gray-400">
                                Vous avez déjà un compte?
                                <a class="text-blue-600 decoration-2 hover:underline font-medium dark:focus:outline-none dark:focus:ring-1 dark:focus:ring-gray-600" href="{{route('login')}}">
                                    Connectez-vous ici
                                </a>
                            </p>
                            @endif
                        </div>
                        <div wire:loading wire:target='register' class="text-center w-full mx-auto my-3">
                            <h5 class="w-full bg-success-400 text-gray-900 border rounded-xl p-3 letter-spacing-2 border-r-gray-800 border-gray-900">
                            <span class="fa animate-spin fa-rotate"></span>
                            Traitement en cours...
                            </h5>
                        </div>

                        <div class=" bg-transparent w-full p-2 text-center py-6 my-2" wire:loading wire:target='profil_photo'>
                            <b class=" text-yellow-700 text-center">
                                Chargement photo en cours... Veuillez patientez!
                            </b>
                        </div>
                        @if($profil_photo)
                        <div class="flex justify-center rounded-full p-2 my-2" >
                            <img wire:loaded wire:target='profil_photo' class="mt-1  h-60 w-60 border-2 border-sky-500  rounded-full" src="{{$profil_photo->temporaryUrl()}}" alt="Photo de profil chargé">
                        </div>
                    
                        @elseif ($photo_path)
                        <div class="flex justify-center items-center cursor-pointer rounded-full p-2 my-2" >
                            <label class="cursor-pointer flex justify-center items-center w-full" for="register-profil_photo" wire:loaded.remove wire:target='profil_photo'>
                                <img for="register-profil_photo" class="mt-1  h-60 w-60 border-2 border-indigo-400 rounded-full" src="{{url('storage', $photo_path)}}" alt="Photo de profil chargé">
                            </label>
                        </div>
                        @else
                            <div class="flex mx-auto items-center w-full p-2 my-2 justify-center bg-black/80" >
                            <label class="cursor-pointer" for="register-profil_photo" wire:loaded.remove wire:target='profil_photo'>
                                <span  class="text-lg font-semibold letter-spacing-1 text-amber-500">
                                    Veuillez choisir une photo de profil
                                </span>
                            </label>
                            </div>
                        @endif
                    </div>
                    <!-- Form -->
                
                    <form wire:keydown.enter='register' @submit.prevent>
                        <div class="w-full mt-5">
                            <div class="w-full mx-auto border rounded-lg border-gray-500 px-2 mb-5">
                                <span class="inline-block py-2 letter-spacing-2 text-yellow-400 w-full text-center text-sm border-b mb-1 border-gray-500">
                                    Informations identitaire
                                </span>
                                <div class="grid md:grid-cols-1 md:gap-6 pb-2">
                                    <div class="grid w-full md:grid-cols-2 md:gap-6">
                                        <div class="relative z-0 w-full group text-gray-400">
                                            <label for="register-firstname" class="block mb-1 text-sm letter-spacing-2 text-gray-400">Votre Nom</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                                <input wire:model.live='firstname' type="text" id="register-firstname" aria-describedby="helper-text-register-firstname" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Votre nom" required />
                                            </div>
                                            @error('firstname')
                                            <p id="helper-text-register-firstname" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                            {{ $message }}
                                            </p>
                                            @enderror
                                        </div>
                                            
                                        <div class="relative z-0 w-full group text-gray-400">
                                            <label for="register-lastname" class="block mb-1 text-sm font-medium text-gray-400">Vos prénoms</label>
                                            <div class="relative">
                                                <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                                    <span class="fas fa-user"></span>
                                                </div>
                                                <input wire:model.live='lastname' type="text" id="register-lastname" aria-describedby="helper-text-register-lastname" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Vos prénoms complets" required />
                                            </div>
                                            @error('lastname')
                                            <p id="helper-text-register-lastname" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                            {{ $message }}
                                            </p>
                                            @enderror
                                        </div>
                                    </div>

                                    @guest
                                    <div class="relative z-0 w-full mb-5 group text-gray-400">
                                        <label for="register-email" class="block mb-1 text-sm font-medium text-gray-400">Votre addresse mail</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                                <span class="fas fa-envelope"></span>
                                            </div>
                                            <input  @auth disabled @endauth wire:model.live='email' type="email" id="register-email" aria-describedby="helper-text-register-email" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Votre addresse mail" required />
                                        </div>
                                        @error('email')
                                        <p id="helper-text-register-email" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                        {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    @else
                                    <div class="relative z-0 w-full mb-5 group text-gray-400">
                                        <label for="register-pseudo" class="block mb-1 text-sm font-medium text-gray-400">Votre pseudo</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                                <span class="fas fa-user-tag"></span>
                                            </div>
                                            <input wire:model.live='pseudo' type="text" id="register-pseudo" aria-describedby="helper-text-register-pseudo" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5   dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Votre addresse mail" required />
                                        </div>
                                        @error('pseudo')
                                        <p id="helper-text-register-pseudo" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                        {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    @endguest
                                </div>
                            </div>
                            
                            <div class="w-full mx-auto border rounded-lg border-gray-500 px-2 mb-5">
                                <span class="inline-block py-2 letter-spacing-2 text-gray-400 w-full text-center text-sm border-b mb-1 border-gray-500">
                                    Votre adresse (Domicile)
                                </span>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                                        <label for="register-department" class="block mb-1 text-sm font-medium text-gray-400">Votre département</label>
                                        <select aria-describedby="helper-text-register-department" wire:model.live='department' id="register-department" class="bg-transparent border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option class="bg-black/85" value="{{null}}">Votre département</option>
                                        @foreach ($departments as $dk => $dep)
                                            <option class="bg-black/85" value="{{$dk}}">{{$dep}}</option>
                                        @endforeach
                                        </select>
                                        @error('department')
                                        <p id="helper-text-register-department" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                        {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    @if($department)
                                    <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                                        <label for="register-city" class="block mb-1 text-sm font-medium text-gray-400">Votre commune</label>
                                        <select aria-describedby="helper-text-register-city" wire:model.live='city' id="register-city" class="bg-transparent border border-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                        <option class="bg-black/85" value="{{null}}">Votre commune</option>
                                        @foreach ($cities[$department_key] as $ck => $ct)
                                            <option class="bg-black/85" value="{{$ct}}">{{$ct}}</option>
                                        @endforeach
                                        </select>
                                        @error('city')
                                        <p id="helper-text-register-city" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                        {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    @endif
                                </div>
                                
                            </div>

                            <div class="grid md:grid-cols-2 md:gap-6">
                                <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                                <label for="register-gender" class="block mb-1 text-sm font-medium text-gray-400">Sexe</label>
                                <select aria-describedby="helper-text-register-gender" wire:model.live='gender' id="register-gender" class="bg-transparent border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option class="bg-black/85" value="{{null}}">Préciser votre genre </option>
                                    @foreach ($genders as $gk => $g)
                                    <option class="bg-black/85" value="{{$gk}}">{{$g}}</option>
                                    @endforeach
                                </select>
                                @error('gender')
                                <p id="helper-text-register-gender" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                    {{ $message }}
                                </p>
                                @enderror
                                </div>
                                <div class="relative z-0 w-full mb-5 text-gray-400 group ">
                                <label for="register-marital_status" class="block mb-1 text-sm font-medium text-gray-400">Situation matrimoniale</label>
                                <select aria-describedby="helper-text-register-marital_status" wire:model.live='marital_status' id="register-marital_status" class="bg-transparent border border-gray-300 text-gray-300 text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full p-2.5 dark:border-gray-600 dark:placeholder-gray-400 dark:focus:ring-blue-500 dark:focus:border-blue-500">
                                    <option class="bg-black/85" value="{{null}}">Préciser votre situation </option>
                                    @foreach ($marital_statuses as $mk => $m)
                                    <option class="bg-black/85" value="{{$mk}}">{{$m}}</option>
                                    @endforeach
                                </select>
                                @error('marital_status')
                                <p id="helper-text-register-marital_status" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                    {{ $message }}
                                </p>
                                @enderror
                                </div>
                                
                            </div>

                            <div class="grid md:gap-6">
                                <div class="relative z-0 w-full mb-5 group text-gray-400">
                                <label for="register-contacts" class="block mb-1 text-sm font-medium text-gray-400">
                                    Vos contacts
                                    <small class="text-yellow-500 text-xs letter-spacing-2 float-right ml-3">Séparez vos contacts par un tiret - </small>

                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                        <span class="fas fa-phone"></span>
                                    </div>
                                    <input wire:model.live='contacts' type="text" id="register-contacts" aria-describedby="helper-text-register-contacts" class="bg-transparent border border-gray-300  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5  dark:border-gray-600 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500" placeholder="Vos contacts" required />
                                </div>
                                @error('contacts')
                                <p id="helper-text-register-contacts" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                    {{ $message }}
                                </p>
                                @enderror
                                
                                </div>
                            </div>

                            <div class="w-full mb-5">
                                <div class="flex justify-between items-center">
                                    <label for="register-profil_photo" class="block text-sm mb-2 cursor-pointer text-gray-400">Photo de profil 
                                        <span class="text-orange-500 float-right ml-4">(Obligatoire)</span>
                                    </label>
                                </div>
                                <div class="relative">
                                    <input placeholder="Choisissez une photo de profil" wire:model.live='profil_photo' type="file" id="register-profil_photo" name="profil_photo" class="py-3 border px-4 block w-full border-gray-200  rounded-lg text-sm focus:border-blue-500 focus:ring-blue-500 cursor-pointer disabled:opacity-50 disabled:pointer-events-none bg-transparent dark:border-gray-700 text-gray-400 dark:focus:ring-gray-600 before:p-2" required aria-describedby="profil_photo-error">
                                    @error('profil_photo')
                                        <div class="absolute inset-y-0 end-0 flex items-center pointer-events-none pe-3">
                                        <svg class="h-5 w-5 text-red-500" width="16" height="16" fill="currentColor" viewBox="0 0 16 16" aria-hidden="true">
                                        <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8 4a.905.905 0 0 0-.9.995l.35 3.507a.552.552 0 0 0 1.1 0l.35-3.507A.905.905 0 0 0 8 4zm.002 6a1 1 0 1 0 0 2 1 1 0 0 0 0-2z" />
                                        </svg>
                                        </div>
                                    @enderror
                                </div>
                                @error('profil_photo')
                                <p class="text-xs text-red-600 mt-2" id="email-error">{{ $message }}</p>
                                @enderror
                            </div>

                            @guest
                            <div class="w-full mx-auto border rounded-lg border-gray-500 px-2 mb-5">
                                <span class="inline-block py-2 letter-spacing-2 text-yellow-400 w-full text-center text-sm border-b mb-1 border-gray-500">
                                    Sécurisation compte
                                </span>
                                <div class="grid md:grid-cols-2 md:gap-6">
                                    <div class="relative z-0 w-full mb-5 group text-gray-400">
                                        <label for="register-password" class="block mb-1 text-sm font-medium text-gray-400">Votre mot de passe</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                                <span class="fas fa-key"></span>
                                            </div>
                                            <input @auth disabled @endauth wire:model.live='password' type="password" id="register-password" aria-describedby="helper-text-register-password" class="bg-transparent border  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5 dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500 @if ($password && $password_confirmation &&  $password == $password_confirmation) border-green-600 shadow-2 shadow-green-600 @else shadow-none border-gray-600 @endif" placeholder="Choisissez un mot de passe confidentiel" required />
                                        </div>
                                        @error('password')
                                        <p id="helper-text-register-password" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                        {{ $message }}
                                        </p>
                                        @else
                                            @if ($password && $password_confirmation &&  $password == $password_confirmation)
                                            <p id="helper-text-register-password" class="mt-2 text-xs text-green-500 letter-spacing-2 ">
                                                Confirmé
                                            </p>
                                            @endif
                                        @enderror
                                    </div>
                                        
                                    @if($password)
                                    <div class="relative z-0 w-full mb-5 group text-gray-400">
                                        <label for="register-password_confirmation" class="block mb-1 text-sm font-medium text-gray-400">Confirmez votre mot de passe</label>
                                        <div class="relative">
                                            <div class="absolute inset-y-0 start-0 top-0 flex items-center ps-3.5 pointer-events-none">
                                                <span class="fas fa-key"></span>
                                            </div>
                                            <input  @auth disabled @endauth wire:model.live='password_confirmation' type="password" id="register-password_confirmation" aria-describedby="helper-text-register-password_confirmation" class="bg-transparent borde  text-sm rounded-lg focus:ring-blue-500 focus:border-blue-500 block w-full ps-10 p-2.5    dark:placeholder-gray-400  dark:focus:ring-blue-500 dark:focus:border-blue-500 @if ($password && $password_confirmation &&  $password == $password_confirmation) border-green-600 shadow-2 shadow-green-600 @else shadow-none border-gray-600 @endif" placeholder="Confirmez le mot de passe" required />
                                        </div>
                                        @error('password_confirmation')
                                        <p id="helper-text-register-password_confirmation" class="mt-2 text-xs text-red-500 letter-spacing-2 ">
                                        {{ $message }}
                                        </p>
                                        @enderror
                                    </div>
                                    @endif
                                </div>
                            </div>
                            @endguest
                            
                            
                        </div>

                        
                        <div class="flex w-full justify-center items-center py-4">
                            <a type="button" wire:click='register' wire:loading.attr='disabled' wire:target='register' class="cursor-pointer py-3 px-4 col-span-3 flex w-full justify-center items-center gap-x-2 text-sm font-semibold rounded-lg border border-transparent text-white bg-indigo-500 hover:bg-indigo-700 disabled:opacity-50 disabled:pointer-events-none focus:outline-none focus:ring-1 focus:ring-gray-600">
                                @guest
                                <span>
                                    <span wire:loading.remove wire:target='register'>S'inscrire</span>
                                    <span wire:loading wire:target='register'>
                                        <span class="fas animate-spin fa-rotate"></span>
                                        Création en cours...
                                    </span>
                                </span>
                                @else
                                <span>
                                    <span wire:loading.remove wire:target='register'>Mettre à jour</span>
                                    <span wire:loading wire:target='register'>
                                        <span class="fas animate-spin fa-rotate"></span>
                                        Mise à jour en cours...
                                    </span>
                                </span>
                                @endguest
                            </a>
                        </div>
                    </form>
                </div>
            </div>
          </div>
        </div>
    </div>
  </div>






