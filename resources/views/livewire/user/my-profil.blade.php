<div class="w-full max-w-[85rem] py-3 px-4 mx-auto shadow-3 shadow-sky-500 rounded-xl my-2" x-data="{ show: false, currentImage: '', userName: '', email: '' }">
    <div class="max-w-4xl card mx-auto mt-10">
        <h5 class="text-amber-500 bg-black/75 py-4 px-2 rounded-lg letter-spacing-1 font-bold text-xl flex flex-col justify-start gap-y-1">
            <span># Profil utilisateur</span>
            <span class="text-sm text-green-500 ml-4"> {{$user_email}} </span>
        </h5>
    </div>
    <div class="max-w-4xl card mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-xl shadow-2xl">
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
                    @if(count($user->quotes) > 0)
                        @if($user->quote)
                        <span>
                            <span class="fas fa-quote-left"></span>
                            {{ $user->quote->content }}
                            <span class="fas fa-quote-right"></span>
                        </span>
                        @else
                            <span class="text-gray-400 opacity-75 italic">Aucune citation publiée n'est' active!</span>
                        @endif
                    @else
                        <span class="text-gray-400 opacity-75 italic">Aucune citation publiée!</span>
                    @endif
                </blockquote> 
            </div>
            
        </div>
    
        <!-- Menu -->
        <div class="px-6 pb-4 overflow-x-auto">
            <div class="text-xs sm:text-sm mt-4 md:mt-0 flex gap-x-2 justify-stat">
                @auth
                    @if(auth_user()->id == $user->id)

                        @if(count($user->schools))
                            <a href="{{$user->to_my_current_school_profil_route()}}"  class=" text-black cursor-pointer bg-amber-500 focus:outline-none font-medium rounded-lg px-3 py-2 text-center hover:bg-amber-800 focus:ring-amber-800" type="button">
                                <span class="fas fa-school"></span>
                                Mon école
                            </a>
                        @endif

                        @if(count($user->schools))
                            <a href="{{$user->to_my_assistants_list_route()}}"  class=" text-white cursor-pointer bg-indigo-500 focus:outline-none font-medium rounded-lg px-3 py-2 text-center hover:bg-indigo-800 focus:ring-indigo-800" type="button">
                                <span class="fas fa-users-gear"></span>
                                Mes assistants
                            </a>
                        @endif

                        @if(count($user->my_directors))
                            <a href="{{$user->to_my_receiveds_assistants_requests_list_route()}}"  class=" text-white cursor-pointer bg-amber-500 focus:outline-none font-medium rounded-lg px-3 py-2 text-center hover:bg-amber-800 focus:ring-amber-800" type="button">
                                <span class="fas fa-person-chalkboard"></span>
                                Mes assistés
                            </a>
                        @endif
                    
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
    <div class="max-w-4xl card mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-lg shadow-2xl">
        <div class="flex justify-between items-center p-2 text-sm">
            <h3 class="letter-spacing-1 font-bold text-xl p-4 text-amber-400 underline underline-offset-3 w-full border-b-amber-400">
                <span># Détails personnels</span>
            </h3>
            @auth
                @if(auth_user()->id == $user->id)
                <a href="{{$user->to_profil_edit_route()}}" class="text-black cursor-pointer bg-yellow-300 w-auto focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800 flex">
                    <span class="fas fa-user-pen mr-1"></span>
                    <span>Modifier</span>
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

    <div class="max-w-4xl mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-lg shadow-2xl card">
        <div class="flex justify-between items-center p-2">
            <h3 class="letter-spacing-1 font-bold text-lg p-4 text-amber-400 underline underline-offset-3 w-full border-b-amber-400">
                <span># Mes Abonnements (actifs) </span>
            </h3>
            @auth
                @if(auth_user()->id == $user->id)
                <div class="flex gap-x-2 text-sm">
                    <a href="{{$user->to_subscribes_route()}}" class="text-black cursor-pointer bg-indigo-300 w-auto focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-indigo-500 focus:ring-yellow-800">
                        <span class="w-full flex items-center px-1.5">
                            <span class="fas fa-eye mr-1"></span>
                            Parcourir
                        </span>
                    </a>
                    @if(!($user->non_validated_upgrade_request && $user->non_validated_subscription))
                    <button wire:click="upgradeSubscription({{$user->current_subscription->id}})" class="text-black cursor-pointer bg-green-500 w-auto focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-green-700 focus:ring-yellow-800" type="button">
                        <span wire:loading.remove wire:target="upgradeSubscription({{$user->current_subscription->id}})" class="w-full flex items-center px-1.5">
                            <span class="fas fa-up-long mr-1"></span>
                            prolonger
                        </span>
                        <span wire:loading wire:target="upgradeSubscription({{$user->current_subscription->id}})" class="w-full flex items-center px-1.5">
                            <span class="fas fa-arrows-rotate mr-1"></span>
                            En cours...
                        </span>
                    </button>
                    @endif
                    @if(!$user->current_subscription)
                    <a href="{{route('packs.page')}}" class="text-black cursor-pointer bg-yellow-300 w-auto focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                        <span class="w-full flex items-center px-1.5">
                            <span class="fas fa-shopify mr-1"></span>
                            Souscrire
                        </span>
                    </a>
                    @endif
                </div>
                @endif
            @endauth
        </div>
        @auth
            @if(auth_user()->id == $user->id)
            <div class="p-4">
                @if($user->current_subscription)
                    <h5 class="letter-spacing-1 font-semibold text-green-800 bg-green-300 rounded-sm p-2 text-sm">
                        Vous avez un abonnement actif
                        <a href="{{ $user->current_subscription->to_details_route() }}" class="underline hover:text-gray-400 underline-offset-2 ml-2"> #{{ $user->current_subscription->ref_key }} </a>
                    </h5>
                    <div>
                        @php
                            $subscription = $user->current_subscription;
                        @endphp
                        <h6 class="py-2 letter-spacing-1 font-semibold text-green-400  border border-yellow-500 bg-black/60 my-2 letter-spacing-2 flex flex-col gap-y-1">
                            <span class="uppercase text-center">Abonnement : #{{ $subscription->ref_key }}</span>
                            <span class="text-center">
                                <span class="text-sm font-thin letter-spacing-1 text-gray-400">
                                    <span>
                                        Souscrit le {{__formatDate($subscription->created_at) }}
                                    </span>
                                    <span> - </span>
                                    <span>
                                        Validé le {{ __formatDate($subscription->validate_at) }}
                                    </span>
                                    <span> - </span>
                                    @if($subscription->remainingsDays > 0)
                                    <span>
                                        Expire le {{__formatDate($subscription->will_closed_at) }}
                                        <span>Soit dans {{ str_replace('restants', '', __formatDateDiff($subscription->will_closed_at)) }}</span>
                                    </span>
                                    @else
                                    <span>
                                        Expiré depuis le {{__formatDate($subscription->will_closed_at) }}
                                        <span>Il y a déjà {{ str_replace('restants', '', __formatDateDiff($subscription->will_closed_at)) }}</span>
                                    </span>
                                    @endif
                                </span>
                            </span>
                            <div class="font-semibold letter-spacing-1 hidden">
                                <h5 class="p-3 my-2 border-y-2 border-y-amber-500 bg-black/60 text-center uppercase">Les privilèges 
                                    <span class="text-amber-500"></span> 
                                </h5>
                                <div class="flex flex-col gap-1.5 px-2">
                                    @foreach ($subscription->privileges as $pr)
                                        <span class="cursor-pointer flex items-center gap-x-2 hover:text-amber-500">
                                            <span class="fas fa-check-to-slot text-sm"></span>
                                            <span>{{ $pr }}</span>
                                        </span> 
                                    @endforeach
                                </div>
                            </div>
                        </h6>
                    </div>
                @else
                    <h5 class="letter-spacing-1 font-semibold text-red-800 bg-red-300 rounded-sm p-2">
                        Vous n'avez aucun abonnement actif présentement
                    </h5>
                @endif
            </div>
            @endif
        @endauth
    </div>

    <div class="max-w-4xl card mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-lg shadow-2xl">
        <div class="flex justify-between items-center p-2">
            <h3 class="letter-spacing-1 font-bold text-lg p-4 text-amber-400 underline underline-offset-3 border-b-amber-400">
                <span># Ecole administrée</span>
            </h3>
            @auth
                @if(auth_user()->id == $user->id)
                <div class="flex text-xs md:text-sm">
                    @if(!$user->current_school)
                    <a href="{{auth_user()->to_create_school_route()}}" class="text-black cursor-pointer bg-indigo-300 font-medium rounded-lg px-2 w-auto py-2 text-center hover:bg-indigo-500 ">
                        <span class="flex items-center px-1.5">
                            <span class="fas fa-plus mr-1"></span>
                            Créer
                        </span>
                    </a>
                    @else
                    <a href="{{$user->current_school->to_school_update_route()}}" class="text-black cursor-pointer bg-indigo-300 font-medium rounded-lg px-2 py-2 text-center hover:bg-indigo-500 w-auto">
                        <span class="flex items-center px-1.5 ">
                            <span class="fas fa-edit mr-1"></span>
                            <span>Editer mon école</span>
                        </span>
                    </a>
                    @endif
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
                            <a class="hover:text-pink-300 hover:underline hover:underline-offset-2" href="{{$school->to_profil_route()}}">
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
                            <div class="mt-3">
                                <h6 class="py-1.5 text-lg text-amber-500">Des images de {{ $school->simple_name }} : </h6>
                                <div class="w-full grid grid-cols-2 md:grid-cols-3 gap-2">
                                    @foreach ($school->images as $key => $image)
                                        <div class="group relative border rounded overflow-hidden" style="z-index: 20 !important;" x-data="{ show: false }"
                                            x-init="setTimeout(() => show = true, {{ $key * 100 }})"
                                            x-show="show"
                                            x-transition:enter="transition ease-out duration-500"
                                            x-transition:enter-start="opacity-0 scale-90"
                                            x-transition:enter-end="opacity-100 scale-100">
                                            <img src="{{ url('storage', $image->path) }}" class="object-cover w-full h-32" alt="Image ">
                                            @if($school->user_id == auth_user_id() || auth_user()->isMaster() || auth_user()->hasSchoolRoles($school->id, ['schools-manager']))
                                            <span wire:click="removeImage('{{$image->id}}', '{{$school->id}}')"
                                                class="absolute inset-0 bg-red-600 bg-opacity-50 text-white text-xs font-semibold opacity-0 group-hover:opacity-70 transition duration-300 flex items-center justify-center cursor-pointer">
                                                <span wire:loading.remove wire:target="removeImage('{{$image->id}}', '{{$school->id}}')">✖ Retirer cette image</span>
                                                <span wire:loading wire:target="removeImage('{{$image->id}}', '{{$school->id}}')">
                                                    <span  class="fas fa-rotate animate-spin"></span>
                                                    <span>Suppression ...</span>
                                                </span>
                                            </span>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </div>

                            <div class="mt-2">
                                <h6 class="py-1.5 text-lg text-amber-400">Des vidéos de {{ $school->simple_name }} : </h6>
                                <div class="grid grid-cols-1 md:grid-cols-2 mb-4 gap-2 card">
                                    @foreach ($school->videos as $school_video)
                                        @if($school_video->subscription?->is_active)
                                            <div class="border border-purple-500">
                                                <div class="aspect-square bg-gray-100 relative group card">
                                                    <video alt="Vidéo N° {{$loop->iteration}} de l'école" controls class="w-full h-full object-cover border shadow-sm">
                                                        <source src="{{url('storage', $school_video->path)}}" type="video/mp4">
                                                        Votre navigateur ne supporte pas la lecture vidéo.
                                                    </video>

                                                    <div  class="absolute top-2 left-1 items-center cursor-pointer bg-black/90 text-white inline-flex p-3 text-center  justify-center bg-opacity-70 opacity-80  group-hover:text-sky-400 group-hover:opacity-100 group-hover:bg-opacity-100 transition-all duration-200">
                                                        <div class="flex space-x-4 cursor-pointer text-center letter-spacing-2 text-xs">
                                                            <span class="text-center"> 
                                                                @if($school_video->title)
                                                                    {{ $school_video->title }} 
                                                                @else
                                                                    Vidéo N° {{ $loop->iteration }}
                                                                @endif
                                                            </span>
                                                        </div>
                                                    </div>
                                                    
                                                </div>
                                                @auth
                                                    @if(__ensureThatAssistantCan(auth_user_id(), $school->id, ['school-images-manager']))
                                                        <div class="mt-1 grid grid-cols-3 gap-x-1 p-1">
                                                            <span wire:click="removeVideoFromVideosOf('{{$school_video->id}}', '{{$school->id}}')" title="Supprimer cette vidéo de la liste des vidéos de l'école {{$school->simple_name}}" class="py-2 hover:bg-red-500 text-center text-xs md:text-sm bg-red-300 text-red-800 cursor-pointer inline-block col-span-2 font-semibold">
                                                                <span wire:loading.remove wire:target="removeVideoFromVideosOf('{{$school_video->id}}', '{{$school->id}}')">
                                                                    <span class="fas fa-trash mr-0.5"></span>
                                                                    Retirer cette vidéo
                                                                </span>
                                                                <span wire:loading wire:target="removeVideoFromVideosOf('{{$school_video->id}}', '{{$school->id}}')">
                                                                    <span>Suppression en cours...</span>
                                                                    <span class="fas fa-rotate animate-spin"></span>
                                                                </span>
                                                            </span>
                                                            <span wire:click="manageVideo('{{$school_video->id}}', '{{$school->id}}')" title="Editer le titre de cette image de l'école {{$school->simple_name}}" class="py-2 hover:bg-blue-700 text-center text-xs md:text-sm bg-blue-500 text-blue-100 cursor-pointer inline-block col-span-1 font-semibold">
                                                                <span wire:loading.remove wire:target="manageVideo('{{$school_video->id}}', '{{$school->id}}')">
                                                                    <span class="fas fa-pen mr-0.5"></span>
                                                                    Editer
                                                                </span>
                                                                <span wire:loading wire:target="manageVideo('{{$school_video->id}}', '{{$school->id}}')">
                                                                    <span>Patientez...</span>
                                                                    <span class="fas fa-rotate animate-spin"></span>
                                                                </span>
                                                            </span>
                                                        </div>
                                                    @endif
                                                @endauth
                                            </div>
                                        @endif
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>

    @if(auth_user()->id == $user->id)
    <div class="max-w-4xl card mx-auto mt-5 shadow-gray-900 border border-sky-400 bg-black/70 rounded-lg shadow-2xl">
        <div class="flex justify-between items-center p-2">
            <h3 class="letter-spacing-1 font-bold text-lg p-4 text-amber-400 underline underline-offset-3 border-b-amber-400">
                <span># Mes assistants</span>
            </h3>
            
            <div class="flex gap-x-2 text-sm">
                <a href="{{$user->to_my_assistants_list_route()}}" class="text-black cursor-pointer bg-indigo-300 w-auto focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-indigo-500 focus:ring-yellow-800 flex" type="button">
                    <span class="fas fa-users mr-1"></span>
                    <span>Mes assistants</span>
                </a>
                <button wire:click='generateAssistantTokenFor' class="flex text-black cursor-pointer bg-green-400 focus:ring-2 focus:outline-none font-medium rounded-lg px-5 py-2 text-center hover:bg-green-800 focus:ring-green-800" type="button">
                    <span wire:loading.remove wire:target='generateAssistantTokenFor'>
                        <span class="fas fa-key mr-1"></span>
                        Ajouter un assistant
                    </span>
                    <span wire:loading wire:target='generateAssistantTokenFor'>
                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                        <span>Un instant, en cours...</span>
                    </span>
                </button>
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
