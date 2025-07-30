<div class="w-full max-w-[85rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" x-data="{ show: false, currentImage: '', userName: '', email: '' }">
    <div class="max-w-3xl card mx-auto mt-10">
        <h5 class="text-amber-500 bg-black/75 py-4 px-2 rounded-lg letter-spacing-1 font-bold text-xl flex flex-col justify-start gap-y-1">
            <span># Profil utilisateur</span>
            <span class="text-sm text-green-500 ml-4"> {{$user_email}} </span>
        </h5>
    </div>
    <div class="max-w-3xl card mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-xl shadow-2xl">
        <div class="p-6">
            <div class="flex items-center space-x-4">
            <div class="flex-shrink-0" @click="currentImage = '{{ user_profil_photo($user) }}'; userName = '{{ $user_name }}'; email = '{{ $user_email }}'; show = true">
                <img class="h-20 w-20 rounded-full object-cover border-2 border-indigo-500" src="{{user_profil_photo($user)}}" alt="Profile picture">
            </div>
            <div class="flex-1 min-w-0">
                <p class="text-lg font-bold text-sky-500 truncate">
                    {{$user->getFullName(true)}}
                </p>
                <p class="text-sm text-gray-400 truncate">
                    {{$user->pseudo}}
                </p>
                <div class="flex space-x-4 mt-2">
                <span class="text-sm font-medium text-gray-400">
                    {{ __formatNumber3($all_posts) }}
                <span class="font-normal text-gray-400">posts</span></span>
                <span class="text-sm font-medium text-gray-400">
                    {{ __formatNumber3($all_likes) }}
                <span class="font-normal text-gray-400">followers</span></span>
                <span class="text-sm font-medium text-gray-400">
                    {{ __formatNumber3($all_subscribes) }}
                    <span class="font-normal text-gray-400">Abonnements</span>
                </span>
                </div>
            </div>
            </div>
            <div class="mt-4">
            <blockquote class="text-indigo-200 font-semibold letter-spacing-1">
                La réussite est une façon, disons la meillleur des manières de s'exprimer et d'affirmer son existence!
            </blockquote> 
            </div>
            
        </div>
    
        <!-- Menu -->
        <div class="px-6 pb-4 overflow-x-auto">
            <div class="text-xs sm:text-sm mt-4 md:mt-0 flex gap-x-2 justify-center">
                @auth
                    @if(auth_user()->id == $user->id)
                    
                    <button wire:click='openAddAssistantModal' class="block text-white cursor-pointer bg-blue-600 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-blue-800 focus:ring-blue-800" type="button">
                        <span wire:loading.remove wire:target='openAddAssistantModal'>
                            <span class="fas fa-user-plus mr-1"></span>
                            Ajouter un assistant
                        </span>
                        <span wire:loading wire:target='openAddAssistantModal'>
                            <span class="fas fa-rotate animate-spin mr-1.5"></span>
                            <span>Un instant, chargement...</span>
                        </span>
                    </button>
                    
                    <button class="bg-red-600 cursor-pointer hover:bg-red-800 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                        <span class="fas fa-trash mr-1"></span>
                        Suppr. les assistants.
                    </button>
                    @endif
                    <button class="bg-green-600 cursor-pointer hover:bg-green-800 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                        <span class="fas fa-message mr-1"></span>
                        Message
                    </button>
                @endauth
            </div>
        </div>
        <!-- end Menu -->
    </div>
    <div class="max-w-3xl card mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-lg shadow-2xl">
        <div class="flex justify-between items-center p-2 text-sm">
            <h3 class="letter-spacing-1 font-bold text-xl p-4 text-amber-400 underline underline-offset-3 w-full border-b-amber-400">
                <span># Détails perso utilisateurs</span>
            </h3>
            @auth
                @if(auth_user()->id == $user->id)
                <a href="{{$user->to_profil_edit_route()}}" class="text-black cursor-pointer bg-yellow-300 w-auto focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                    <span class="w-full flex items-center px-1.5">
                        <span class="fas fa-pen mr-1"></span>
                        Editer
                    </span>
                </a> 
                @endif
            @endauth
        </div>
        <div class="font-semibold letter-spacing-1 text-gray-300 text-sm flex flex-col mx-auto p-5">
            <h6 class="flex gap-x-2 items-center">
                <span class="text-gray-400">
                    <span class="fas fa-user"></span>
                    <span>Nom et Prénoms : </span>
                </span>
                <span>{{ $user->getFullName(true) }}</span>
            </h6>
            <h6 class="flex gap-x-2 items-center">
                <span class="text-gray-400">
                    <span class="fas fa-phone"></span>
                    <span>Contacts : </span>
                </span>
                <span>{{ $user->contacts }}</span>
            </h6>
            <h6 class="flex gap-x-2 items-center">
                <span class="text-gray-400">
                    <span class="fas fa-home"></span>
                    <span>Adresse : </span>
                </span>
                <span>{{ $user->address }}</span>
            </h6>
            <h6 class="flex gap-x-2 items-center">
                <span class="text-gray-400">
                    <span class="fas fa-person-circle-question"></span>
                    <span>Situation matrimonial : </span>
                </span>
                <span>{{ $user->marital_status ? $user->marital_status : ' -------' }}</span>
            </h6>
            <h6 class="flex gap-x-2 items-center">
                <span class="text-gray-400">
                    <span class="fab fa-keycdn"></span>
                    <span>Identifiant : </span>
                </span>
                <span>{{ $user->identifiant }}</span>
            </h6>
        </div> 
        
       
    </div>

    <div class="max-w-3xl mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-lg shadow-2xl card">
        <div class="flex justify-between items-center p-2">
            <h3 class="letter-spacing-1 font-bold text-xl p-4 text-amber-400 underline underline-offset-3 w-full border-b-amber-400">
                <span># Abonnement et pack actifs </span>
            </h3>
            @auth
                @if(auth_user()->id == $user->id)
                <div class="flex gap-x-2 text-sm">
                    <a href="{{route('packs.page')}}" class="text-black cursor-pointer bg-indigo-300 w-auto focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-indigo-500 focus:ring-yellow-800" type="button">
                        <span class="w-full flex items-center px-1.5">
                            <span class="fas fa-pen mr-1"></span>
                            Parcourir
                        </span>
                    </a>
                    <a href="#" class="text-black cursor-pointer bg-yellow-300 w-auto focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                        <span class="w-full flex items-center px-1.5">
                            <span class="fas fa-pen mr-1"></span>
                            Editer
                        </span>
                    </a>
                </div>
                @endif
            @endauth
        </div>
    </div>

    <div class="max-w-3xl card mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-lg shadow-2xl">
        <div class="flex justify-between items-center p-2">
            <h3 class="letter-spacing-1 font-bold text-xl p-4 text-amber-400 underline underline-offset-3 w-full border-b-amber-400">
                <span># Ecole administrée</span>
            </h3>
            @auth
                @if(auth_user()->id == $user->id)
                <div class="flex gap-x-2 text-sm">
                    <a href="{{auth_user()->to_create_school_route()}}" class="text-black cursor-pointer bg-indigo-300 w-auto focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-indigo-500 focus:ring-yellow-800" type="button">
                        <span class="w-full flex items-center px-1.5">
                            <span class="fas fa-pen mr-1"></span>
                            Créer
                        </span>
                    </a>
                    
                </div> 
                @endif
            @endauth
        </div>
        <div class="">
            <div class="font-semibold letter-spacing-1 text-gray-300 text-sm md:text-lg flex flex-col mx-auto p-5 text-left gap-y-3">
                @foreach ($user->schools as $school)
                    <div class="shadow-sm shadow-amber-400 bg-black/75 p-3 rounded-md">
                        <h5 class="text-purple-600 py-2 flex justify-between"> 
                            <span>
                                <span>Ecole </span>
                                <span>#{{ $loop->iteration }}</span>
                            </span>
                            <a class="hover:text-pink-300" href="{{$school->to_profil_route()}}">
                                <span class="text-sm">{{ $school->name }}</span>
                            </a>
                        </h5>
                        <div class="w-full text-xs md:text-sm">
                            <h5 class="flex justify-between">
                                <span>Ecole  
                                    <span class="text-yellow-400"> ({{ $school->getSchoolType() }}) </span> :</span> 
                                <span>
                                    <span class="mr-2.5">{{ $school->name }}</span>
                                    (<span class="text-sky-500">{{ $school->simple_name }}</span>)
                                </span>
                            </h5>
                            <h5 class="flex justify-end cursor-pointer hover:text-rose-400">
                                <span>
                                    <span>Créée en  </span>
                                    <span class="fas fa-calendar mr-1"></span>
                                    <span class="">{{ $school->creation_year }}</span>
                                </span>
                            </h5>
                            <h5 class="flex justify-end cursor-pointer hover:text-rose-400">
                                <span>
                                    <span>Fondée par </span>
                                    <span class="fas fa-user mr-1"></span>
                                    <span class="">{{ $school->created_by }}</span>
                                </span>
                            </h5>

                            <h5 class="flex justify-end cursor-pointer hover:text-rose-400">
                                <span>
                                    <span class="fas fa-phone mr-1"></span>
                                    <span class="">{{ $school->contacts }}</span>
                                </span>
                            </h5>

                            <h5 class="flex justify-end cursor-pointer hover:text-rose-400">
                                <span>
                                    <span class="fas fa-map-location-dot mr-1"></span>
                                    <span>Située au </span>
                                    <span>{{ $school->geographic_position }}</span> - 
                                    <span>{{ $school->country }}</span> - 
                                    <span>{{ $school->department }}</span> - 
                                    <span>{{ $school->city }}</span>
                                </span>
                            </h5>
                            <h5 class="flex justify-end cursor-pointer hover:text-rose-400">
                                <span>
                                    <span>Enseignement(s) : </span>
                                    <span>{{ $school->system }}</span>  
                                </span>
                            </h5>
                            <h5 class="flex justify-end cursor-pointer hover:text-rose-400">
                                <span>
                                    <span>Niveau(x) </span>
                                    <span>{{ $school->level }}</span>  
                                </span>
                            </h5>
                            <h5 class="flex justify-end cursor-pointer hover:text-rose-400 items-center ">
                                <span class="">
                                    <span>Plus de </span>
                                    <span class="fas fa-users mr-1"></span>
                                    <span>{{ __formatNumber3($school->capacity) }}</span>  
                                    <span>apprenants</span>
                                </span>
                            </h5>
                            <h5 class="">
                                <h6 class="py-1.5">Des images de {{ $school->simple_name }} : </h6>
                                <div class="w-full grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @foreach ($school->images as $key => $image)
                                        <div class="group relative border rounded overflow-hidden" style="z-index: 40 !important;" x-data="{ show: false }"
                                            x-init="setTimeout(() => show = true, {{ $key * 100 }})"
                                            x-show="show"
                                            x-transition:enter="transition ease-out duration-500"
                                            x-transition:enter-start="opacity-0 scale-90"
                                            x-transition:enter-end="opacity-100 scale-100">
                                            <img src="{{ url('storage', $image) }}" class="object-cover w-full h-32" alt="Image ">
                                            @if($school->user_id == auth_user_id() || auth_user()->isMaster() || auth_user()->hasSchoolRoles($school->id, ['schools-manager']))
                                            <span wire:click="removeImage('{{$image}}', '{{$school->id}}')"
                                                class="absolute inset-0 bg-red-600 bg-opacity-50 text-white text-xs font-semibold opacity-0 group-hover:opacity-70 transition duration-300 flex items-center justify-center cursor-pointer">
                                                <span wire:loading.remove wire:target="removeImage('{{$image}}', '{{$school->id}}')">✖ Retirer cette image</span>
                                                <span wire:loading wire:target="removeImage('{{$image}}', '{{$school->id}}')">
                                                    <span  class="fas fa-rotate animate-spin"></span>
                                                    <span>Suppression ...</span>
                                                </span>
                                            </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </h5>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if(auth_user()->id == $user->id)
    <div class="max-w-3xl card mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-lg shadow-2xl">
        <div class="flex justify-between items-center p-2">
            <h3 class="letter-spacing-1 font-bold text-xl p-4 text-amber-400 underline underline-offset-3 w-full border-b-amber-400">
                <span># Mes assistants</span>
            </h3>
            
            <div class="flex gap-x-2 text-sm">
                <a type="button" wire:click='openAddAssistantModal' class="text-black cursor-pointer bg-indigo-300 w-auto focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-indigo-500 focus:ring-yellow-800" type="button">
                    <span wire:loading.remove wire:target='openAddAssistantModal' class="w-full flex items-center px-1.5">
                        <span class="fas fa-pen mr-1"></span>
                        Ajouter
                    </span>
                    <span wire:loading wire:target='openAddAssistantModal' class="w-full flex items-center px-1.5">
                        <span class="fas fa-rotate animate-spin"></span>
                        En cours...
                    </span>
                </a>
                <a href="#" class="text-black cursor-pointer bg-yellow-300 w-auto focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                    <span class="w-full flex items-center px-1.5">
                        <span class="fas fa-pen mr-1"></span>
                        Editer
                    </span>
                </a>
            </div> 
        </div>
       
    </div>
    @endif

    
    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        class="fixed inset-0 bg-black/85 flex flex-col items-center justify-center z-50"
        style="display: none;"
        @click="show = false"
    >
        <h5 class="mx-auto flex flex-col gap-y-1 text-lg w-auto text-center py-3 font-semibold letter-spacing-1 bg-gray-950 my-3" >
            <span class=" text-sky-500 uppercase" x-text="userName"></span>
            <span class=" text-yellow-500" x-text="email"></span>
        </h5>
        <img :src="currentImage" alt="Zoom" class="w-screen md:max-w-xl max-h-[90vh] rounded shadow-xl border-2 border-white" @click.stop>
        
    </div>
</div>
