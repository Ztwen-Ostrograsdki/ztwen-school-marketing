<div class="w-full max-w-[85rem] py-3 px-4 mx-auto my-2" x-data="{ show: false, currentImage: '', schoolName: '', simple_name: '', title: '' }">
        
    <div class="card mx-auto mt-10 shadow-gray-900 bg-black/20">
        <h5 class="card letter-spacing-1 flex bg-black/70 text-center mx-auto flex-col gap-y-2 text-gray-200 rounded-sm">
            <p class="py-2 relative inline-block text-transparent bg-clip-text text-xl font-bold letter-spacing-2 from-indigo-700 via-lime-500 to-blue-700 bg-linear-to-r"> 
                <span class="card absolute -top-1 left-0 w-full to-lime-400 via-amber-500 from-sky-900 bg-linear-to-r h-1 rounded-full"></span>
                <span class="uppercase px-3">
                    <span>Bienvenue sur la page de l'école</span> 
                    <span class="uppercase text-orange-500"> 
                        <span>
                            {{$school_name}}
                            (<span class="text-sky-500">{{ $simple_name }}</span>)
                        </span>
                    </span>
                </span>
                <span class="text-sm block text-yellow-400 font-mono mt-2"> Une école {{ $school->getSchoolType() }}</span>
                <span class="block text-sm my-2 px-3">
                    {{ $school->quotes }}
                </span>
                <span class="card absolute -bottom-1 left-0 w-full from-lime-400 via-amber-500 to-sky-900 bg-linear-to-r h-1 rounded-full"></span>
            </p>
        
        </h5>
    </div>
    <div class="mx-auto pb-10 mt-6 bg-transparent flex flex-col gap-y-20  overflow-hidden">
        <div class="p-6 card shadow-xl shadow-gray-900 rounded-lg bg-cover bg-center  w-full bg-gray-600 bg-blend-multiply" style="background-image: url('{{ asset('storage/' .  $school->profilImage) }}')">
            <h5 class="text-sky-400 text-sm sm:text-xl  font-semibold letter-spacing-1 pb-4 flex justify-between items-center">
                <span>
                    #Auteur | fondateur
                    <span class="fas fa-user-shield ml-1"></span>
                </span>

                @auth
                    @if($school->id !== auth_user_id() && auth_user()->assist_this_school($school->id))
                        <span class="text-sm">
                            <small class="rounded-md bg-green-300 p-2 text-green-700">Vous assisté cette école</small>
                        </span>
                    @endif
                @endauth
                    
            </h5>
            
            <div class="flex items-center space-x-4">
                <div class="flex-shrink-0" @click="currentImage = '{{ user_profil_photo($school->user) }}'; schoolName = 'Auteur : {{ $school->user->getFullName() }}'; title = 'photo profil auteur'; simple_name = 'Ecole : {{ $school_name }}'; show = true">
                    <img class="h-20 w-20 md:h-32 md:w-32 rounded-full object-cover border-2 border-amber-500 cursor-pointer" src="{{user_profil_photo($school->user)}}" alt="Image de profil de l'auteur">
                </div>
                <div class="flex-1 min-w-0">
                    <a href="{{$school->user->to_profil_route()}}" class="text-sm md:text-lg font-bold text-amber-600 truncate hover:text-gray-400">
                        {{ $school->user?->getFullName() }}
                    </a>
                    @if($school->current_subscription?->is_active)
                    <p class="text-sm text-gray-400 truncate">
                        {{ $school->user?->email }}
                    </p>
                    <p class="text-gray-400 truncate">
                        {{ $school->user?->address }}
                    </p>
                    <p class="text-gray-400 truncate">
                        {{ $school->user?->contacts }}
                    </p>
                    @endif
                    <div class="flex space-x-4 mt-2">
                        <span class="text-sm font-medium text-gray-400">
                            {{ $school->posts_counter }}
                        <span class="font-normal text-gray-400">posts</span></span>
                        <span class="text-sm font-medium text-gray-400">
                            @auth
                                @if(auth_user_id( ) == $school->user->id)
                                    {{ __zero(count($school->followers)) }}
                                @else
                                12.8k
                                @endif
                            @else
                            12.8k 
                            @endauth
                        <span class="font-normal text-gray-400">followers</span></span>
                    </div>
                </div>
            </div>
            <div class="mt-4">
                
            </div>
            <div class="px-6 mt-6 overflow-x-auto card">
                <div class="text-xs sm:text-sm mt-4 md:mt-0 flex flex-wrap gap-3 justify-start ">
                    @auth
                        @if($school->user_id == auth_user_id())
                        <a href="{{$school->to_school_update_route()}}" class="block text-white cursor-pointer bg-green-500 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-green-800 focus:ring-green-800" type="button">
                            <span>
                                <span class="fas fa-pen mr-1"></span>
                                Editer mon école
                            </span>
                        </a>
                        <a href="{{$school->user->to_profil_route()}}" class="block text-black cursor-pointer bg-yellow-300 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                            <span>
                                <span class="fas fa-home mr-1"></span>
                                Mon profil
                            </span>
                        </a>
                        @if($school->subscribing())
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
                        @endif
                        @endif
                        @if(__ensureThatAssistantCan(auth_user_id(), $school->id, ['stats-manager']))
                        <button title="Enregistrer une statistique" wire:click="manageSchoolStat" class="cursor-pointer shadow-sm bg-blue-500 hover:bg-blue-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                            <span wire:loading.remove wire:target="manageSchoolStat">
                                <span class="fas fa-chart-simple"></span>
                                <span>Ajouter stats</span>
                            </span>
                            <span wire:loading wire:target="manageSchoolStat">
                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                <span>En cours...</span>
                            </span>
                        </button>
                        @endif
                        @if(__ensureThatAssistantCan(auth_user_id(), $school->id, ['infos-manager']))
                        <button title="Enregistrer une info, un offre..." wire:click="addNewSchoolInfo" class="cursor-pointer shadow-sm bg-purple-400 hover:bg-purple-700 text-black font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                            <span wire:loading.remove wire:target="addNewSchoolInfo">
                                <span class="fas fa-newspaper"></span>
                                <span>Ajouter infos</span>
                            </span>
                            <span wire:loading wire:target="addNewSchoolInfo">
                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                <span>En cours...</span>
                            </span>
                        </button>
                        @endif
                        
                        @if($school->user_id == auth_user_id())
                        <button class="bg-red-600 cursor-pointer hover:bg-red-800 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                            <span class="fas fa-trash mr-1"></span>
                            Suppr. les assistants.
                        </button>
                        @endif
                        
                    @endauth
                    
                    <button class="bg-green-600 cursor-pointer hover:bg-green-800 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                        <span class="fas fa-message mr-1"></span>
                        Message
                    </button>

                    @if($school->user_id !== auth_user_id())
                    <button wire:click="likeAndFollow" class="bg-rose-400 cursor-pointer hover:bg-rose-700 text-black font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                        <span wire:loading.remove wire:target="likeAndFollow">
                                <span class="fas fa-thumbs-up mr-1"></span>
                                Suivre | Aimer
                            </span>
                            <span wire:loading wire:target="likeAndFollow">
                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                <span>En cours...</span>
                            </span>
                    </button>
                    @endif
                </div>
            </div>
        </div>

        <div class="p-6 card text-sm shadow-xl bg-black/60 shadow-gray-900 rounded-lg">
            <div class="px-6 mt-2 overflow-x-auto card">
                <h5 class="text-sky-400 text-sm sm:text-xl  font-semibold letter-spacing-1 pb-4"># Contenu de la page</h5>
                <div class="text-xs sm:text-sm mt-4 md:mt-0 flex flex-wrap gap-3 justify-start ">
                    <a href="#school_description" class="block text-black cursor-pointer bg-yellow-300 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                        <span>
                            <span class="fas fa-images mr-1"></span>
                            #L'école en description
                        </span>
                    </a>
                    <a href="#school_images" class="block text-black cursor-pointer bg-yellow-500 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                        <span>
                            <span class="fas fa-images mr-1"></span>
                            #L'école en images
                        </span>
                    </a>

                    @if($school->current_subscription?->max_videos > 0)
                    <a href="#school_videos" class="block text-black cursor-pointer bg-yellow-500 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-yellow-500 focus:ring-yellow-800" type="button">
                        <span>
                            <span class="fas fa-images mr-1"></span>
                            #Des vidéos
                        </span>
                    </a>
                    @endif

                    <a href="#school_stats" class="block text-black cursor-pointer bg-amber-700 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-amber-700 focus:ring-amber-800" type="button">
                        <span>
                            <span class="fas fa-chart-simple mr-1"></span>
                            # Les statistiques
                        </span>
                    </a>
                    <a href="#school_infos" class="block text-black cursor-pointer bg-orange-400 focus:ring-4 focus:outline-none font-medium rounded-lg px-2 py-2 text-center hover:bg-orange-500 focus:ring-orange-800" type="button">
                        <span>
                            <span class="fas fa-newspaper mr-1"></span>
                            # Communiqués
                        </span>
                    </a>
                </div>
            </div>
        </div>


        <div id="school_description" class="p-6 card text-sm shadow-xl bg-black/60 shadow-gray-900 rounded-lg">
            <div class="px-6 mt-2 overflow-x-auto card">
                <h5 class="text-sky-400 text-sm sm:text-xl  font-semibold letter-spacing-1 pb-4"># Description de l'école 
                    <span class="text-gray-400 hover:text-rose-300 underline underline-offset-4">{{ $school_name }}</span>
                </h5>
                <div class="text-xs md:text-lg">
                    <p>
                        Située au {{ $school->geographic_position }} du {{ $school->country }} dans le département de {{ $school->department }}, plus précisement dans la ville de {{ $school->city }}, l'école (<span class="lowercase">{{ $school->getSchoolType() }}</span>) <span class="text-yellow-400 font-bold">{{ $school_name }}</span> a été fondée en {{ $school->creation_year }} par <span class="text-sky-500 font-bold">{{ $school->created_by }}</span>.
                        <br>
                    </p>
                    <p class="mb-3.5">
                        L'école, dépuis sa création acceuille en moyenne plus de <span class="text-amber-500 font-semibold">{{ __formatNumber3($school->capacity) }}</span> apprenants.
                        Reconnue par ses <a href="#school_stats" class="underline underline-offset-3 hover:text-rose-300">statistiques remarquables aux différents examens</a>, il va sans doute, que <span class="text-yellow-400 font-bold">{{ $school_name }}</span> est une école de reférence pour garantir un avenir meillleur à la jeunesse de la nation.
                    </p>
                    @if($school->current_subscription?->is_active)
                    <h5 class="flex justify-end cursor-pointer hover:text-rose-400 mt-3.5">
                        <span>
                            <span class="fas fa-phone mr-1"></span>
                            <span>Contacts : </span>
                            <span class="">{{ $school->contacts }}</span>
                        </span>
                    </h5>
                    @endif
                </div>
            </div>
        </div>
    
        <!-- Posts Grid -->
        <div id="school_images" class="text-sm p-6 shadow-xl bg-black/60 shadow-gray-900 rounded-lg">
            <h5 class="text-sky-400 text-sm sm:text-xl font-semibold flex justify-between letter-spacing-1 pb-4"># L'école en images
               <div class="flex gap-x-2 justify-start text-xs sm:text-sm">
                    @auth
                        @if(__ensureThatAssistantCan(auth_user_id(), $school->id, ['school-images-manager']))
                            <button title="Ajouter des images..." wire:click="addImages" class="cursor-pointer shadow-sm bg-blue-400 hover:bg-blue-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                                <span wire:loading.remove wire:target="addImages">
                                    <span class="fas fa-images"></span>
                                    <span>Ajouter</span>
                                </span>
                                <span wire:loading wire:target="addImages">
                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                    <span>En cours...</span>
                                </span>
                            </button>
                            @if($school->hasImages())
                            <button title="Supprimer toutes les images..." wire:click="removeAllImages" class="cursor-pointer shadow-sm bg-red-500 hover:bg-red-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                                <span wire:loading.remove wire:target="removeAllImages">
                                    <span class="fas fa-trash"></span>
                                    <span>Supprimer</span>
                                </span>
                                <span wire:loading wire:target="removeAllImages">
                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                    <span>En cours...</span>
                                </span>
                            </button>
                            @endif
                        @endif
                    @endauth
               </div>
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-3 my-4 gap-1 card">
                @foreach ($school->images as $school_image)
                    @if($school_image->subscription?->is_active)
                        <div class="border border-purple-500">
                            <div class="aspect-square bg-gray-100 relative group card">
                                <img class="w-full h-full object-cover border shadow-sm" src="{{url('storage', $school_image->path)}}" alt="Image N° {{$loop->iteration}} de l'école">
                                <div  class="absolute top-2 left-1 items-center cursor-pointer bg-black/90 text-white inline-flex p-3 text-center  justify-center bg-opacity-70 opacity-80  group-hover:text-sky-400 group-hover:opacity-100 group-hover:bg-opacity-100 transition-all duration-200">
                                    <div class="flex space-x-4 cursor-pointer text-center letter-spacing-2 text-xs">
                                        <span class="text-center"> 
                                            @if($school_image->title)
                                                {{ $school_image->title }} 
                                            @else
                                                Image N° {{ $loop->iteration }}
                                            @endif
                                        </span>
                                    </div>
                                </div>
                                <div  @click="currentImage = '{{ url('storage', $school_image->path) }}'; schoolName = 'image N° {{$loop->iteration}} de {{ $school_name }}'; simple_name = '{{ $simple_name }}'; title = '{{ $school_image->title }}'; show = true" class="absolute cursor-pointer inset-0 bg-black/75 bg-opacity-0 group-hover:bg-opacity-30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-all duration-200">
                                    <div class="flex space-x-4 cursor-pointer text-sky-600 text-center letter-spacing-1 font-semibold text-xs">
                                        <span class="text-center">Cliquer pour agrandir cette image</span>
                                    </div>
                                </div>
                            </div>
                            @auth
                                @if(__ensureThatAssistantCan(auth_user_id(), $school->id, ['school-images-manager']))
                                    <div class="mt-1 grid grid-cols-3 gap-x-1 p-1">
                                        <span wire:click="removeImageFromImagesOf('{{$school_image->id}}')" title="Supprimer cette image de la liste des images de l'école {{$school_name}}" class="py-2 hover:bg-red-500 text-center text-xs md:text-sm bg-red-300 text-red-800 cursor-pointer inline-block col-span-2 font-semibold">
                                            <span wire:loading.remove wire:target="removeImageFromImagesOf('{{$school_image->id}}')">
                                                <span class="fas fa-trash mr-0.5"></span>
                                                Retirer cette image
                                            </span>
                                            <span wire:loading wire:target="removeImageFromImagesOf('{{$school_image->id}}')">
                                                <span>Suppression en cours...</span>
                                                <span class="fas fa-rotate animate-spin"></span>
                                            </span>
                                        </span>
                                        <span wire:click="manageImageTitle('{{$school_image->id}}')" title="Editer le titre de cette image de l'école {{$school_name}}" class="py-2 hover:bg-blue-700 text-center text-xs md:text-sm bg-blue-500 text-blue-100 cursor-pointer inline-block col-span-1 font-semibold">
                                            <span wire:loading.remove wire:target="manageImageTitle('{{$school_image->id}}')">
                                                <span class="fas fa-pen mr-0.5"></span>
                                                Editer titre
                                            </span>
                                            <span wire:loading wire:target="manageImageTitle('{{$school_image->id}}')">
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
        
        @if($school->current_subscription?->max_videos > 0)
        <div id="school_videos" class="text-sm p-6 shadow-xl bg-black/60 shadow-gray-900 rounded-lg">
            <h5 class="text-sky-400 text-sm sm:text-xl font-semibold flex justify-between letter-spacing-1 pb-4">#Des vidéos de l'école
               <div class="flex gap-x-2 justify-start text-xs sm:text-sm">
                    @auth
                        @if(__ensureThatAssistantCan(auth_user_id(), $school->id, ['school-images-manager']))
                            <button title="Ajouter des vidéos..." wire:click="addVideos" class="cursor-pointer shadow-sm bg-blue-400 hover:bg-blue-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                                <span wire:loading.remove wire:target="addVideos">
                                    <span class="fas fa-video"></span>
                                    <span>Ajouter</span>
                                </span>
                                <span wire:loading wire:target="addVideos">
                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                    <span>En cours...</span>
                                </span>
                            </button>
                            @if($school->hasVideos())
                            <button title="Supprimer toutes les videos..." wire:click="removeAllVideos" class="cursor-pointer shadow-sm bg-red-500 hover:bg-red-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                                <span wire:loading.remove wire:target="removeAllVideos">
                                    <span class="fas fa-trash"></span>
                                    <span>Supprimer</span>
                                </span>
                                <span wire:loading wire:target="removeAllVideos">
                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                    <span>En cours...</span>
                                </span>
                            </button>
                            @endif
                        @endif
                    @endauth
               </div>
            </h5>
            <div class="grid grid-cols-1 md:grid-cols-3 my-4 gap-1 card">
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
                                        <span wire:click="removeVideoFromVideosOf('{{$school_video->id}}')" title="Supprimer cette vidéo de la liste des vidéos de l'école {{$school_name}}" class="py-2 hover:bg-red-500 text-center text-xs md:text-sm bg-red-300 text-red-800 cursor-pointer inline-block col-span-2 font-semibold">
                                            <span wire:loading.remove wire:target="removeVideoFromVideosOf('{{$school_video->id}}')">
                                                <span class="fas fa-trash mr-0.5"></span>
                                                Retirer cette vidéo
                                            </span>
                                            <span wire:loading wire:target="removeVideoFromVideosOf('{{$school_video->id}}')">
                                                <span>Suppression en cours...</span>
                                                <span class="fas fa-rotate animate-spin"></span>
                                            </span>
                                        </span>
                                        <span wire:click="manageVideo('{{$school_video->id}}')" title="Editer le titre de cette image de l'école {{$school_name}}" class="py-2 hover:bg-blue-700 text-center text-xs md:text-sm bg-blue-500 text-blue-100 cursor-pointer inline-block col-span-1 font-semibold">
                                            <span wire:loading.remove wire:target="manageVideo('{{$school_video->id}}')">
                                                <span class="fas fa-pen mr-0.5"></span>
                                                Editer
                                            </span>
                                            <span wire:loading wire:target="manageVideo('{{$school_video->id}}')">
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
        @endif

        <div id="school_stats" class="text-sm p-6 shadow-xl bg-black/60 shadow-gray-900 rounded-lg">
            <h5 class="card text-sky-400 text-sm sm:text-xl  font-semibold letter-spacing-1 pb-4">
                # Les statistiques de l'école aux examens
            </h5>
            <div class="flex justify-between gap-x-2 mb-3.5">
                <div class="justify-start">
                    <select class="bg-black/80 text-sky-300 font-semibold letter-spacing-1 rounded-md py-2" wire:model.live='selected_stat_year' name="selected_year" id="">
                        <option class="bg-gray-800" value="">Lister les stats par année</option>
                        @foreach ($stats_years as $ky => $yy)
                            <option class="bg-gray-800" value="{{$yy}}">{{ $yy }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="flex justify-end gap-x-2">
                    @auth
                       @if(__ensureThatAssistantCan(auth_user_id(), $school->id, ['stats-manager']))
                            <button title="Ajouter une stat..." wire:click="addNewSchoolStat" class="cursor-pointer shadow-sm bg-blue-400 hover:bg-blue-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                                <span wire:loading.remove wire:target="addNewSchoolStat">
                                    <span class="fas fa-chart-simple"></span>
                                    <span>Ajouter</span>
                                </span>
                                <span wire:loading wire:target="addNewSchoolStat">
                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                    <span>En cours...</span>
                                </span>
                            </button>
                            <button title="Rendre visibles toutes les stats..." wire:click="unhideAllStats" class="cursor-pointer shadow-sm bg-green-500 hover:bg-green-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                                <span wire:loading.remove wire:target="unhideAllStats">
                                    <span class="fas fa-eye"></span>
                                    <span>Rendre visible</span>
                                </span>
                                <span wire:loading wire:target="unhideAllStats">
                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                    <span>En cours...</span>
                                </span>
                            </button>
                            <button title="Masquer toutes les stats..." wire:click="hideAllStats" class="cursor-pointer shadow-sm bg-orange-500 hover:bg-orange-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                                <span wire:loading.remove wire:target="hideAllStats">
                                    <span class="fas fa-eye-slash"></span>
                                    <span>MAsquer</span>
                                </span>
                                <span wire:loading wire:target="hideAllStats">
                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                    <span>En cours...</span>
                                </span>
                            </button>
                            <button title="Supprimer toutes les stats..." wire:click="deleteAllStats" class="cursor-pointer shadow-sm bg-red-500 hover:bg-red-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                                <span wire:loading.remove wire:target="deleteAllStats">
                                    <span class="fas fa-trash"></span>
                                    <span>Supprimer</span>
                                </span>
                                <span wire:loading wire:target="deleteAllStats">
                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                    <span>En cours...</span>
                                </span>
                            </button>

                        @endif
                    @endauth
                </div>
            </div>
            @foreach ($school_stats as $yr => $stats)
                <div class="w-full flex flex-col  my-2.5">
                    <h5 class="text-center font-semibold letter-spacing-1 py-3 uppercase text-amber-500 rounded-lg border-y-2 border-y-sky-600">
                        Les examens de l'année {{ $yr }}
                    </h5>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 card my-6">
                        @foreach($stats as $stat)
                            @if($stat->subscription?->is_active)
                                <div class="aspect-square shadow-inner shadow-sky-100 from-green-800 to-blue-900 via-sky-900 bg-linear-180 bg-black rounded-lg relative group card p-3 flex items-center justify-center flex-col font-bold letter-spacing-1 cursor-pointer hover:shadow-md hover:shadow-sky-400 gap-y-2 md:gap-y-5 ">
                                    <div>
                                        <h4 class="text-center text-lg md:text-3xl animate-pulse mb-3">
                                            {{ $stat->exam }} {{ $stat->year }}
                                        </h4>
                                        <h3 class="text-xl md:text-8xl text-center text-transparent bg-clip-text from-blue-300 via-yellow-400 to-gray-500 bg-linear-to-bl">
                                            <span class="fas"> 
                                                {{ __formatDecimal($stat->stat_value) }} </span>
                                            <span class="fas fa-percent"></span>
                                        </h3>
                                    </div>
                                    <div class="my-3 flex justify-end gap-x-2">
                                        @auth
                                            @if(__ensureThatAssistantCan(auth_user_id(), $school->id, ['stats-manager']))
                                                <button wire:click="manageSchoolStat({{$stat->id}})" class="cursor-pointer shadow-sm bg-blue-500 hover:bg-blue-700 text-white p-2">
                                                    <span wire:loading.remove wire:target="manageSchoolStat({{$stat->id}})">
                                                        <span class="fas fa-edit"></span>
                                                        <span>Modifier</span>
                                                    </span>
                                                    <span wire:loading wire:target="manageSchoolStat({{$stat->id}})">
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @if($stat->is_active)
                                                <button wire:click="hideSchoolStat({{$stat->id}})" class="cursor-pointer shadow-sm bg-orange-400 hover:bg-orange-600 text-white p-2">
                                                    <span wire:loading.remove wire:target="hideSchoolStat({{$stat->id}})">
                                                        <span class="fas fa-eye-slash"></span>
                                                        <span>Masquer</span>
                                                    </span>
                                                    <span wire:loading wire:target="hideSchoolStat({{$stat->id}})">
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @else
                                                <button wire:click="unhideSchoolStat({{$stat->id}})" class="cursor-pointer shadow-sm bg-green-400 hover:bg-green-600 text-white p-2">
                                                    <span wire:loading.remove wire:target="unhideSchoolStat({{$stat->id}})">
                                                        <span class="fas fa-eye-slash"></span>
                                                        <span>Rendre visible</span>
                                                    </span>
                                                    <span wire:loading wire:target="unhideSchoolStat({{$stat->id}})">
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>En cours...</span>
                                                    </span>
                                                </button>
                                                @endif
                                                <button wire:click="deleteSchoolStat({{$stat->id}})" class="cursor-pointer shadow-sm bg-red-500 hover:bg-red-700 text-white p-2">
                                                    <span wire:loading.remove wire:target="deleteSchoolStat({{$stat->id}})">
                                                        <span class="fas fa-trash"></span>
                                                        <span>Supprimer</span>
                                                    </span>
                                                    <span wire:loading wire:target="deleteSchoolStat({{$stat->id}})">
                                                        <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                        <span>Suppression...</span>
                                                    </span>
                                                </button>
                                                
                                            @endif
                                        @endauth
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            @endforeach
        </div>


        <div id="school_infos" class="text-sm p-6 shadow-xl bg-black/60 shadow-gray-900 rounded-lg">
            <h5 class="card text-sky-400 text-sm sm:text-xl  font-semibold letter-spacing-1 pb-4">
                # Les Infos et Communiqués
            </h5>
            <div class="flex justify-end gap-x-2">
                @auth
                    @if(__ensureThatAssistantCan(auth_user_id(), $school->id, ['infos-manager']))
                        <button title="Ajouter une info | communiqué | annonce..." wire:click="addNewSchoolInfo" class="cursor-pointer shadow-sm bg-blue-400 hover:bg-blue-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                            <span wire:loading.remove wire:target="addNewSchoolInfo">
                                <span class="fas fa-chart-simple"></span>
                                <span>Ajouter</span>
                            </span>
                            <span wire:loading wire:target="addNewSchoolInfo">
                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                <span>En cours...</span>
                            </span>
                        </button>
                        <button title="Rendre visibles toutes les infos | communiqués | annonces..." wire:click="unhideAllInfos" class="cursor-pointer shadow-sm bg-green-500 hover:bg-green-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                            <span wire:loading.remove wire:target="unhideAllInfos">
                                <span class="fas fa-eye"></span>
                                <span>Rendre visible</span>
                            </span>
                            <span wire:loading wire:target="unhideAllInfos">
                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                <span>En cours...</span>
                            </span>
                        </button>
                        <button title="Masquer toutes les infos | communiqués | annonces..." wire:click="hideAllInfos" class="cursor-pointer shadow-sm bg-orange-500 hover:bg-orange-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                            <span wire:loading.remove wire:target="hideAllInfos">
                                <span class="fas fa-eye-slash"></span>
                                <span>MAsquer</span>
                            </span>
                            <span wire:loading wire:target="hideAllInfos">
                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                <span>En cours...</span>
                            </span>
                        </button>
                        <button title="Supprimer toutes les infos | communiqués | annonces..." wire:click="deleteAllInfos" class="cursor-pointer shadow-sm bg-red-500 hover:bg-red-700 text-white font-medium py-2 px-2 rounded-lg transition duration-150 ease-in-out">
                            <span wire:loading.remove wire:target="deleteAllInfos">
                                <span class="fas fa-trash"></span>
                                <span>Supprimer</span>
                            </span>
                            <span wire:loading wire:target="deleteAllInfos">
                                <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                <span>En cours...</span>
                            </span>
                        </button>

                    @endif
                @endauth
            </div>
            <div class="flex flex-col gap-y-7 card my-4">
                @foreach($school_infos as $type => $infos)
                    <h5 class="text-center font-semibold letter-spacing-1 py-3 uppercase text-amber-500 rounded-lg border-y-2 border-y-sky-600">
                        #La section {{ $type }}
                    </h5>
                    @foreach ($infos as $school_info)
                        @if($school_info->subscription?->is_active)
                            <div class="border border-r-gray-500 bg-black/60 p-3 letter-spacing-1 rounded-xl shadow-inner shadow-sky-400">
                                <h4 class="text-start text-purple-400 font-bold uppercase">
                                    # Annonce | Info N° {{$loop->iteration}}
                                </h4>
                                <div class="text-gray-300 text-base md:text-lg">
                                    {{ $school_info->content }}
                                </div>
                                <div class="my-3 flex justify-end gap-x-2">
                                    @auth
                                        @if(__ensureThatAssistantCan(auth_user_id(), $school->id, ['infos-manager']))
                                            <button wire:click="manageSchoolInfo({{$school_info->id}})" class="cursor-pointer shadow-sm bg-blue-500 hover:bg-blue-700 text-white p-2">
                                                <span wire:loading.remove wire:target="manageSchoolInfo({{$school_info->id}})">
                                                    <span class="fas fa-newspaper"></span>
                                                    <span>Modifier</span>
                                                </span>
                                                <span wire:loading wire:target="manageSchoolInfo({{$school_info->id}})">
                                                    <span class="fas fa-rotate animate-spin mr-1.5"></span>
                                                    <span>En cours...</span>
                                                </span>
                                            </button>
                                            <button class="cursor-pointer shadow-sm bg-amber-500 hover:bg-amber-700 text-white p-2">
                                                <span class="fas fa-eye-slash"></span>
                                                <span>Masquer</span>
                                            </button>
                                            <button class="cursor-pointer shadow-sm bg-red-500 hover:bg-red-700 text-white p-2">
                                                <span class="fas fa-trash"></span>
                                                <span>Supprimer</span>
                                            </button>
                                        @endif
                                    @endauth
                                </div>
                            </div>
                        @endif
                    @endforeach
                @endforeach
            </div>
        </div>

        
    </div>
    <div 
        x-show="show"
        x-transition:enter="transition ease-out duration-300"
        x-transition:enter-start="opacity-0 scale-75"
        x-transition:enter-end="opacity-100 scale-100"
        x-transition:leave="transition ease-in duration-200"
        x-transition:leave-start="opacity-100 scale-100"
        x-transition:leave-end="opacity-0 scale-75"
        class="fixed inset-0 bg-black/95 flex flex-col items-center justify-center z-50"
        style="display: none;"
        @click="show = false"
    >
        <h5 class="mx-auto flex flex-col gap-y-1 text-sm w-auto text-center p-3 font-semibold letter-spacing-1 bg-black/75 my-3" >
            <span class=" text-sky-500 uppercase" x-text="schoolName"></span>
            <span class=" text-yellow-500" x-text="simple_name"></span>
            <span class=" text-amber-600" x-text="title"></span>
        </h5>
        <img :src="currentImage" alt="Zoom" class="w-screen md:max-w-xl max-h-[90vh] shadow-md border shadow-sky-400 border-white" @click.stop>
        
    </div>
</div>
